<?php
declare(strict_types=1);

namespace nacre\scoreboard;

final class ScoreBoardContent {

    private string $title;
    private array $lines;

    public function __construct(
        string $title,
        ...$lines
    ) {
        $this->title = $title;
        $this->lines = $lines;
    }

    public function getTitle() : string {
        return $this->title;
    }

    public function getLines() : array {
        return $this->lines;
    }

}