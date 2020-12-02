<?php


namespace App\DataFixtures\Entity;


use App\Database\Entity\Game;
use App\Database\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        /** @var Game $robGame */
        $robGame = $this->getReference(GameFixtures::ROB_GAME_REFERENCE);

        // Admin account
        $admin = new User();
        $admin
            ->setEmail('admin@localhost')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->encodePassword($admin, 'admin'))
            ->addGame($robGame)
        ;

        $manager->persist($admin);
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [
            GameFixtures::class
        ];
    }
}