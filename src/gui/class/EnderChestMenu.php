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

namespace nacre\gui\class;

use nacre\gui\BaseMenu;
use nacre\gui\MenuTrait;
use pocketmine\block\inventory\EnderChestInventory;
use pocketmine\block\tile\Nameable;
use pocketmine\block\VanillaBlocks;
use pocketmine\lang\Translatable;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\BlockActorDataPacket;
use pocketmine\network\mcpe\protocol\types\BlockPosition;
use pocketmine\network\mcpe\protocol\types\CacheableNbt;
use pocketmine\network\mcpe\protocol\UpdateBlockPacket;
use pocketmine\player\Player;
use pocketmine\world\Position;

final class EnderChestMenu extends EnderChestInventory implements BaseMenu {
	use MenuTrait {
		MenuTrait::__construct as private __menuConstruct;
	}

	public function __construct(
		Player $player,
		string|Translatable $name,
		bool $viewOnly = false,
		?array $contents = null,
		?callable $clickHandler = null,
		?callable $closeHandler = null,
		?string $permission = null
	) {
		parent::__construct($player->getPosition(), $player->getEnderInventory());
		$this->__menuConstruct($player, $name, $viewOnly, $contents, $clickHandler, $closeHandler, $permission);
	}

	private array $isSent = [];

	public function onClose(Player $who) : void {
		if (isset($this->isSent[$who->getXuid()])) {
			$who->getNetworkSession()->sendDataPacket(UpdateBlockPacket::create(
				BlockPosition::fromVector3($this->holder),
				TypeConverter::getInstance()->getBlockTranslator()->internalIdToNetworkId($who->getWorld()->getBlock($this->holder)->getStateId()),
				UpdateBlockPacket::FLAG_NETWORK,
				UpdateBlockPacket::DATA_LAYER_NORMAL
			));
			unset($this->isSent[$who->getXuid()]);
		}
		parent::onClose($who);
	}

	public function send(Player $player) : void {
		if (!isset($this->isSent[$player->getXuid()])) {
			$this->holder = new Position(
				(int) $player->getPosition()->getX(),
				(int) $player->getPosition()->getY() - 3,
				(int) $player->getPosition()->getZ(),
				$player->getWorld()
			);
			$player->getNetworkSession()->sendDataPacket(
				UpdateBlockPacket::create(
					BlockPosition::fromVector3($this->holder),
					TypeConverter::getInstance()->getBlockTranslator()->internalIdToNetworkId(VanillaBlocks::ENDER_CHEST()->getStateId()),
					UpdateBlockPacket::FLAG_NETWORK,
					UpdateBlockPacket::DATA_LAYER_NORMAL
				)
			);
			$nbt    = CompoundTag::create()->setString(Nameable::TAG_CUSTOM_NAME, $this->getName());
			$packet = BlockActorDataPacket::create(BlockPosition::fromVector3($this->holder), new CacheableNbt($nbt));
			$player->getNetworkSession()->sendDataPacket($packet);
			$player->setCurrentWindow($this);
			$this->isSent[$player->getXuid()] = true;
		}
	}

}
