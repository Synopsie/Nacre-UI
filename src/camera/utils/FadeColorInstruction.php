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

namespace nacre\camera\utils;

final class FadeColorInstruction {
	private float $red;
	private float $green;
	private float $blue;

	public function __construct(
		float $red,
		float $green,
		float $blue
	) {
		$this->red   = $red;
		$this->green = $green;
		$this->blue  = $blue;
	}

	public function getRed() : float {
		return $this->red;
	}

	public function getBlue() : float {
		return $this->blue;
	}

	public function getGreen() : float {
		return $this->green;
	}

}
