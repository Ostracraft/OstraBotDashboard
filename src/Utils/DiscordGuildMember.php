<?php

namespace App\Utils;


use Wohali\OAuth2\Client\Provider\DiscordResourceOwner;

class DiscordGuildMember
{

    private array $roles;
    private string|null $nickname;
    private mixed $premiumSince;
    private mixed $joinedAt;
    private bool $isPending;
    private DiscordResourceOwner $user;
    private bool $mute;
    private bool $deaf;

    /**
     * DiscordGuildMember constructor.
     * @param array $roles
     * @param string|null $nickname
     * @param mixed $premiumSince
     * @param mixed $joinedAt
     * @param bool $isPending
     * @param array $user
     * @param bool $mute
     * @param bool $deaf
     */
    public function __construct(array $roles, string|null $nickname, mixed $premiumSince, mixed $joinedAt, bool $isPending, array $user, bool $mute, bool $deaf)
    {
        $this->roles = $roles;
        $this->nickname = $nickname;
        $this->premiumSince = $premiumSince;
        $this->joinedAt = $joinedAt;
        $this->isPending = $isPending;
        $this->user = new DiscordResourceOwner($user);
        $this->mute = $mute;
        $this->deaf = $deaf;
    }

    /**
     * @param array $array
     * @return static
     */
    public static function fromArray(array $array): self
    {
        return new DiscordGuildMember($array['roles'], $array['nick'], $array['premium_since'], $array['joined_at'], $array['pending'], $array['user'], $array['mute'], $array['deaf']);
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return mixed
     */
    public function getPremiumSince(): mixed
    {
        return $this->premiumSince;
    }

    /**
     * @return mixed
     */
    public function getJoinedAt(): mixed
    {
        return $this->joinedAt;
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->isPending;
    }

    /**
     * @return DiscordResourceOwner
     */
    public function getUser(): DiscordResourceOwner
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function isMute(): bool
    {
        return $this->mute;
    }

    /**
     * @return bool
     */
    public function isDeaf(): bool
    {
        return $this->deaf;
    }


}