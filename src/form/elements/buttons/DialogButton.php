<?php
declare(strict_types=1);

namespace nacre\form\elements\buttons;

class DialogButton implements \JsonSerializable {

    private string $name;
    private string $command;

    /** @var callable $submit */
    private $submit;

    public function __construct(
        string $name,
        string $command,
        callable $submit = null
    ) {
        $this->name = $name;
        $this->command = $command;
        $this->submit = $submit;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getCommand() : string {
        return $this->command;
    }

    public function getSubmit() : ?callable {
        return $this->submit;
    }

    public function jsonSerialize() : array {
        return [
            'button_name' => $this->getName(),
            'data' => null,
            'mode' => 0,
            'text' => $this->getCommand(),
            'type' => 1
        ];
    }
}