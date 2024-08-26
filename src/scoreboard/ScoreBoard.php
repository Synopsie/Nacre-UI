<?php
declare(strict_types=1);

namespace nacre\scoreboard;

use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;

class ScoreBoard {

    private Player $player;
    private ScoreBoardContent $content;
    private array $lines = [];

    public function __construct(
        Player $player,
        ScoreBoardContent $content
    ) {
        $this->player = $player;
        $this->content      = $content;
        foreach ($content->getLines() as $id => $line) {
            $this->addLine($id, $line);
        }
    }

    public function addLine(int $id, string $line) : void {
        $entry       = new ScorePacketEntry();
        $entry->type = ScorePacketEntry::TYPE_FAKE_PLAYER;

        if (isset($this->lines[$id]) && $this->lines[$id] instanceof ScorePacketEntry) {
            $pkt            = new SetScorePacket();
            $pkt->entries[] = $this->lines[$id];
            $pkt->type      = SetScorePacket::TYPE_REMOVE;
            $this->player->getNetworkSession()->sendDataPacket($pkt);
            unset($this->lines[$id]);
        }

        $entry->score         = $id;
        $entry->scoreboardId  = $id;
        $entry->actorUniqueId = $this->player->getId();
        $entry->objectiveName = $this->player->getName();
        $entry->customName    = $line;
        $this->lines[$id]     = $entry;

        $pkt            = new SetScorePacket();
        $pkt->entries[] = $entry;
        $pkt->type      = SetScorePacket::TYPE_CHANGE;
        $this->player->getNetworkSession()->sendDataPacket($pkt);
    }

    public function getPlayer() : Player {
        return $this->player;
    }

    public function getScoreBoardContent() : ScoreBoardContent {
        return $this->content;
    }

}