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

final class StepSlider extends Element {
	private string $text;
	private int $default;

	/** @var mixed[] */
	private array $step;

	public function __construct(
		string $name,
		string $text = '',
		array $step = [],
		int $default = 0
	) {
		parent::__construct($name);
		$this->text    = $text;
		$this->default = $default;
		$this->step    = $step;
	}

	public function getType() : string {
		return 'step_slider';
	}

	public function handler($data) : mixed {
		return $this->step[$data];
	}

	/**
	 * @return array<string, string|mixed[]>
	 */
	public function jsonSerialize() : array {
		return [
			'type'    => $this->getType(),
			'text'    => $this->text,
			'steps'   => $this->step,
			'default' => $this->default
		];
	}

}
