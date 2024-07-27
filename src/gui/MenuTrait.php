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

namespace nacre\gui;

use nacre\form\trait\PermissibleTrait;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;

trait MenuTrait {
	use PermissibleTrait;

	private string $name;

	private bool $viewOnly;

	/** @var ?callable */
	private $clickHandler;

	/** @var ?callable */
	private $closeHandler;

	public function __construct(
		Player $player,
		string|Translatable $name,
		bool $viewOnly = false,
		?array $contents = null,
		?callable $clickHandler = null,
		?callable $closeHandler = null,
		?string $permission = null
	) {
		$this->name     = $name;
		$this->viewOnly = $viewOnly;
		if($contents !== null) {
			$this->setContents($contents);
		}
		$this->clickHandler = $clickHandler;
		$this->closeHandler = $closeHandler;
		if($permission !== null) {
			$this->setPermission($permission);
		}
	}

	public function getClickHandler() : ?callable {
		return $this->clickHandler;
	}

	public function getCloseHandler() : ?callable {
		return $this->closeHandler;
	}

	public function getName() : string {
		return $this->name;
	}

	public function isViewOnly() : bool {
		return $this->viewOnly;
	}

	public function onClose(Player $who) : void {
		parent::onClose($who);
		if($this->closeHandler !== null) {
			($this->closeHandler)($who, $this);
		}
	}

}
