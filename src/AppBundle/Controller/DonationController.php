<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Donation;
use AppBundle\Form\DonationType;

//bonnjour je suis sur la branche

/**
 * Donation controller.
 *
 */
class DonationController extends Controller
{
    /**
     * Lists all Donation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');

        $donations = $em->getRepository('AppBundle:Donation')->findBy(['printed' => 0]);

        // foreach ($donations as $donation) {
        //     $donation->setPrinted(1);
        //     $em->persist($donation);
        // }

        $data['containers'] = [];

        $c = 0;

        for ($i=0; $i < count($donations) ; $i++) {

            if( !($i % 6) ){
                $c +=1;
            }

            $data['containers'][$c][] = $donations[$i] ;

        }

        // $em->flush();

        $html = $this->renderView('sticker.html.twig', $data);

        // return new Response(
        //     $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
        //     200,
        //     array(
        //         'Content-Type'          => 'application/pdf',
        //         'Content-Disposition'   => 'attachment; filename="file.pdf"',
        //     )
        // );

        return $this->render('sticker.html.twig', $data);

    }

    /**
     * Creates a new Donation entity.
     *
     */
    public function newAction(Request $request)
    {

        $post = $request->request->all();
        $logger = $this->get('logger');
        $em = $this->getDoctrine()->getManager();

        $email_account = "paulgabriel7-facilitator-1@gmail.com";
        $req = 'cmd=_notify-validate';
        foreach ($request->request->all() as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Host: www.sandbox.paypal.com\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
        $item_name = $post['item_name'];
        $item_number = $post['item_number'];
        $payment_status = $post['payment_status'];
        $payment_amount = $post['mc_gross'];
        $payment_currency = $post['mc_currency'];
        $txn_id = $post['txn_id'];
        $receiver_email = $post['receiver_email'];
        $payer_email = $post['payer_email'];
        parse_str($post['custom'],$custom);
        if (!$fp) {
        } else {
        fputs ($fp, $header . $req);
        while (!feof($fp)) {
            $res = fgets ($fp, 1024);
            if (strcmp ($res, "VERIFIED") == 0) {
                // vérifier que payment_status a la valeur Completed
                if ( $payment_status == "Completed") {
                       if ( $email_account == $receiver_email) {
                            if($payment_amount >= 3){
                                $donation = new Donation();

                                $sticker = $em->getRepository('AppBundle:Sticker')->findOneById($custom);

                                $donation->setAmount($payment_amount);
                                $donation->setSticker($sticker);

                                $em->persist($donation);
                                $em->flush();

                                $logger->info('Donation recorded');

                                return new JsonResponse(array('status' => 1));

                            }
                       }
                }
                else {
                    $logger->err('Not Valid amount : '.$payment_amount);
                    return new JsonResponse(array('status' => 0, 'error' => 'Inferior 3'));
                }
                exit();
           }
            else if (strcmp ($res, "INVALID") == 0) {
                $logger->err('Invlid IPN');
                return new JsonResponse(array('status' => 0, 'error' => 'Not Valid'));
            }
        }
        fclose ($fp);
        }

        // $serializer = $this->get('jms_serializer');
        // $donation = new Donation();

        // $form = $this->createForm('AppBundle\Form\DonationType', $donation);
        // $form->submit($request->request->all());

        // if ($form->isSubmitted() ) {//&& $form->isValid()
        //     $data = $form->getData();
        //     $em = $this->getDoctrine()->getManager();
        //     $em->persist($donation);
        //     $em->flush();

        //     $response = new Response($serializer->serialize(array(
        //         'status' => 1,
        //         'donation' => $donation), 'json'));
        //     $response->headers->set('Content-Type', 'application/json');

        //     return $response;
        // } else {

        //     $response = new JsonResponse(array(
        //         'status' => 0,
        //         'errors' => $form->getErrorsAsString()));
        //     return $response;

        // }

        // $response = new JsonResponse(array(
        //     'status' => 2,
        //     'errors' => $form->getErrorsAsString()));

        // return $response;
    }

    /**
     * Displays a form to edit an existing Donation entity.
     *
     */
    public function printedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $donation = $em->getRepository('AppBundle:Donation')->findOneById($id);

        $donation->setPrinted(1);
        $em->persist($donation);
        $em->flush();

        $response = new JsonResponse(array('status' => 1));

        return $response;
    }

}
