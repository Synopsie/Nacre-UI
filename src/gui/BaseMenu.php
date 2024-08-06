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
 * @version 2.0.5
 *
 */

declare(strict_types=1);

namespace nacre\gui;

use pocketmine\inventory\Inventory;
use pocketmine\permission\Permission;
use pocketmine\player\Player;

interface BaseMenu {
	public function isViewOnly() : bool;
	public function getName() : string;
	public function getClickHandler() : ?callable;
	public function getCloseHandler() : ?callable;
	public function getPermission() : null|Permission|string;
	public function closeInventory(Player $player) : void;
    public function getInventory() : Inventory;
}
