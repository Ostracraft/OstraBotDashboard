<?php

namespace App\Controller;


use App\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller
 *
 * @Route("/dashboard")
 */
class DashboardController extends AbstractController
{

    /**
     * @Route("", name="dashboard:home")
     * @return Response
     */
    public function home(): Response
    {
        if (!$this->isGranted('ROLE_USER'))
            return new RedirectResponse($this->generateUrl("index:home"));
        return $this->render("dashboard/home.html.twig", [
            'motd' => Utils::getMotd()
        ]);
    }

}