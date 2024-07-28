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

namespace nacre\form\elements\icon;

final class IconPath implements Icon {
	private string $path;

	public function __construct(string $path) {
		$this->path = $path;
	}

	/**
	 * @return string[]
	 */
	public function jsonSerialize() : array {
		return [
			"type" => "path",
			"data" => $this->path
		];
	}

}
