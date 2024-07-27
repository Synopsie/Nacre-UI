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
use pocketmine\player\Player;

final class ModalForm extends BaseForm {
	private string $content;
	private string $button1;
	private string $button2;

	/** @var ?callable */
	private $onSubmit;

	/** @var ?callable */
	private $onClose;

	public function __construct(
		Player $player,
		string $title,
		string $content,
		string $button1,
		string $button2,
		?callable $onSubmit = null,
		?callable $onClose = null
	) {
		parent::__construct($player, $title);
		$this->content  = $content;
		$this->button1  = $button1;
		$this->button2  = $button2;
		$this->onSubmit = $onSubmit;
		$this->onClose  = $onClose;
	}

	public function getType() : string {
		return "modal";
	}

	public function handleResponse(Player $player, $data) : void {
		if($data !== null) {
			if($this->onSubmit !== null) {
				($this->onSubmit)($player, $data);
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
			'button1'    => $this->button1,
			'button2'    => $this->button2,
			'permission' => $this->permission
		];
	}

}
