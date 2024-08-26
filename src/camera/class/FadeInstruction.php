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
use nacre\camera\utils\FadeColorInstruction;
use nacre\camera\utils\FadeTimeInstruction;
use pocketmine\network\mcpe\protocol\CameraInstructionPacket;
use pocketmine\network\mcpe\protocol\types\camera\CameraFadeInstruction;
use pocketmine\network\mcpe\protocol\types\camera\CameraFadeInstructionColor;
use pocketmine\network\mcpe\protocol\types\camera\CameraFadeInstructionTime;
use pocketmine\player\Player;

final class FadeInstruction implements Instruction {
	private CameraFadeInstructionColor $color;
	private CameraFadeInstructionTime $time;

	public function __construct(
		FadeTimeInstruction $fadeTimeInstruction,
		FadeColorInstruction $fadeColorInstruction
	) {
		$this->color = new CameraFadeInstructionColor($fadeColorInstruction->getRed(), $fadeColorInstruction->getGreen(), $fadeColorInstruction->getBlue());
		$this->time  = new CameraFadeInstructionTime($fadeTimeInstruction->getFadeInTime(), $fadeTimeInstruction->getStayInTime(), $fadeTimeInstruction->getFadeOutTime());
	}

	public function setTime(FadeTimeInstruction $fadeTimeInstruction) : void {
		$this->time = new CameraFadeInstructionTime($fadeTimeInstruction->getFadeInTime(), $fadeTimeInstruction->getStayInTime(), $fadeTimeInstruction->getFadeOutTime());
	}

	public function setColor(FadeColorInstruction $fadeColorInstruction) : void {
		$this->color = new CameraFadeInstructionColor($fadeColorInstruction->getRed(), $fadeColorInstruction->getGreen(), $fadeColorInstruction->getBlue());
	}

	public function send(Player $player) : void {
		$player->getNetworkSession()->sendDataPacket(
			CameraInstructionPacket::create(
				null,
				null,
				new CameraFadeInstruction($this->time, $this->color)
			)
		);
	}

}
