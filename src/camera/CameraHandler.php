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

namespace nacre\camera;

use Error;
use nacre\libs\muqsit\simplepackethandler\SimplePacketHandler;
use pocketmine\event\EventPriority;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\CameraPresetsPacket;
use pocketmine\network\mcpe\protocol\SetLocalPlayerAsInitializedPacket;
use pocketmine\plugin\Plugin;
use pocketmine\utils\SingletonTrait;
use function is_null;

class CameraHandler {
	use SingletonTrait;

	protected ?Plugin $plugin = null;

	public function __construct() {
		self::setInstance($this);
	}

	public static function register(Plugin $plugin) : void {
		if(!is_null(($pl = self::getInstance()->plugin))) {
			throw new Error("Already registered with {$pl->getName()}");
		}

		self::getInstance()->plugin = $plugin;
		$interceptor                = SimplePacketHandler::createInterceptor($plugin, EventPriority::HIGHEST, false);
		$interceptor->interceptIncoming(function (SetLocalPlayerAsInitializedPacket $pk, NetworkSession $target) : bool {
			$target->sendDataPacket(CameraPresetsPacket::create(CameraPresets::getAll()));
			return true;
		});
	}

	public static function isRegistered() : bool {
		return !is_null(self::getInstance()->plugin);
	}

	public function getPlugin() : Plugin {
		return $this->plugin;
	}
}
