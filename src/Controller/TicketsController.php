<?php


namespace App\Controller;


use App\Database\Entity\Game;
use App\Database\Entity\User;
use App\Services\Tickets\TicketService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TicketsController
 * @package App\Controller
 *
 * @Route("/tickets")
 */
class TicketsController extends AbstractController
{

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/create/{game}", methods={"POST"})
     * @Entity("game", expr="repository.findOneBySlug(game)")
     *
     * @param Game $game
     * @param TicketService $ticketService
     * @return JsonResponse
     */
    public function create(Game $game, TicketService $ticketService): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->hasGame($game)) {
            throw new BadRequestHttpException();
        }

        $ticket = $ticketService->createTicketForGame($game, $user);

        return $this->json(compact('ticket'));
    }

}