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

namespace nacre\gui\listener;

use nacre\gui\BaseMenu;
use nacre\gui\transaction\MenuTransaction;
use nacre\gui\transaction\MenuTransactionResult;
use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\inventory\transaction\action\SlotChangeAction;

final class MenuListener implements Listener {
	public function onInventoryTransaction(InventoryTransactionEvent $event) : void {
		$transaction = $event->getTransaction();
		$player      = $transaction->getSource();
		foreach ($transaction->getActions() as $action) {
			if ($action instanceof SlotChangeAction) {
				$inventory = $action->getInventory();
				if ($inventory instanceof BaseMenu) {
					$clickCallback = $inventory->getClickHandler();
					if ($clickCallback !== null) {
						$result = $clickCallback($player, new MenuTransaction($inventory, $action->getSourceItem(), $action->getTargetItem(), $action->getSlot()));
						if ($result instanceof MenuTransactionResult) {
							if($result->isCancelled()) {
								$event->cancel();
							}
						}
					}
					if ($inventory->isViewOnly()) {
						$event->cancel();
					}
				}
			}
		}
	}

	public function onInventoryOpen(InventoryOpenEvent $event) : void {
		$inventory = $event->getInventory();
		if ($inventory instanceof BaseMenu) {
			if($inventory->getPermission() !== null && !$event->getPlayer()->hasPermission($inventory->getPermission())) {
				$event->getPlayer()->sendMessage('§cYou don\'t have permission to open this menu.');
				$event->cancel();
			}
		}
	}
}
