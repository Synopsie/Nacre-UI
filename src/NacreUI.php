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
 * @version 4.0.0
 *
 */

declare(strict_types=1);

namespace nacre;

use InvalidArgumentException;
use nacre\bossbar\BossListener;
use nacre\camera\CameraPresets;
use nacre\form\listener\FormListener;
use nacre\gui\listener\MenuListener;
use nacre\libs\muqsit\simplepackethandler\SimplePacketHandler;
use pocketmine\event\EventPriority;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\CameraPresetsPacket;
use pocketmine\network\mcpe\protocol\SetLocalPlayerAsInitializedPacket;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;

class NacreUI extends PluginBase {
	private static bool $isRegistered = false;
	private static ?Plugin $plugin    = null;

	public static function getPlugin() : Plugin {
		return self::$plugin ?? throw new InvalidArgumentException("Plugin not registered");
	}

	public static function register(Plugin $plugin) : bool {
		if(self::$isRegistered) {
			return false;
		}
		self::$isRegistered = true;
		self::$plugin       = $plugin;

		$interceptor = SimplePacketHandler::createInterceptor($plugin, EventPriority::HIGHEST);
		$interceptor->interceptIncoming(function (SetLocalPlayerAsInitializedPacket $pk, NetworkSession $target) : bool {
			$target->sendDataPacket(CameraPresetsPacket::create(CameraPresets::getAll()));
			return true;
		});

		$plugin->getServer()->getPluginManager()->registerEvents(new FormListener(), $plugin);
		$plugin->getServer()->getPluginManager()->registerEvents(new MenuListener(), $plugin);
		$plugin->getServer()->getPluginManager()->registerEvents(new BossListener(), $plugin);
		return true;

	}
}
