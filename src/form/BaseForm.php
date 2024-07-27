<?php

/*
 *     _      ____    _  __     _      _   _   ___      _
 *    / \    |  _ \  | |/ /    / \    | \ | | |_ _|    / \
 *   / _ \   | |_) | | ' /    / _ \   |  \| |  | |    / _ \
 *  / ___ \  |  _ <  | . \   / ___ \  | |\  |  | |   / ___ \
 * /_/   \_\ |_| \_\ |_|\_\ /_/   \_\ |_| \_| |___| /_/   \_\
 *
 * Nacre-UI est une API destiné aux formulaires,
 * elle permet aux développeurs d'avoir une compatibilité entre toutes les interfaces,
 * mais aussi éviter les taches fastidieuses à faire.
 *
 * @author Julien
 * @link https://arkaniastudios.com/Nacre-UI
 * @version 1.0.0
 *
 */

declare(strict_types=1);

namespace nacre\form;

use nacre\form\trait\PermissibleTrait;
use pocketmine\form\Form;
use pocketmine\player\Player;

abstract class BaseForm implements Form {
	use PermissibleTrait {
		PermissibleTrait::__construct as private __permissibleConstruct;
	}

	protected string $title;

	public function __construct(
		Player $player,
		string $title
	) {
		$this->__permissibleConstruct($player);
		$this->player = $player;
		$this->title  = $title;
	}

	abstract public function getType() : string;

}
