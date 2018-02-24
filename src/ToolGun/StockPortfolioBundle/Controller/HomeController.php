<?php

namespace ToolGun\StockPortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('@ToolGunStockPortfolio/Home/index.html.twig');
    }
}
