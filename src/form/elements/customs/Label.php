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
 * @version 2.0.4
 *
 */

declare(strict_types=1);

namespace nacre\form\elements\customs;

use nacre\form\elements\Element;

final class Label extends Element {
	public function __construct(
		string $text
	) {
		parent::__construct($text);
	}

	public function getType() : string {
		return 'label';
	}

	public function handler($data) : mixed {
		return $data;
	}

	/**
	 * @return string[]
	 */
	public function jsonSerialize() : array {
		return [
			'type' => $this->getType(),
			'text' => $this->getName()
		];
	}

}
