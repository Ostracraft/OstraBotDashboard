<?php

namespace App\Controller;


use App\Utils\DiscordUtils;
use App\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class DashboardController
 * @package App\Controller
 *
 * @Route("/dashboard")
 */
class DashboardController extends AbstractController
{

    private RouterInterface $router;
    private HttpClientInterface $httpClient;

    /**
     * DashboardController constructor.
     * @param RouterInterface $router
     * @param HttpClientInterface $httpClient
     */
    public function __construct(RouterInterface $router, HttpClientInterface $httpClient)
    {
        $this->router = $router;
        $this->httpClient = $httpClient;
    }


    /**
     * @Route("", name="dashboard:home")
     * @return Response
     */
    public function home(): Response
    {
        if (!$this->isGranted('ROLE_USER'))
            return new RedirectResponse($this->generateUrl("index:home"));
        return $this->render("dashboard/home.html.twig", [
            'guild' => DiscordUtils::getGuild($this->httpClient, $_ENV['DISCORD_GUILD_ID']),
            'motd' => Utils::getMotd($this->router, $this->httpClient)
        ]);
    }

}