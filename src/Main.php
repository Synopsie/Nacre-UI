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
 * @version 2.0.0
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
