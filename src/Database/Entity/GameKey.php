<?php

namespace App\Database\Entity;

use App\Database\Repository\GameKeyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameKeyRepository::class)
 */
class GameKey
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $publicKeyName;

    /**
     * @ORM\Column(type="string")
     */
    private string $privateKeyName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Database\Entity\Game")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     */
    private Game $game;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublicKeyName(): string
    {
        return $this->publicKeyName;
    }

    public function getPrivateKeyName(): string
    {
        return $this->privateKeyName;
    }

    public function getGame(): Game
    {
        return $this->game;
    }
}
