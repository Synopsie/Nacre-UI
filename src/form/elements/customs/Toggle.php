<?php

declare(strict_types=1);

namespace nacre\form\elements\customs;

use nacre\form\elements\Element;

final class Toggle extends Element {
	private string $text;
	private bool $default;

	public function __construct(
		string $name,
		string $text = '',
		bool $default = false
	) {
		parent::__construct($name);
		$this->text    = $text;
		$this->default = $default;
	}

	public function getType() : string {
		return 'toggle';
	}

	public function handler($data) : bool {
		return (bool) $data;
	}

	/**
	 * @return array<string, string|bool>
	 */
	public function jsonSerialize() : array {
		return [
			'type'    => $this->getType(),
			'text'    => $this->text,
			'default' => $this->default
		];
	}

}
