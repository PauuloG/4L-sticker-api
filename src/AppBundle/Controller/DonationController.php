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

        $em->flush();

        $data['containers'] = [];

        $c = 0;

        for ($i=0; $i < count($donations) ; $i++) {

            if( !($i % 6) ){
                $c +=1;
            }

            $data['containers'][$c][] = $donations[$i] ;

        }

        $html = $this->renderView('sticker.html.twig', $data);

        return $this->render('sticker.html.twig', $data);

    }

    /**
     * Creates a new Donation entity.
     *
     */
    public function newAction(Request $request)
    {
        $logger = $this->get('logger');
        $api = new Api(array(
            'sandbox' => true
        ));

        foreach ($request->request->all() as $key => $value) {
            $logger->info($key.' : '.$value);
        }

        if (Api::NOTIFY_VERIFIED === $api->notifyValidate($_POST)) {
            $logger->info('valid ipn');

            // $donation = new Donation();

            // $sticker = $em->getRepository('AppBundle:Sticker')->findOneById()

            return new JsonResponse(array('status' => 0, 'notification' => 'Valid IPN'));
        }
        else {
            $logger->info('invalid ipn');
            return new JsonResponse(array('status' => 0, 'notification' => 'Not a valid IPN'));
        }

    //     $post = $request->request->all();
    //     $logger = $this->get('logger');
    //     $em = $this->getDoctrine()->getManager();
       //
    //     $donation = new Donation();
       //
    //     $sticker = $em->getRepository('AppBundle:Sticker')->findOneById($post['transaction_subject']);
       //
    //     $donation->setAmount(5);
    //     $donation->setSticker($sticker);
    //     $donation->setPaypalTransactionId($post['ipn_track_id']);
       //
    //     $em->persist($donation);
    //     $em->flush();
       //
    //     foreach ($request->request->all() as $key => $value) {
    //         $logger->info($key.' : '.$value);
    //     }
    //     $logger->info('tapé');
       //
    //    $response = new JsonResponse(array('status' => 1));
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
