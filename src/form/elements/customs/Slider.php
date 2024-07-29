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

final class Slider extends Element {
	private string $text;
	private int $min;
	private int $max;
	private int $step;
	private int $default;

	public function __construct(
		string $name,
		string $text,
		int $min = 0,
		int $max = 100,
		int $step = 1,
		int $default = 0
	) {
		parent::__construct($name);
		$this->text    = $text;
		$this->min     = $min;
		$this->max     = $max;
		$this->step    = $step;
		$this->default = $default;
	}

	public function getType() : string {
		return 'slider';
	}

	public function handler($data) : float|int {
		return $data;
	}

	/**
	 * @return string[]
	 */
	public function jsonSerialize() : array {
		return [
			'type'    => $this->getType(),
			'text'    => $this->text,
			'min'     => $this->min,
			'max'     => $this->max,
			'step'    => $this->step,
			'default' => $this->default
		];
	}

}
