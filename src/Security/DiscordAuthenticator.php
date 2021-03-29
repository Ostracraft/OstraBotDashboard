<?php

namespace App\Security;

use App\Entity\User;
use App\Utils\DiscordGuildMember;
use App\Utils\DiscordUtils;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

class DiscordAuthenticator extends SocialAuthenticator
{

    private ClientRegistry $registry;
    private RouterInterface $router;
    private EntityManagerInterface $em;
    private HttpClientInterface $httpClient;

    /**
     * DiscordAuthenticator constructor.
     * @param ClientRegistry $registry
     * @param RouterInterface $router
     * @param EntityManagerInterface $em
     * @param HttpClientInterface $httpClient
     */
    public function __construct(ClientRegistry $registry, RouterInterface $router, EntityManagerInterface $em, HttpClientInterface $httpClient)
    {
        $this->registry = $registry;
        $this->router = $router;
        $this->em = $em;
        $this->httpClient = $httpClient;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate('home'));
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'connect_discord_check';
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->registry->getClient('discord'));
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var OAuth2Client $client */
        $client = $this->registry->getClient('discord');
        // dd($client);
        /** @var DiscordResourceOwner $discordUser */
        $discordUser = $client->fetchUserFromToken($credentials);
        $user = new User();
        $user->setId($discordUser->getId());
        $user->setUsername($discordUser->getUsername());
        $user->setAvatarUrl(DiscordUtils::getAvatarUrl($discordUser));

        try {
            $response = $this->httpClient->request(
                'GET',
                DiscordUtils::DISCORD_API . "/guilds/" . $_ENV['DISCORD_GUILD_ID'] . "/members/" . $user->getId(),
                [
                    'headers' => [
                        'Authorization' => "Bot " . $_ENV['BOT_TOKEN']
                    ]
                ]);
        } catch (TransportExceptionInterface $e) {
            throw new TransportException();
        }
        try {
            $content = $response->getContent();
        } catch (ClientExceptionInterface | TransportExceptionInterface | ServerExceptionInterface | RedirectionExceptionInterface $e) {
            throw new Exception();
        }
        $json = json_decode($content, true);
        $guildMember = DiscordGuildMember::fromArray($json);
        $user->setDiscordRoles($guildMember->getRoles());

        if (in_array($_ENV['DISCORD_GUILD_STAFF_ROLE_ID'], $user->getDiscordRoles()))
            $roles = ['ROLE_USER', 'ROLE_STAFF'];
        else
            $roles = ['ROLE_USER'];
        $user->setRoles($roles);

        return $user;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return RedirectResponse
     * @codeCoverageIgnore The Discord OAuth authentication cannot be unit tested.
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): RedirectResponse
    {
        return new RedirectResponse($this->router->generate("index:home"));
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new RedirectResponse($this->router->generate("index:home"));
    }
}