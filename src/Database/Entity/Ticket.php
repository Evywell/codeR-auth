<?php


namespace App\Database\Entity;


class Ticket
{

    private string $email;
    private Game $game;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Ticket
     */
    public function setEmail(string $email): Ticket
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Game
     */
    public function getGame(): Game
    {
        return $this->game;
    }

    /**
     * @param Game $game
     * @return Ticket
     */
    public function setGame(Game $game): Ticket
    {
        $this->game = $game;
        return $this;
    }
}