<?php

namespace ToolGun\StockPortfolioBundle\Controller;

use ToolGun\StockPortfolioBundle\Entity\Position;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Position controller.
 *
 */
class PositionController extends Controller
{
    /**
     * Lists all position entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $positions = $em->getRepository('ToolGunStockPortfolioBundle:Position')->findAll();

        return $this->render('@ToolGunStockPortfolio/Position/index.html.twig', array(
            'positions' => $positions,
        ));
    }

    /**
     * Creates a new position entity.
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $position = new Position();
        $form = $this->createForm('ToolGun\StockPortfolioBundle\Form\PositionType', $position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($position);
            $em->flush();

            return $this->redirectToRoute('position_show', array('id' => $position->getId()));
        }

        return $this->render('@ToolGunStockPortfolio/Position/new.html.twig', array(
            'position' => $position,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a position entity.
     * @param Position $position
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Position $position)
    {
        $deleteForm = $this->createDeleteForm($position);

        return $this->render('@ToolGunStockPortfolio/Position/show.html.twig', array(
            'position' => $position,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing position entity.
     * @param Request $request
     * @param Position $position
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Position $position)
    {
        $deleteForm = $this->createDeleteForm($position);
        $editForm = $this->createForm('ToolGun\StockPortfolioBundle\Form\PositionType', $position);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('position_edit', array('id' => $position->getId()));
        }

        return $this->render('@ToolGunStockPortfolio/Position/edit.html.twig', array(
            'position' => $position,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a position entity.
     * @param Request $request
     * @param Position $position
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Position $position)
    {
        $form = $this->createDeleteForm($position);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($position);
            $em->flush();
        }

        return $this->redirectToRoute('position_index');
    }

    /**
     * Creates a form to delete a position entity.
     *
     * @param Position $position The position entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Position $position)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('position_delete', array('id' => $position->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
