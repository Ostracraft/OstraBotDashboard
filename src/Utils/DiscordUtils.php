<?php

namespace App\Utils;


use InvalidArgumentException;
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
}