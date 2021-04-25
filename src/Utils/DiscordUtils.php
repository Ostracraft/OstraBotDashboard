<?php

namespace App\Utils;


use InvalidArgumentException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

class DiscordUtils
{

    public const DISCORD_API = "https://discord.com/api/v8";

    /**
     * Get the avatar url of a Discord user, from hash and client id.
     *
     * @param DiscordResourceOwner $discordUser
     * @param string $extension
     * @return string|null
     */
    public static function getAvatarUrl(DiscordResourceOwner $discordUser, string $extension = ".png"): string|null
    {
        if (!in_array($extension, ['.png', '.jpg', '.jpeg', '.wepb', '.gif']))
            throw new InvalidArgumentException("This extension is invalid !");
        if ($discordUser->getId() == null || $discordUser->getAvatarHash() == null)
            return null;
        return "https://cdn.discordapp.com/avatars/" . $discordUser->getId() . "/" . $discordUser->getAvatarHash() . $extension;
    }

    /**
     * Get a DiscordGuild from ID and Discord API
     * @param HttpClientInterface $client
     * @param String $id
     * @return DiscordGuild|null
     */
    public static function getGuild(HttpClientInterface $client, string $id): ?DiscordGuild
    {
        try {
            $response = $client->request(
                "GET",
                DiscordUtils::DISCORD_API . "/guilds/" . $id . "?with_counts=true",
                [
                    'headers' => [
                        'Authorization' => "Bot " . $_ENV['BOT_TOKEN']
                    ]
                ]
            );
            $json = json_decode($response->getContent(), true);
            return DiscordGuild::fromArray($json);
        } catch (TransportExceptionInterface | ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface $e) {
            return null;
        }
    }
}