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

namespace nacre\bossbar;

use InvalidArgumentException;
use pocketmine\network\mcpe\protocol\types\BossBarColor as BarColor;
use function array_keys;
use function strtolower;

class BossBarColor {
	const PINK           = BarColor::PINK;
	const BLUE           = BarColor::BLUE;
	const RED            = BarColor::RED;
	const GREEN          = BarColor::GREEN;
	const YELLOW         = BarColor::YELLOW;
	const PURPLE         = BarColor::PURPLE;
	const REBECCA_PURPLE = BarColor::REBECCA_PURPLE;
	const WHITE          = BarColor::WHITE;

	/** @var int[] */
	public static array $colorNames = [
		self::PINK           => BarColor::PINK,
		self::BLUE           => BarColor::BLUE,
		self::RED            => BarColor::RED,
		self::GREEN          => BarColor::GREEN,
		self::YELLOW         => BarColor::YELLOW,
		self::PURPLE         => BarColor::PURPLE,
		self::REBECCA_PURPLE => BarColor::REBECCA_PURPLE,
		self::WHITE          => BarColor::WHITE,
	];

	/**
	 * Get all available boss bar colors.
	 *
	 * @return int[]
	 */
	public static function getColors() : array {
		return array_keys(self::$colorNames);
	}

	/**
	 * Get color constant by color name.
	 *
	 * @throws InvalidArgumentException
	 */
	public static function getColorByName(string $colorName) : int {
		$colorNameLower = strtolower($colorName);
		foreach (self::$colorNames as $color => $name) {
			if ($colorNameLower === strtolower($name)) {
				return $color;
			}
		}
		throw new InvalidArgumentException("Invalid color name specified: " . $colorName);
	}

}
