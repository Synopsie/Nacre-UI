<?php
declare(strict_types=1);

namespace nacre\form\elements\buttons;

use nacre\form\trait\PermissibleTrait;

class ModalButton {
    use PermissibleTrait;

    private string $identifier;
    private string $name;

    public function __construct(string $identifier, string $name, ?string $permission) {
        $this->identifier = $identifier;
        $this->name = $name;
        if($permission !== null) {
            $this->setPermission($permission);
        }
    }

    public function getIdentifier() : string {
        return $this->identifier;
    }

    public function getName() : string {
        return $this->name;
    }
}