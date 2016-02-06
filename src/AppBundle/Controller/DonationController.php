<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Donation;
use AppBundle\Form\DonationType;

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

        // $em->flush();

        $data['donations'] = $donations;

        //$html = $this->renderView('sticker.html.twig', $data);

        // return new Response(
        //     $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
        //     200,
        //     array(
        //         'Content-Type'          => 'application/pdf',
        //         'Content-Disposition'   => 'attachment; filename="file.pdf"',
        //         'page-width' => '148mm',
        //         'page-length' => '210mm'
        //     )
        // );

        return $this->render('default/index.html.twig', $data);

    }

    /**
     * Creates a new Donation entity.
     *
     */
    public function newAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $donation = new Donation();

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
