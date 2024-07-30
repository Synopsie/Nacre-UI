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
 * @version 2.0.3
 *
 */

declare(strict_types=1);

namespace nacre\form\elements\buttons;

use nacre\form\trait\PermissibleTrait;

class ModalButton {
	use PermissibleTrait;

	private string $identifier;
	private string $name;

	public function __construct(string $identifier, string $name, ?string $permission) {
		$this->identifier = $identifier;
		$this->name       = $name;
		if($permission !== null) {
			$this->setPermission($permission);
		}
	}

	public function getIdentifier() : string {
		return $this->identifier;
	}

	public function getName() : string {
		return $this->name;
	}
}
