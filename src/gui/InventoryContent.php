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
 * @version 3.0.0
 *
 */

declare(strict_types=1);

namespace nacre\gui;

use pocketmine\item\Item;

final class InventoryContent {
	public int $slot;
	public Item $item;

	public function __construct(int $slot, Item $item) {
		$this->slot = $slot;
		$this->item = $item;
	}

	public function getSlot() : int {
		return $this->slot;
	}

	public function getItem() : Item {
		return $this->item;
	}

}
