<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Artist controller.
 *
 * @Route("artist")
 */
class ArtistController extends Controller
{
    /**
     * Lists all artist entities.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="artist_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $artists = $em->getRepository('AppBundle:Artist')
            ->findAll($request->get('filter'), $request->get('search'));

        return $this->render('artist/index.html.twig', array(
            'artists' => $artists,
            'search' => $request->get('search'),
        ));
    }

    /**
     * Creates a new artist entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/new", name="artist_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $artist = new Artist();
        $form = $this->createForm('AppBundle\Form\ArtistType', $artist)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.add', [], 'AppBundle'),
                'attr' => [
                    'class' => 'btn btn-success pull-right',
                    'role' => 'button',
                ]]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($artist);
            $em->flush();

            return $this->redirectToRoute('artist_index');
        }

        return $this->render('artist/new.html.twig', array(
            'artist' => $artist,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a artist entity.
     *
     * @param Artist $artist
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}", name="artist_show")
     * @Method("GET")
     */
    public function showAction(Artist $artist)
    {
        $deleteForm = $this->createDeleteForm($artist, 'danger');

        return $this->render('artist/show.html.twig', array(
            'artist' => $artist,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing artist entity.
     *
     * @param Request $request
     * @param Artist $artist
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="artist_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Artist $artist)
    {
        $deleteForm = $this->createDeleteForm($artist,'default');
        $editForm = $this->createForm('AppBundle\Form\ArtistType', $artist)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.edit', [], 'AppBundle'),
                'attr' => [
                    'class' => 'btn btn-warning pull-right',
                    'role' => 'button',
                ]]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artist_edit', array('id' => $artist->getId()));
        }

        return $this->render('artist/edit.html.twig', array(
            'artist' => $artist,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a artist entity.
     *
     * @param Request $request
     * @param Artist $artist
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}", name="artist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Artist $artist)
    {
        $form = $this->createDeleteForm($artist,'danger');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($artist);
            $em->flush();
        }

        return $this->redirectToRoute('artist_index');
    }

    /**
     * Creates a form to delete a artist entity.
     *
     * @param Artist $artist The artist entity
     * @param string $class Class for delete button
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Artist $artist, string $class)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('artist_delete', array('id' => $artist->getId())))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.delete', [], 'AppBundle'),
                'attr' => [
                    'class' => 'btn btn-' . $class . ' pull-right',
                    'role' => 'button',
                ],
            ])
            ->getForm()
        ;
    }
}
