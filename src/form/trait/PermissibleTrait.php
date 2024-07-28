<?php

declare(strict_types=1);

namespace nacre\form\trait;

use pocketmine\permission\Permission;

trait PermissibleTrait {

	protected null|Permission|string $permission = null;

	public function setPermission(Permission|string $permission) : void {
		$this->permission = $permission;
	}

	public function getPermission() : null|Permission|string {
		return $this->permission;
	}

}
