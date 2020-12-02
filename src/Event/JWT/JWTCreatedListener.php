<?php


namespace App\Event\JWT;


use App\Database\Entity\Game;
use App\Database\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\Serializer\SerializerInterface;

class JWTCreatedListener
{

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Event called when a JWT token is created
     *
     * @param JWTCreatedEvent $event
     */
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $this->handleJWTCreatedUser($event);
    }

    /**
     * @param JWTCreatedEvent $event
     */
    private function handleJWTCreatedUser(JWTCreatedEvent $event): void
    {
        /** @var User $user */
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $payload = $event->getData();
        $payload['games'] = array_reduce($user->getGames()->toArray(), function (array $carry, Game $game) {
            $carry[] = $this->serializer->normalize($game);

            return $carry;
        }, []);

        $event->setData($payload);
    }

}