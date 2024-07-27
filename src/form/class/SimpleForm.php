<?php

/*
 *     _      ____    _  __     _      _   _   ___      _
 *    / \    |  _ \  | |/ /    / \    | \ | | |_ _|    / \
 *   / _ \   | |_) | | ' /    / _ \   |  \| |  | |    / _ \
 *  / ___ \  |  _ <  | . \   / ___ \  | |\  |  | |   / ___ \
 * /_/   \_\ |_| \_\ |_|\_\ /_/   \_\ |_| \_| |___| /_/   \_\
 *
 * Nacre-UI est une API destiné aux formulaires,
 * elle permet aux développeurs d'avoir une compatibilité entre toutes les interfaces,
 * mais aussi éviter les taches fastidieuses à faire.
 *
 * @author Julien
 * @link https://arkaniastudios.com/Nacre-UI
 * @version 1.0.0
 *
 */

declare(strict_types=1);

namespace nacre\form\class;

use nacre\form\BaseForm;
use nacre\form\elements\buttons\Button;
use pocketmine\permission\Permission;
use pocketmine\player\Player;

class SimpleForm extends BaseForm {
	private string $description;

	/** @var Button[] */
	private array $buttons;

	/** @var ?callable */
	private $onSubmit;

	/** @var ?callable */
	private $onClose;

	public function __construct(
		Player $player,
		string $title,
		string $description = '',
		array $buttons = [],
		?callable $onSubmit = null,
		?callable $onClose = null
	) {
		parent::__construct($player, $title);
		$this->description = $description;
		$this->buttons     = $buttons;
		$this->onSubmit    = $onSubmit;
		$this->onClose     = $onClose;
	}

	public function getType() : string {
		return 'form';
	}

	public function handleResponse(Player $player, $data) : void {
		if($data === null) {
			if($this->onClose !== null) {
				($this->onClose)($player);
			}
		} else {
			if($this->onSubmit !== null) {
				$button = $this->buttons[$data];
				if(($button->getPermission() !== null && $player->hasPermission($button->getPermission())) || $button->getPermission() === null) {
					($this->onSubmit)($player, $data);
				} else {
					$player->sendMessage("§cYou don't have permission to use this button");
				}
			}
		}
	}

	/**
	 * @return array<string, string|array<string, Button>|Permission|null>
	 */
	public function jsonSerialize() : array {
		return [
			'type'       => $this->getType(),
			'title'      => $this->title,
			'content'    => $this->description,
			'buttons'    => $this->buttons,
			'permission' => $this->getPermission()
		];
	}

}
