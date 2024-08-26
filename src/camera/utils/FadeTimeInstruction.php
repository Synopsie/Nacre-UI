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

final class FadeTimeInstruction {
	private float $fadeInTime;
	private float $stayInTime;
	private float $fadeOutTime;

	public function __construct(
		float $fadeInTime,
		float $stayInTime,
		float $fadeOutTime
	) {
		$this->fadeInTime  = $fadeInTime;
		$this->stayInTime  = $stayInTime;
		$this->fadeOutTime = $fadeOutTime;
	}

	public function getFadeInTime() : float {
		return $this->fadeInTime;
	}

	public function getFadeOutTime() : float {
		return $this->fadeOutTime;
	}

	public function getStayInTime() : float {
		return $this->stayInTime;
	}

}
