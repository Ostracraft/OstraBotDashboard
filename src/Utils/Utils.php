<?php

namespace App\Utils;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class Utils, various methods
 * @package App\Utils
 */
class Utils
{

    /**
     * @param RouterInterface $router
     * @param HttpClientInterface $client
     * @return String
     */
    public static function getMotd(RouterInterface $router, HttpClientInterface $client): string
    {
        $url = $router->getContext()->getScheme() . "://" . $router->getContext()->getHost();
        if ($router->getContext()->getScheme() == "https" && $router->getContext()->getHttpsPort() != "443")
            $url = $url . ":" . $router->getContext()->getHttpsPort();
        else if ($router->getContext()->getScheme() == "http" && $router->getContext()->getHttpsPort() != "80")
            $url = $url . ":" . $router->getContext()->getHttpPort();
        $url = $url . "/motd.txt";
        try {
            $response = $client->request(
                "GET",
                $url,
                ['verify_peer' => false, 'verify_host' => false]
            );
            $motd = $response->getContent();
        } catch (TransportExceptionInterface | ClientExceptionInterface | ServerExceptionInterface | RedirectionExceptionInterface$e) {
            return "Error while trying to get motd !";
        }
        return $motd;
    }

}