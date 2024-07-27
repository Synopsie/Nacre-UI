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

namespace nacre\form\trait;

use pocketmine\permission\Permission;
use pocketmine\player\Player;

trait PermissibleTrait {
	protected Player $player;

	public function __construct(Player $player) {
		$this->player = $player;
	}

	protected null|Permission|string $permission = null;

	public function setPermission(Permission|string $permission) : void {
		$this->permission = $permission;
	}

	public function getPermission() : null|Permission|string {
		return $this->permission;
	}

	public function hasPermission() : bool {
		if($this->permission === null) {
			return true;
		}
		return $this->player->hasPermission($this->permission);
	}

}
