<?php

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
