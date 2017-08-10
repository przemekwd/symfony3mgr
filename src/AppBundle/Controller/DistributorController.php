<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Distributor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Distributor controller.
 *
 * @Route("distributor")
 */
class DistributorController extends Controller
{
    /**
     * Lists all distributor entities.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="distributor_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $distributors = $em->getRepository('AppBundle:Distributor')
            ->findAll($request->get('filter'));

        return $this->render('distributor/index.html.twig', array(
            'distributors' => $distributors,
        ));
    }

    /**
     * Creates a new distributor entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/new", name="distributor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $distributor = new Distributor();
        $form = $this->createForm('AppBundle\Form\DistributorType', $distributor)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.add', [], 'AppBundle'),
                'attr' => [
                    'class' => 'btn btn-success pull-right',
                    'role' => 'button',
                ]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($distributor);
            $em->flush();

            return $this->redirectToRoute('distributor_index');
        }

        return $this->render('distributor/new.html.twig', array(
            'distributor' => $distributor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a distributor entity.
     *
     * @param Distributor $distributor
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}", name="distributor_show")
     * @Method("GET")
     */
    public function showAction(Distributor $distributor)
    {
        $deleteForm = $this->createDeleteForm($distributor, 'danger');

        return $this->render('distributor/show.html.twig', array(
            'distributor' => $distributor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing distributor entity.
     *
     * @param Request $request
     * @param Distributor $distributor
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="distributor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Distributor $distributor)
    {
        $deleteForm = $this->createDeleteForm($distributor, 'default');
        $editForm = $this->createForm('AppBundle\Form\DistributorType', $distributor)
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('buttons.edit', [], 'AppBundle'),
                'attr' => [
                    'class' => 'btn btn-warning pull-right',
                    'role' => 'button',
                ]]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('distributor_edit', array('id' => $distributor->getId()));
        }

        return $this->render('distributor/edit.html.twig', array(
            'distributor' => $distributor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a distributor entity.
     *
     * @param Request $request
     * @param Distributor $distributor
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}", name="distributor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Distributor $distributor)
    {
        $form = $this->createDeleteForm($distributor, 'danger');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($distributor);
            $em->flush();
        }

        return $this->redirectToRoute('distributor_index');
    }

    /**
     * Creates a form to delete a distributor entity.
     *
     * @param Distributor $distributor The distributor entity
     * @param string $class Class for delete button
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Distributor $distributor, string $class)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('distributor_delete', array('id' => $distributor->getId())))
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
