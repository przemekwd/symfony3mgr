<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Album;
use AppBundle\Entity\Track;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Track controller.
 *
 * @Route("/")
 */
class TrackController extends Controller
{
    /**
     * Creates a new track entity.
     *
     * @Route("/album/{albumid}/track/new", name="track_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $track = new Track();
        $album = $this->getDoctrine()
            ->getRepository(Album::class)
            ->find($request->get('albumid'));
        $track->setAlbum($album);
        $form = $this->createForm('AppBundle\Form\TrackType', $track)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.add', [], 'AppBundle'),
                'attr' => [
                    'class' => 'btn btn-success pull-right',
                    'role' => 'button',
            ]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($track);
            $em->flush();

            return $this->redirectToRoute('album_show', array('id' => $album->getId()));
        }

        return $this->render('track/new.html.twig', array(
            'track' => $track,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing track entity.
     *
     * @Route("/album/{albumid}/track/{id}/edit", name="track_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Track $track)
    {
        $album = $this->getDoctrine()
            ->getRepository(Album::class)
            ->find($request->get('albumid'));

        $editForm = $this->createForm('AppBundle\Form\TrackType', $track)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.edit', [], 'AppBundle'),
                'attr' => [
                    'class' => 'btn btn-warning pull-right',
                    'role' => 'button',
            ]]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('album_show', ['id' => $album->getId()]);
        }

        return $this->render('track/edit.html.twig', [
            'track' => $track,
            'edit_form' => $editForm->createView(),
        ]);
    }

    /**
     * Deletes a track entity.
     *
     * @Route("/album/{albumid}/track/{id}", name="track_delete")
     */
    public function deleteAction(Request $request, Track $track)
    {
        $album = $this->getDoctrine()
            ->getRepository(Album::class)
            ->find($request->get('albumid'));

        $em = $this->getDoctrine()->getManager();
        $em->remove($track);
        $em->flush();

        return $this->redirectToRoute('album_show', ['id' => $album->getId()]);
    }
}
