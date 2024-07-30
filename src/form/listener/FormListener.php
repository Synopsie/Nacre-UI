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

namespace nacre\form\listener;

use nacre\NacreUI;
use pocketmine\entity\Attribute;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\scheduler\CancelTaskException;
use pocketmine\scheduler\ClosureTask;

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
					if(!isset($data['permission']) || !is_null($data['permission'])) {
						if(!$player->hasPermission($data['permission'])) {
							$player->sendMessage("§cYou don't have permission to use this form");
							$event->cancel();
						}
					}
					if($player === null || !$player->isConnected()) {
						continue;
					}
					NacreUI::getPlugin()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($player, $networkSession) : void {
						$times = 5; // send for up to 5 x 10 ticks (or 2500ms)
						NacreUI::getPlugin()->getScheduler()->scheduleRepeatingTask(new ClosureTask(static function () use ($player, $networkSession, &$times) : void {
							--$times >= 0 || throw new CancelTaskException("Maximum retries exceeded");
							$networkSession->isConnected() || throw new CancelTaskException("Maximum retries exceeded");
							$networkSession->getEntityEventBroadcaster()->syncAttributes([$networkSession], $player, [
								$player->getAttributeMap()->get(Attribute::EXPERIENCE_LEVEL)
							]);
						}), 10);
					}), 1);
				}
			}
		}
	}
}
