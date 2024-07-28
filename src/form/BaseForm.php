<?php

declare(strict_types=1);

namespace nacre\form;

use nacre\form\trait\PermissibleTrait;
use pocketmine\form\Form;

abstract class BaseForm implements Form {
	use PermissibleTrait;

	protected string $title;

	public function __construct(string $title) {
		$this->title  = $title;
	}

	abstract public function getType() : string;

}
