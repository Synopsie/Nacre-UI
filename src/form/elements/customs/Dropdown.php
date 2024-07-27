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

final class Dropdown extends Element {
	private string $text;

	/** @var mixed[] */
	private array $options;
	private int $defaultOptionIndex;

	public function __construct(
		string $name,
		string $text,
		array $options = [],
		int $defaultOptionIndex = 0
	) {
		parent::__construct($name);
		$this->text               = $text;
		$this->options            = $options;
		$this->defaultOptionIndex = $defaultOptionIndex;
	}

	public function getType() : string {
		return 'dropdown';
	}

	public function handler($data) : mixed {
		return $this->options[$data];
	}

	/**
	 * @return array<string, string|int|array<int, mixed>>
	 */
	public function jsonSerialize() : array {
		return [
			'type'    => $this->getType(),
			'text'    => $this->text,
			'options' => $this->options,
			'default' => $this->defaultOptionIndex
		];
	}

}
