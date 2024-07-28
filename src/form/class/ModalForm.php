<?php

declare(strict_types=1);

namespace nacre\form\class;

use nacre\form\BaseForm;
use nacre\form\elements\buttons\ModalButton;
use pocketmine\player\Player;

final class ModalForm extends BaseForm {

	private string $content;

    /** @var ModalButton[]|string[] */
	private array $buttons = [];

	/** @var ?callable */
	private $onSubmit;

	/** @var ?callable */
	private $onClose;

	public function __construct(
		string $title,
		string $content,
		ModalButton $button1,
		ModalButton $button2,
		?callable $onSubmit = null,
		?callable $onClose = null
	) {
		parent::__construct($title);
		$this->content  = $content;
		$this->buttons[0]  = $button1;
		$this->buttons[1]  = $button2;
		$this->onSubmit = $onSubmit;
		$this->onClose  = $onClose;
	}

	public function getType() : string {
		return "modal";
	}

	public function handleResponse(Player $player, $data) : void {
		if($data !== null) {
			if($this->onSubmit !== null) {
                if ($this->buttons[$data]->getPermission() !== null && !$player->hasPermission($this->buttons[$data]->getPermission())) {
                    $player->sendMessage("§cYou don't have permission to use this button");
                    return;
                }
				($this->onSubmit)($player, $this->buttons[$data]->getName());
			}
		} else {
			if($this->onClose !== null) {
				($this->onClose)($player);
			}
		}
	}

	public function jsonSerialize() : array {
		return [
			'type'       => $this->getType(),
			'title'      => $this->title,
			'content'    => $this->content,
			'button1'    => $this->buttons[0]->getName(),
			'button2'    => $this->buttons[1]->getName(),
			'permission' => $this->getPermission()
		];
	}

}