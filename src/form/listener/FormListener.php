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

namespace nacre\form\listener;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use function is_null;
use function json_decode;

final class FormListener implements Listener {
	public function onFormReceive(DataPacketSendEvent $event) : void {
		$packets = $event->getPackets();
		foreach ($packets as $packet) {
			if ($packet instanceof ModalFormRequestPacket) {
				$data = json_decode($packet->formData, true);
				if ($data === null) {
					return;
				}
				foreach ($event->getTargets() as $networkSession) {
					$player = $networkSession->getPlayer();
					if(!is_null($data['permission'])) {
						if(!$player->hasPermission($data['permission'])) {
							$player->sendMessage("§cYou don't have permission to use this form");
							$event->cancel();
						}
					}
				}
			}
		}
	}
}
