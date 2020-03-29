<?php

namespace App;

class Game
{
    /**
     * The number of frames in a game.
     */
    const FRAMES_PER_GAME = 10;

    /**
     * All rolls for the game.
     *
     * @var array
     */
    protected $rolls = [];

    /**
     * Roll the ball.
     *
     * @param int $pins
     * @return void
     */
    public function roll(int $pins): void
    {
        $this->rolls[] = $pins;
    }

    /**
     * Calculated the final score.
     *
     * @return int
     */
    public function score()
    {
        $score = 0;
        $roll = 0;

        foreach (range(1, self::FRAMES_PER_GAME) as $frame) {
            if ($this->isStrike($roll)) {
                $score += $this->pinCount($roll) + $this->strikeBonus($roll);

                $roll += 1;

                continue;
            }

            if ($this->isSpare($roll)) {
                $score += $this->defaultFrameScore($roll) + $this->spareBonus($roll);

                $roll += 2;

                continue;
            }

            $score += $this->defaultFrameScore($roll);

            $roll += 2;
        }

        return $score;
    }

    /**
     * Determine if the current roll was strike.
     *
     * @param int $roll
     * @return bool
     */
    public function isStrike(int $roll): bool
    {
        return $this->pinCount($roll) === 10;
    }

    /**
     * Determine if the current roll was spare.
     *
     * @param int $roll
     * @return bool
     */
    public function isSpare(int $roll): bool
    {
        return $this->defaultFrameScore($roll) === 10;
    }

    /**
     * Calculate the score for the frame.
     *
     * @param int $roll
     * @return int
     */
    public function defaultFrameScore(int $roll): int
    {
        return $this->pinCount($roll) + $this->pinCount($roll + 1);
    }

    /**
     * Get the bonus for a strike.
     *
     * @param int $roll
     * @return int
     */
    public function strikeBonus(int $roll): int
    {
        return $this->pinCount($roll + 1) + $this->pinCount($roll + 2);
    }

    /**
     * Get the bonus for a spare.
     *
     * @param int $roll
     * @return int
     */
    public function spareBonus(int $roll): int
    {
        return $this->pinCount($roll + 2);
    }

    /**
     * Get the number of pins knocked down for the given roll.
     *
     * @param int $roll
     * @return int
     */
    public function pinCount(int $roll): int
    {
        return $this->rolls[$roll];
    }
}