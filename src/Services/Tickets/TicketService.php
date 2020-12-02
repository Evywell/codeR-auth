<?php


namespace App\Services\Tickets;


use App\Database\Entity\Game;
use App\Database\Entity\GameKey;
use App\Database\Entity\Ticket;
use App\Database\Entity\User;
use App\Services\JWTTokenManager;
use Doctrine\ORM\EntityManagerInterface;

class TicketService
{

    private EntityManagerInterface $em;
    private string $passphrase;
    private JWTTokenManager $tokenManager;

    public function __construct(
        EntityManagerInterface $em,
        JWTTokenManager $tokenManager,
        string $passphrase
    ) {
        $this->em = $em;
        $this->passphrase = $passphrase;
        $this->tokenManager = $tokenManager;
    }

    /**
     * @param Game $game
     * @param User $user
     * @return string The JWT Ticket
     */
    public function createTicketForGame(Game $game, User $user): string
    {
        $keys = $this->getKeysForGame($game);

        $ticket = (new Ticket())
            ->setEmail($user->getEmail())
            ->setGame($game)
        ;

        $token = $this->tokenManager->create($ticket, $keys->getPrivateKeyName(), $this->passphrase);

        return (string) $token;
    }

    /**
     * @param Game $game
     * @return GameKey|null
     */
    private function getKeysForGame(Game $game): ?GameKey
    {
        /** @var GameKey $game */
        $game = $this
            ->em
            ->getRepository(GameKey::class)
            ->findOneBy(['game' => $game]);

        return $game;
    }

}