<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IndexController extends AbstractController
{

    private HttpClientInterface $httpClient;

    /**
     * IndexController constructor.
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @Route("", name="index:home")
     * @return Response
     */
    public function home(): Response
    {
        if ($this->isGranted('ROLE_USER'))
            return new RedirectResponse($this->generateUrl("dashboard:home"));
        return $this->render("index/home.html.twig", [
            'discordLink' => $_ENV['DISCORD_GUILD_INVITE'] ?? "#",
            'loginLink' => $this->generateUrl("index:login"),
        ]);
    }

    /**
     * @Route("/index.html", name="index:indexhtml")
     * @return RedirectResponse
     */
    public function indexHtml(): RedirectResponse {
        return new RedirectResponse($this->generateUrl("index:home"));
    }
    /**
     * @Route("/index.php", name="index:indexphp")
     * @return RedirectResponse
     */
    public function indexPhp(): RedirectResponse {
        return new RedirectResponse($this->generateUrl("index:home"));
    }
    /**
     * @Route("/index", name="index:index")
     * @return RedirectResponse
     */
    public function index(): RedirectResponse {
        return new RedirectResponse($this->generateUrl("index:home"));
    }

    /**
     * @Route("/login", name="index:login")
     * @param ClientRegistry $registry
     * @return Response
     */
    public function login(ClientRegistry $registry): Response
    {
        if ($this->isGranted('ROLE_USER'))
            return new RedirectResponse($this->generateUrl("dashboard:home"));
        return $registry
            ->getClient('discord')
            ->redirect(['identify'], []);
    }
}