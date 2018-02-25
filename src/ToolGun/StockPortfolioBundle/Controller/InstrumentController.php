<?php

namespace ToolGun\StockPortfolioBundle\Controller;

use ToolGun\StockPortfolioBundle\Entity\Instrument;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Instrument controller.
 *
 */
class InstrumentController extends Controller
{
    /**
     * Lists all instrument entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $instruments = $em->getRepository('ToolGunStockPortfolioBundle:Instrument')->findAll();

        return $this->render('@ToolGunStockPortfolio/Instrument/index.html.twig', array(
            'instruments' => $instruments,
        ));
    }

    /**
     * Creates a new instrument entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $instrument = new Instrument();
        $form = $this->createForm('ToolGun\StockPortfolioBundle\Form\InstrumentType', $instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($instrument);
            $em->flush();

            return $this->redirectToRoute('instrument_show', array('id' => $instrument->getId()));
        }

        return $this->render('@ToolGunStockPortfolio/Instrument/new.html.twig', array(
            'instrument' => $instrument,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a instrument entity.
     * @param Instrument $instrument
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Instrument $instrument)
    {
        $deleteForm = $this->createDeleteForm($instrument);

        return $this->render('@ToolGunStockPortfolio/Instrument/show.html.twig', array(
            'instrument' => $instrument,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing instrument entity.
     * @param Request $request
     * @param Instrument $instrument
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Instrument $instrument)
    {
        $deleteForm = $this->createDeleteForm($instrument);
        $editForm = $this->createForm('ToolGun\StockPortfolioBundle\Form\InstrumentType', $instrument);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('instrument_edit', array('id' => $instrument->getId()));
        }

        return $this->render('@ToolGunStockPortfolio/Instrument/edit.html.twig', array(
            'instrument' => $instrument,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a instrument entity.
     * @param Request $request
     * @param Instrument $instrument
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Instrument $instrument)
    {
        $form = $this->createDeleteForm($instrument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($instrument);
            $em->flush();
        }

        return $this->redirectToRoute('instrument_index');
    }

    /**
     * Creates a form to delete a instrument entity.
     *
     * @param Instrument $instrument The instrument entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Instrument $instrument)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('instrument_delete', array('id' => $instrument->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
