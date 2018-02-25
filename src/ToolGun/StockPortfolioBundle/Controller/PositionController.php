<?php

namespace ToolGun\StockPortfolioBundle\Controller;

use ToolGun\StockPortfolioBundle\Entity\Position;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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

        return $this->render('position/index.html.twig', array(
            'positions' => $positions,
        ));
    }

    /**
     * Finds and displays a position entity.
     *
     */
    public function showAction(Position $position)
    {

        return $this->render('position/show.html.twig', array(
            'position' => $position,
        ));
    }
}
