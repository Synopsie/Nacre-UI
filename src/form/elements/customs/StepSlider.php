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
 * @version 2.0.1
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
