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
