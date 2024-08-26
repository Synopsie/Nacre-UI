<?php
declare(strict_types=1);

namespace nacre\scoreboard;

use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\scheduler\Task;
use pocketmine\utils\Utils;

class ScoreBoardTask extends Task {

    private ScoreBoard $scoreBoard;
    /** @var callable $replaced */
    private $replaced;

    public function __construct(ScoreBoard $scoreboard, callable $replaced) {
        $this->scoreBoard = $scoreboard;
        Utils::validateCallableSignature(function (array $lines) : array{}, $replaced);
        $this->replaced = $replaced;
    }

    public function onRun() : void {
        $scoreboard = $this->scoreBoard;
        $pk = SetDisplayObjectivePacket::create(
            SetDisplayObjectivePacket::DISPLAY_SLOT_SIDEBAR,
            $scoreboard->getPlayer()->getName(),
            $scoreboard->getScoreBoardContent()->getTitle(),
            "dummy",
            SetDisplayObjectivePacket::SORT_ORDER_ASCENDING
        );
        $lines = ($this->replaced)($this->scoreBoard->getScoreBoardContent()->getLines());
        foreach ($lines as $number => $text) {
            $scoreboard->addLine($number, $text);
        }
        $scoreboard->getPlayer()->getNetworkSession()->sendDataPacket($pk);
    }
}
