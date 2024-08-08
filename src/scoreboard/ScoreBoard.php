<?php

/*
 *  ____   __   __  _   _    ___    ____    ____    ___   _____
 * / ___|  \ \ / / | \ | |  / _ \  |  _ \  / ___|  |_ _| | ____|
 * \___ \   \ V /  |  \| | | | | | | |_) | \___ \   | |  |  _|
 *  ___) |   | |   | |\  | | |_| | |  __/   ___) |  | |  | |___
 * |____/    |_|   |_| \_|  \___/  |_|     |____/  |___| |_____|
 *
 * Nacre-UI est une API destiné aux formulaires,
 * elle permet aux développeurs d'avoir une compatibilité entre toutes les interfaces,
 * mais aussi éviter les taches fastidieuses à faire.
 *
 * @author Synopsie
 * @link https://nacre.arkaniastudios.com/home.html
 * @version 3.0.1
 *
 */

declare(strict_types=1);

namespace nacre\scoreboard;

use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\player\Player;

class ScoreBoard {
	private string $title;
	private array $lines;
	private Player $player;

	public function __construct(string $title, array $lines, Player $player) {
		$this->title  = $title;
		$this->lines  = $lines;
		$this->player = $player;
	}

	public function sendScoreBoard() : void {
		$pk = SetDisplayObjectivePacket::create(
			SetDisplayObjectivePacket::DISPLAY_SLOT_SIDEBAR,
			$this->player->getName(),
			$this->title,
			"dummy",
			SetDisplayObjectivePacket::SORT_ORDER_ASCENDING
		);
		$this->player->getNetworkSession()->sendDataPacket($pk);

		foreach ($this->lines as $number => $text) {
			$this->addLine($number, $text);
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
}
