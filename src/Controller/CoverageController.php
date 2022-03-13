<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoverageController extends AbstractController
{
    /**
     * @Route("/coverage", name="coverage_controller")
     */
    public function index(): Response
    {
        return $this->render('coverage/dashboard.html');
    }
}