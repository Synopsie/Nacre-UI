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

namespace nacre;

use nacre\bossbar\BossListener;
use nacre\form\listener\FormListener;
use nacre\gui\listener\MenuListener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase {
	use SingletonTrait;

	protected function onLoad() : void {
		self::setInstance($this);
		$this->getLogger()->info('§8-> §eChargement de §6Nacre-UI§e...');
	}

	protected function onEnable() : void {
		$this->getServer()->getPluginManager()->registerEvents(new FormListener(), $this);
		$this->getServer()->getPluginManager()->registerEvents(new MenuListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new BossListener(), $this);
	}
}
