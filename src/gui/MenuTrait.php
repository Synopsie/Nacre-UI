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
 * @version 2.0.1
 *
 */

declare(strict_types=1);

namespace nacre\gui;

use nacre\form\trait\PermissibleTrait;
use pocketmine\player\Player;

trait MenuTrait {
	use PermissibleTrait;

	private string $name;

	private bool $viewOnly;

	/** @var ?callable */
	private $clickHandler;

	/** @var ?callable */
	private $closeHandler;

	/**
	 * @param InventoryContent[]|null $contents
	 */
	public function __construct(
		Player $player,
		string $name,
		bool $viewOnly = false,
		?array $contents = null,
		?callable $clickHandler = null,
		?callable $closeHandler = null,
		?string $permission = null
	) {
		$this->name     = $name;
		$this->viewOnly = $viewOnly;
		if($contents !== null) {
			foreach ($contents as $content) {
				$this->setItem($content->getSlot(), $content->getItem());
			}
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
