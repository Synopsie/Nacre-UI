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

use nacre\camera\CameraPresets;
use nacre\camera\interface\Instruction;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\CameraInstructionPacket;
use pocketmine\network\mcpe\protocol\types\camera\CameraPreset;
use pocketmine\network\mcpe\protocol\types\camera\CameraSetInstruction;
use pocketmine\network\mcpe\protocol\types\camera\CameraSetInstructionEase;
use pocketmine\network\mcpe\protocol\types\camera\CameraSetInstructionRotation;
use pocketmine\player\Player;
use function array_search;

final class SetInstruction implements Instruction {
	private ?CameraPreset $cameraPreset;
	private ?CameraSetInstructionEase $ease;
	private ?Vector3 $position;
	private ?CameraSetInstructionRotation $rotation;
	private ?Vector3 $facing;

	public function __construct(
		CameraPreset $cameraPreset,
		CameraSetInstructionEase $ease,
		Vector3 $position,
		CameraSetInstructionRotation $rotation,
		Vector3 $facing
	) {
		$this->cameraPreset = $cameraPreset;
		$this->ease         = $ease;
		$this->position     = $position;
		$this->rotation     = $rotation;
		$this->facing       = $facing;
	}

	public function send(Player $player) : void {
		$player->getNetworkSession()->sendDataPacket(
			CameraInstructionPacket::create(
				new CameraSetInstruction(
					array_search(
						$this->cameraPreset,
						CameraPresets::getAll(),
						true
					),
					$this->ease,
					$this->position,
					$this->rotation,
					$this->facing,
					null
				),
				false,
				null
			)
		);
	}
}
