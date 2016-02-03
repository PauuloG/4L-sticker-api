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

        return new Response($stickers);
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
        $form->submit($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sticker);
            $em->flush();

            return new JsonResponse(array(
                'status' => 1,
                'id' => $sticker->getId()));
        } else {

            return new JsonResponse(array(
                'status' => 0,
                'errors' => $form->getErrorsAsString()));

        }

        return new JsonResponse(array(
            'status' => 0,
            'errors' => $serializer->serialize($form, 'json')));

    }

}
