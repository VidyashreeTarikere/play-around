<?php

class GuessingGame
{
    public $maxGuess;
    public $secretNumber;
    public $result;
    public $guess;
    // TODO: set a default amount of max guesses
    public function __construct(int $maxGuess = 3)
    {
        $this->maxGuess = $maxGuess;
        if (!empty($_SESSION["guesses"])) {
            $this->guess = $_SESSION["guesses"];
        }
        if (!empty($_SESSION["secretNumber"])) {
            $this->secretNumber = $_SESSION["secretNumber"];
        }
    }
    public function run()
    {
        if (empty($this->secretNumber)) {
            $this->generateSecretNumber();
        }

        if (!empty($_POST["input"])) {
            $this->guess++;

            if ($_POST["input"] == $this->secretNumber) {
                $this->playerWins();
            } else if ($_POST["input"] < $this->secretNumber) {
                $this->guessHigher();
            } else if ($_POST["input"] > $this->secretNumber) {
                $this->guessLower();
            }
        }

        $_SESSION["guesses"] = $this->guess;

        if ($this->guess == $this->maxGuess) {
            $this->playerLoses();
            $this->reset();
        }

        if (isset($_POST["reset"])) {
            $this->reset();
        }
    }

    public function generateSecretNumber()
    {
        $this->secretNumber = rand(1, 10);
        $_SESSION["secretNumber"] = $this->secretNumber;
    }

    public function playerWins()
    {
        $this->result = 'Correct';
        $this->reset();
    }

    public function playerLoses()
    {
        $this->result = "You Loose!! The secret number {$this->secretNumber} ";
        $this->reset();
    }

    public function guessHigher()
    {
        $this->result = "Wrong. Guess higher??";
    }

    public function guessLower()
    {
        $this->result = "Wrong. Guess lower!";
    }

    public function reset()
    {
        $this->guess = 0;
        $_SESSION["guesses"] = 0;
        $this->generateSecretNumber();
    }

    public function allAttemptsUsed()
    {
        return "play again?";
    }
}
