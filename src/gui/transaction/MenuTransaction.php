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

namespace nacre\gui\transaction;

use nacre\gui\BaseMenu;
use pocketmine\item\Item;

final class MenuTransaction {
	private BaseMenu $inventory;
	private Item $source;
	private Item $target;
	private int $slot;

	public function __construct(
		BaseMenu $inventory,
		Item $source,
		Item $target,
		int $slot
	) {
		$this->inventory = $inventory;
		$this->source    = $source;
		$this->target    = $target;
		$this->slot      = $slot;
	}

	public function getInventory() : BaseMenu {
		return $this->inventory;
	}

	public function getSource() : Item {
		return $this->source;
	}

	public function getTarget() : Item {
		return $this->target;
	}

	public function getSlot() : int {
		return $this->slot;
	}

	public function discard() : MenuTransactionResult {
		return new MenuTransactionResult(true);
	}

	public function continue() : MenuTransactionResult {
		return new MenuTransactionResult(false);
	}

}
