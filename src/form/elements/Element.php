<?php

declare(strict_types=1);

namespace nacre\form\elements;

use JsonSerializable;

abstract class Element implements JsonSerializable {
	private string $name;

	public function __construct(string $name) {
		$this->name = $name;
	}

	public function getName() : string {
		return $this->name;
	}
	abstract public function getType() : string;
	abstract public function handler($data) : mixed;

}
