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
 * @author SynopsieTeam
 * @link https://nacre.arkaniastudios.com/home.html
 * @version 2.0.0
 *
 */

declare(strict_types=1);

namespace nacre\camera\Instructions;

use pocketmine\network\mcpe\protocol\CameraInstructionPacket;
use pocketmine\network\mcpe\protocol\types\camera\CameraFadeInstruction;
use pocketmine\network\mcpe\protocol\types\camera\CameraFadeInstructionColor;
use pocketmine\network\mcpe\protocol\types\camera\CameraFadeInstructionTime;
use pocketmine\player\Player;

final class FadeCameraInstruction extends CameraInstruction {
	private ?CameraFadeInstructionTime $time   = null;
	private ?CameraFadeInstructionColor $color = null;

	public function setTime(float $fadeInTime, float $stayInTime, float $fadeOutTime) : void {
		$this->time = new CameraFadeInstructionTime($fadeInTime, $stayInTime, $fadeOutTime);
	}

	public function setColor(float $red, float $green, float $blue) : void {
		$this->color = new CameraFadeInstructionColor($red, $green, $blue);
	}

	public function send(Player $player) : void {
		$player->getNetworkSession()->sendDataPacket(CameraInstructionPacket::create(null, null, new CameraFadeInstruction($this->time, $this->color)));
	}
}
