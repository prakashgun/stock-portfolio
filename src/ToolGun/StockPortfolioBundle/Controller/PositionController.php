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

        return $this->render('@ToolGunStockPortfolio/Position/index.html.twig', array(
            'positions' => $positions,
        ));
    }

    /**
     * Finds and displays a position entity.
     * @param Position $position
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Position $position)
    {

        return $this->render('@ToolGunStockPortfolio/Position/show.html.twig', array(
            'position' => $position,
        ));
    }
}
