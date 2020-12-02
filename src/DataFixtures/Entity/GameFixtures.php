<?php


namespace App\DataFixtures\Entity;


use App\Database\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture
{

    public const
        ROB_GAME_REFERENCE = 'rob-game'
    ;

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $robGame = new Game();
        $robGame
            ->setName("ROB")
            ->setSlug("rob")
        ;

        $manager->persist($robGame);
        $manager->flush();

        $this->addReference(self::ROB_GAME_REFERENCE, $robGame);
    }
}