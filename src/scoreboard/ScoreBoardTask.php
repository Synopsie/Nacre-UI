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
    /** @var callable|null $onDisconnect */
    private $onDisconnect;

    public function __construct(ScoreBoard $scoreboard, callable $replaced, ?callable $onDisconnect = null) {
        $this->scoreBoard = $scoreboard;
        Utils::validateCallableSignature(function (array $lines) : array{}, $replaced);
        Utils::validateCallableSignature(function () : void{}, $onDisconnect);
        $this->replaced = $replaced;
        $this->onDisconnect = $onDisconnect;
    }

    public function onRun() : void {
        $scoreboard = $this->scoreBoard;

        if(!$scoreboard->getPlayer()->isOnline()) {
            if($this->onDisconnect !== null) {
                ($this->onDisconnect)();
            }
            $this->getHandler()->cancel();
            return;
        }

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
