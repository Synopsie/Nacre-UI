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

final class Input extends Element {
	private string $text;
	private string $placeholder;
	private string $default;

	public function __construct(
		string $name,
		string $text = '',
		string $placeholder = '',
		string $default = ''
	) {
		parent::__construct($name);
		$this->text        = $text;
		$this->placeholder = $placeholder;
		$this->default     = $default;
	}

	public function getType() : string {
		return 'input';
	}

	public function handler($data) : mixed {
		return $data;
	}

	/**
	 * @return array<string, string>
	 */
	public function jsonSerialize() : array {
		return [
			'type'        => $this->getType(),
			'text'        => $this->text,
			'placeholder' => $this->placeholder,
			'default'     => $this->default
		];
	}

}
