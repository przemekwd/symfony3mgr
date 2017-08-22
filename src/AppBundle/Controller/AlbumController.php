<?php

namespace AppBundle\Controller;

use AppBundle\Service\AlbumCoverUploader;
use DateTime;
use Exception;
use AppBundle\Entity\Album;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * Album controller.
 *
 * @Route("album")
 */
class AlbumController extends Controller
{
    /**
     * Lists all album entities.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="album_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $albums = $em->getRepository('AppBundle:Album')
            ->findAll($request->get('filter'), $request->get('search'));

        return $this->render('album/index.html.twig', array(
            'albums' => $albums,
            'search' => $request->get('search'),
        ));
    }

    /**
     * Creates a new album entity.
     *
     * @Route("/new", name="album_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $album = new Album();
        $form = $this->createForm('AppBundle\Form\AlbumType', $album)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.add', [], 'AppBundle'),
                'attr' => [
                    'class' => 'btn btn-success pull-right',
                    'role' => 'button',
            ]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coverUpload = $this->container->get(AlbumCoverUploader::class);
            $album->setCover($coverUpload->upload($album->getCover()));
            $album->setCreated(new DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/new.html.twig', array(
            'album' => $album,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a album entity.
     *
     * @Route("/{id}", name="album_show")
     * @Method("GET")
     */
    public function showAction(Album $album)
    {
        $deleteForm = $this->createDeleteForm($album, 'danger');

        return $this->render('album/show.html.twig', array(
            'album' => $album,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing album entity.
     *
     * @Route("/{id}/edit", name="album_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Album $album)
    {
        try {
            $album->setCover(
                new File($this->getParameter('developer_logo_directory') . '/' . $album->getCover())
            );
        } catch (Exception $e) {
            $album->setCover('');
        }

        $deleteForm = $this->createDeleteForm($album, 'default');
        $editForm = $this->createForm('AppBundle\Form\AlbumType', $album)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.edit', [], 'AppBundle'),
                'attr' => [
                    'class' => 'btn btn-warning pull-right',
                    'role' => 'button',
                ]]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $coverUpload = $this->container->get(AlbumCoverUploader::class);
            $album->setCover($coverUpload->upload($album->getCover()));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('album_index', array('id' => $album->getId()));
        }

        return $this->render('album/edit.html.twig', array(
            'album' => $album,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a album entity.
     *
     * @Route("/{id}", name="album_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Album $album)
    {
        $form = $this->createDeleteForm($album, 'danger');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($album);
            $em->flush();
        }

        return $this->redirectToRoute('album_index');
    }

    /**
     * Creates a form to delete a album entity.
     *
     * @param Album $album The album entity
     * @param string $class Class for delete button
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Album $album, string $class)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('album_delete', array('id' => $album->getId())))
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
