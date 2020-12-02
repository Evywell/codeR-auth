<?php


namespace App\Controller;


use App\Database\Entity\Game;
use App\Database\Entity\GameKey;
use App\Database\Repository\GameKeyRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CertificatesController
 * @package App\Controller
 * @Route("/certs")
 */
class CertificatesController extends AbstractController
{

    /**
     * @Route("/{game}", requirements={"game"="[a-z0-9\-]{3,}"})
     * @Entity("game", expr="repository.findOneBySlug(game)")
     *
     * @param Game $game
     * @return Response
     */
    public function view(Game $game): Response
    {
        $opensslPublicKeysPath = $this->getParameter('opensslPublicKeysPath');

        /** @var GameKeyRepository $gameKeyRepository */
        $gameKeyRepository = $this->getDoctrine()->getRepository(GameKey::class);

        /** @var GameKey $gameKey */
        $gameKey = $gameKeyRepository->findOneBy(['game' => $game]);

        $publicKey = file_get_contents(
            $opensslPublicKeysPath .
            DIRECTORY_SEPARATOR .
            $gameKey->getPublicKeyName()
        );

        return $this->json([
            'publicKey' => base64_encode($publicKey),
            'signer' => 'RSA256'
        ]);
    }

}