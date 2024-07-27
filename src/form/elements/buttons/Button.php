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

namespace nacre\form\elements\buttons;

use JsonSerializable;
use nacre\form\elements\icon\Icon;
use nacre\form\trait\PermissibleTrait;
use pocketmine\permission\Permission;

abstract class Button implements JsonSerializable {
	use PermissibleTrait {
		hasPermission as private;
	}

	private string $name;
	private string $text;
	private null|Icon $icon;

	public function __construct(
		string $name,
		string $text,
		null|Permission|string $permission = null,
		null|Icon $icon = null
	) {
		$this->name = $name;
		$this->text = $text;
		$this->icon = $icon;
		if($permission !== null) {
			$this->setPermission($permission);
		}
	}

	public function getName() : string {
		return $this->name;
	}

	/**
	 * @return array<string, string|array>
	 */
	public function jsonSerialize() : array {
		return [
			"text"       => $this->text,
			"image"      => $this->icon?->jsonSerialize() ?? null,
			"permission" => $this->permission instanceof Permission ? $this->permission->getName() : $this->permission
		];
	}

}
