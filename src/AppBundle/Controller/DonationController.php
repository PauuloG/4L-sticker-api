<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Donation;
use AppBundle\Form\DonationType;
use Payum\Paypal\Ipn\Api;

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

        foreach ($donations as $donation) {
            $donation->setPrinted(1);
            $em->persist($donation);
        }

        $data['containers'] = [];

        $c = 0;

        for ($i=0; $i < count($donations) ; $i++) {

            if( !($i % 6) ){
                $c +=1;
            }

            $data['containers'][$c][] = $donations[$i] ;

        }

        $em->flush();

        $html = $this->renderView('sticker.html.twig', $data);

        return $this->render('sticker.html.twig', $data);

    }

    /**
     * Creates a new Donation entity.
     *
     */
    public function newAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $donation = new Donation();

        // STEP 1: Read POST data

        // reading posted data from directly from $_POST causes serialization
        // issues with array data in POST
        // reading raw POST data from input stream instead.
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
          $keyval = explode ('=', $keyval);
          if (count($keyval) == 2)
             $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
           $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
           if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
           } else {
                $value = urlencode($value);
           }
           $req .= "&$key=$value";
        }

        // STEP 2: Post IPN data back to paypal to validate

        $ch = \curl_init('https://www.paypal.com/cgi-bin/webscr'); // change to [...]sandbox.paypal[...] when using sandbox to test
        \curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        \curl_setopt($ch, CURLOPT_POST, 1);
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        \curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        \curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        \curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        \curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        \curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        // In wamp like environments that do not come bundled with root authority certificates,
        // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
        // of the certificate as shown below.
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
        if( !($res = curl_exec($ch)) ) {
            // error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        \curl_close($ch);


        // STEP 3: Inspect IPN validation result and act accordingly

        if (strcmp ($res, "VERIFIED") == 0) {
            // check whether the payment_status is Completed
            // check that txn_id has not been previously processed
            // check that receiver_email is your Primary PayPal email
            // check that payment_amount/payment_currency are correct
            // process payment

            // assign posted variables to local variables
            $item_name = $_POST['item_name'];
            $item_number = $_POST['item_number'];
            $payment_status = $_POST['payment_status'];
            if ($_POST['mc_gross'] != NULL)
                $payment_amount = $_POST['mc_gross'];
            else
                $payment_amount = $_POST['mc_gross1'];
            $payment_currency = $_POST['mc_currency'];
            $txn_id = $_POST['txn_id'];
            $receiver_email = $_POST['receiver_email'];
            $payer_email = $_POST['payer_email'];
            $custom = $_POST['custom'];

            return new JsonResponse(array(
                'status' => 1,
                'custom' => $custom));

        } else if (strcmp ($res, "INVALID") == 0) {
            return new JsonResponse(array(
                'status' => 0,
                'custom' => 'undefined'));
        }

        $form = $this->createForm('AppBundle\Form\DonationType', $donation);
        $form->submit($request->request->all());

        if ($form->isSubmitted() ) {//&& $form->isValid()
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($donation);
            $em->flush();

            $response = new Response($serializer->serialize(array(
                'status' => 1,
                'donation' => $donation), 'json'));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        } else {

            $response = new JsonResponse(array(
                'status' => 0,
                'errors' => $form->getErrorsAsString()));
            return $response;

        }

        $response = new JsonResponse(array(
            'status' => 2,
            'errors' => $form->getErrorsAsString()));

        return $response;
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
