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
 * @version 4.0.0
 *
 */

declare(strict_types=1);

namespace nacre\camera\class;

use nacre\camera\interface\Instruction;
use pocketmine\network\mcpe\protocol\CameraInstructionPacket;
use pocketmine\player\Player;

final class ClearInstruction implements Instruction {
	private bool $clear;

	public function __construct(bool $clear) {
		$this->clear = $clear;
	}

	public function setClear(bool $clear) : void {
		$this->clear = $clear;
	}

	public function send(Player $player) : void {
		$player->getNetworkSession()->sendDataPacket(
			CameraInstructionPacket::create(
				null,
				$this->clear,
				null
			)
		);
	}

}