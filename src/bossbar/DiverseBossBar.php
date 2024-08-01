<?php

/*
 *  ____   __   __  _   _    ___    ____    ____    ___   _____
 * / ___|  \ \ / / | \ | |  / _ \  |  _ \  / ___|  |_ _| | ____|
 * \___ \   \ V /  |  \| | | | | | | |_) | \___ \   | |  |  _|
 *  ___) |   | |   | |\  | | |_| | |  __/   ___) |  | |  | |___
 * |____/    |_|   |_| \_|  \___/  |_|     |____/  |___| |_____|
 *
 * Nacre-UI est une API destiné aux formulaires,
 * elle permet aux développeurs d'avoir une compatibilité entre toutes les interfaces,
 * mais aussi éviter les taches fastidieuses à faire.
 *
 * @author Synopsie
 * @link https://nacre.arkaniastudios.com/home.html
 * @version 2.0.5
 *
 */

declare(strict_types=1);

namespace nacre\bossbar;

use pocketmine\entity\Attribute;
use pocketmine\entity\AttributeMap;
use pocketmine\network\mcpe\protocol\BossEventPacket;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataCollection;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\network\mcpe\protocol\UpdateAttributesPacket;
use pocketmine\player\Player;
use function count;
use function max;
use function mb_convert_encoding;
use function min;

class DiverseBossBar extends BossBar {
	private array $titles    = [];
	private array $subTitles = [];
	/** @var AttributeMap[] */
	private array $attributeMaps = [];
	private array $colors        = [];

	/**
	 * @see BossBar::__construct
	 */
	public function __construct() {
		parent::__construct();
	}

	public function addPlayer(Player $player) : static {
		$this->attributeMaps[$player->getId()] = clone parent::getAttributeMap();
		return parent::addPlayer($player);
	}

	/**
	 * Removes a single player from this bar.
	 * Use @param Player $player
	 * @see BossBar::hideFrom() when just removing temporarily to save some performance / bandwidth
	 */
	public function removePlayer(Player $player) : static {
		unset($this->attributeMaps[$player->getId()]);
		return parent::removePlayer($player);
	}

	public function resetFor(Player $player) : static {
		unset($this->attributeMaps[$player->getId()], $this->titles[$player->getId()], $this->subTitles[$player->getId()], $this->colors[$player->getId()]);
		$this->sendAttributesPacket([$player]);
		$this->sendBossPacket([$player]);
		return $this;
	}

	public function resetForAll() : static {
		foreach($this->getPlayers() as $player) {
			$this->resetFor($player);
		}
		return $this;
	}

	public function getTitleFor(Player $player) : string {
		return $this->titles[$player->getId()] ?? $this->getTitle();
	}

	/**
	 * @param Player[] $players
	 */
	public function setTitleFor(array $players, string $title = "") : static {
		foreach($players as $player) {
			$this->titles[$player->getId()] = $title;
			$this->sendBossTextPacket([$player]);
		}
		return $this;
	}

	public function getSubTitleFor(Player $player) : string {
		return $this->subTitles[$player->getId()] ?? $this->getSubTitle();
	}

	/**
	 * @param Player[] $players
	 */
	public function setSubTitleFor(array $players, string $subTitle = "") : static {
		foreach($players as $player) {
			$this->subTitles[$player->getId()] = $subTitle;
			$this->sendBossTextPacket([$player]);
		}
		return $this;
	}

	/**
	 * The full title as a combination of the title and its subtitle. Automatically fixes encoding issues caused by newline characters
	 */
	public function getFullTitleFor(Player $player) : string {
		$text = $this->titles[$player->getId()] ?? "";
		if (!empty($this->subTitles[$player->getId()] ?? "")) {
			$text .= "\n\n" . $this->subTitles[$player->getId()] ?? "";//?? "" even necessary?
		}
		if (empty($text)) {
			$text = $this->getFullTitle();
		}
		return mb_convert_encoding($text, 'UTF-8');
	}

	/**
	 * @param Player[] $players
	 * @param float    $percentage 0-1
	 */
	public function setPercentageFor(array $players, float $percentage) : static {
		$percentage = (float) min(1.0, max(0.00, $percentage));
		foreach($players as $player) {
			$this->getAttributeMap($player)->get(Attribute::HEALTH)->setValue($percentage * $this->getAttributeMap($player)->get(Attribute::HEALTH)->getMaxValue(), true, true);
		}
		$this->sendAttributesPacket($players);
		$this->sendBossHealthPacket($players);

		return $this;
	}

	public function getPercentageFor(Player $player) : float {
		return $this->getAttributeMap($player)->get(Attribute::HEALTH)->getValue() / 100;
	}

	/**
	 * @param Player[] $players
	 */
	public function setColorFor(array $players, string $colorName) : static {
		$color = BossBarColor::getColorByName($colorName);
		foreach($players as $player) {
			$this->colors[$player->getId()] = $color;
			$this->sendBossPacket([$player]);
		}
		return $this;
	}

	public function getColorFor(Player $player) : int {
		$colorId = $this->colors[$player->getId()] ?? $this->getColor();
		return BossBarColor::$colorNames[$colorId] ?? BossBarColor::PURPLE;
	}

	/**
	 * @param Player[] $players
	 */
	public function showTo(array $players) : void {
		foreach ($players as $player) {
			if(!$player->isConnected()) {
				continue;
			}
			$player->getNetworkSession()->sendDataPacket(BossEventPacket::show($this->actorId ?? $player->getId(), $this->getFullTitleFor($player), $this->getPercentageFor($player), false, $this->getColorFor($player)));
		}
	}

	/**
	 * @param Player[] $players
	 */
	protected function sendBossPacket(array $players) : void {
		foreach ($players as $player) {
			if(!$player->isConnected()) {
				continue;
			}
			$player->getNetworkSession()->sendDataPacket(BossEventPacket::show($this->actorId ?? $player->getId(), $this->getFullTitleFor($player), $this->getPercentageFor($player), false, $this->getColorFor($player)));
		}
	}

	/**
	 * @param Player[] $players
	 */
	protected function sendBossTextPacket(array $players) : void {
		foreach ($players as $player) {
			if(!$player->isConnected()) {
				continue;
			}
			$player->getNetworkSession()->sendDataPacket(BossEventPacket::title($this->actorId ?? $player->getId(), $this->getFullTitleFor($player)));
		}
	}

	/**
	 * @param Player[] $players
	 */
	protected function sendAttributesPacket(array $players) : void {
		if ($this->actorId === null) {
			return;
		}
		$pk                 = new UpdateAttributesPacket();
		$pk->actorRuntimeId = $this->actorId;
		foreach ($players as $player) {
			if(!$player->isConnected()) {
				continue;
			}
			$pk->entries = $this->getAttributeMap($player)->needSend();
			$player->getNetworkSession()->sendDataPacket($pk);
		}
	}

	/**
	 * @param Player[] $players
	 */
	protected function sendBossHealthPacket(array $players) : void {
		foreach ($players as $player) {
			if(!$player->isConnected()) {
				continue;
			}
			$player->getNetworkSession()->sendDataPacket(BossEventPacket::healthPercent($this->actorId ?? $player->getId(), $this->getPercentageFor($player)));
		}
	}

	public function getAttributeMap(Player $player = null) : AttributeMap {
		if ($player instanceof Player) {
			return $this->attributeMaps[$player->getId()] ?? parent::getAttributeMap();
		}
		return parent::getAttributeMap();
	}

	public function getPropertyManager(Player $player = null) : EntityMetadataCollection {
		$propertyManager = $this->propertyManager;
		if ($player instanceof Player) {
			$propertyManager->setString(EntityMetadataProperties::NAMETAG, $this->getFullTitleFor($player));
		} else {
			$propertyManager->setString(EntityMetadataProperties::NAMETAG, $this->getFullTitle());
		}
		return $propertyManager;
	}

	public function __toString() : string {
		return __CLASS__ . " ID: $this->actorId, Titles: " . count($this->titles) . ", Subtitles: " . count($this->subTitles) . " [Defaults: " . parent::__toString() . "]";
	}

}
