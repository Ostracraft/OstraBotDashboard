<?php


namespace App\Utils;


class DiscordGuild
{

    private string $id;
    private string $name;
    private string $icon;
    private int $memberCount;

    /**
     * DiscordGuild constructor.
     * @param String $id
     * @param String $name
     * @param String $icon
     * @param int $memberCount
     */
    public function __construct(string $id, string $name, string $icon, int $memberCount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->icon = $icon;
        $this->memberCount = $memberCount;
    }

    /**
     * Get a DiscordGuild from an array
     * @param array $array
     * @return DiscordGuild
     */
    public static function fromArray(array $array): DiscordGuild
    {
        return new DiscordGuild(
            $array['id'],
            $array['name'],
            $array['icon'],
            $array['approximate_member_count'],
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @return int
     */
    public function getMemberCount(): int
    {
        return $this->memberCount;
    }


}