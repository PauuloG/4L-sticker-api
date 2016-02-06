<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Sticker;
use AppBundle\Form\StickerType;

/**
 * Sticker controller.
 *
 */
class StickerController extends Controller
{
    /**
     * Lists all Sticker entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');

        $stickers = $em->getRepository('AppBundle:Sticker')->findAll();

        $stickers = $serializer->serialize($stickers, 'json');

        $response =  new Response($stickers);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT');
        return $response;
    }

    /**
     * Creates a new Sticker entity.
     *
     */
    public function newAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $sticker = new Sticker();

        $form = $this->createForm('AppBundle\Form\StickerType', $sticker);
        // $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isSubmitted() ) {//&& $form->isValid()
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($sticker);
            $em->flush();

            $response = new JsonResponse(array(
                'status' => 1,
                'id' => $sticker->getId(),
            ));

            return $response;
        } else {

            $response = new JsonResponse(array(
                'status' => 0,
                'errors' => $form->getErrorsAsString()));
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT');
            return $response;

        }

        $response = new JsonResponse(array(
            'status' => 2,
            'errors' => $form->getErrorsAsString()));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT');
        return $response;

    }
}
