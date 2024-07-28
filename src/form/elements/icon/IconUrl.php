<?php

declare(strict_types=1);

namespace nacre\form\elements\icon;

final class IconUrl implements Icon {
	private string $url;

	public function __construct(string $url) {
		$this->url = $url;
	}

	/**
	 * @return string[]
	 */
	public function jsonSerialize() : array {
		return [
			"type" => "url",
			"data" => $this->url
		];
	}

}
