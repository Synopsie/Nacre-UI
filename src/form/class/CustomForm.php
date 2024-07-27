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
use nacre\form\elements\Element;
use pocketmine\player\Player;

final class CustomForm extends BaseForm {
	/** @var Element[] */
	private array $elements;

	/** @var ?callable */
	private $onSubmit;

	/** @var ?callable */
	private $onClose;

	public function __construct(
		Player $player,
		string $title,
		array $elements = [],
		?callable $onSubmit = null,
		?callable $onClose = null
	) {
		parent::__construct($player, $title);

		$this->elements = $elements;
		$this->onSubmit = $onSubmit;
		$this->onClose  = $onClose;
	}

	public function getType() : string {
		return 'custom_form';
	}

	public function handleResponse(Player $player, $data) : void {
		if ($data === null) {
			if ($this->onClose !== null) {
				($this->onClose)($player);
			}
			return;
		}
		$count = [];
		foreach ($data as $key => $value) {
			$element     = $this->elements[$key];
			$elementName = $element->getName();
			if (isset($data[$elementName])) {
				$count[$elementName]++;
				$data[$elementName . '-' . $count[$elementName]] = $element->handler($value);
			} else {
				$count[$elementName] = 1;
				$data[$elementName]  = $element->handler($value);
			}
			unset($data[$key]);
		}

		unset($this->labels);
		if ($this->onSubmit !== null) {
			($this->onSubmit)($player, $data);
		}
	}

	public function jsonSerialize() : array {
		return [
			'type'       => $this->getType(),
			'title'      => $this->title,
			'content'    => $this->elements,
			'permission' => $this->permission
		];
	}
}
