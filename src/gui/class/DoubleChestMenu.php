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
 * @version 4.0.0
 *
 */

declare(strict_types=1);

namespace nacre\gui\class;

use nacre\gui\BaseMenu;
use nacre\gui\MenuTrait;
use nacre\NacreUI;
use pocketmine\block\inventory\BlockInventory;
use pocketmine\block\inventory\BlockInventoryTrait;
use pocketmine\block\tile\Nameable;
use pocketmine\block\VanillaBlocks;
use pocketmine\inventory\SimpleInventory;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\BlockActorDataPacket;
use pocketmine\network\mcpe\protocol\types\BlockPosition;
use pocketmine\network\mcpe\protocol\types\CacheableNbt;
use pocketmine\network\mcpe\protocol\UpdateBlockPacket;
use pocketmine\player\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\world\Position;

final class DoubleChestMenu extends SimpleInventory implements BaseMenu, BlockInventory {
	use MenuTrait {
		MenuTrait::__construct as private __menuConstruct;
	}
	use BlockInventoryTrait;

	public function __construct(
		string $name,
		bool $viewOnly = false,
		?array $contents = null,
		?callable $clickHandler = null,
		?callable $closeHandler = null,
		?string $permission = null
	) {
		parent::__construct(54);
		$this->__menuConstruct($this, $name, $viewOnly, $contents, $clickHandler, $closeHandler, $permission);
	}

	private array $isSent = [];

	public function onClose(Player $who) : void {
		if (isset($this->isSent[$who->getXuid()])) {
			$who->getNetworkSession()->sendDataPacket(
				UpdateBlockPacket::create(
					BlockPosition::fromVector3($this->holder),
					TypeConverter::getInstance()->getBlockTranslator()->internalIdToNetworkId($who->getWorld()->getBlock($this->holder)->getStateId()),
					UpdateBlockPacket::FLAG_NETWORK,
					UpdateBlockPacket::DATA_LAYER_NORMAL
				)
			);
			$who->getNetworkSession()->sendDataPacket(
				UpdateBlockPacket::create(
					BlockPosition::fromVector3($this->holder->add(1, 0, 0)),
					TypeConverter::getInstance()->getBlockTranslator()->internalIdToNetworkId($who->getWorld()->getBlock($this->holder->add(1, 0, 0))->getStateId()),
					UpdateBlockPacket::FLAG_NETWORK,
					UpdateBlockPacket::DATA_LAYER_NORMAL
				)
			);
			unset($this->isSent[$who->getXuid()]);
		}
		if($this->closeHandler !== null) {
			($this->closeHandler)($who, $this);
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
					TypeConverter::getInstance()->getBlockTranslator()->internalIdToNetworkId(VanillaBlocks::CHEST()->getStateId()),
					UpdateBlockPacket::FLAG_NETWORK,
					UpdateBlockPacket::DATA_LAYER_NORMAL
				)
			);
			$player->getNetworkSession()->sendDataPacket(
				UpdateBlockPacket::create(
					BlockPosition::fromVector3($this->holder->add(1, 0, 0)),
					TypeConverter::getInstance()->getBlockTranslator()->internalIdToNetworkId(VanillaBlocks::CHEST()->getStateId()),
					UpdateBlockPacket::FLAG_NETWORK,
					UpdateBlockPacket::DATA_LAYER_NORMAL
				)
			);
			$nbt = CompoundTag::create()->setString(Nameable::TAG_CUSTOM_NAME, $this->name)
				->setInt("pairx", $this->holder->x + 1)
				->setInt("pairz", $this->holder->z);
			$packet = BlockActorDataPacket::create(BlockPosition::fromVector3($this->holder), new CacheableNbt($nbt));
			$player->getNetworkSession()->sendDataPacket(
				BlockActorDataPacket::create(
					BlockPosition::fromVector3($this->holder->add(1, 0, 0)),
					new CacheableNbt(CompoundTag::create())
				)
			);
			$player->getNetworkSession()->sendDataPacket($packet);
			NacreUI::getPlugin()->getScheduler()->scheduleDelayedTask(new ClosureTask(
				function () use ($player) : void {
					$player->setCurrentWindow($this);
				}
			), 2);
			$this->isSent[$player->getXuid()] = true;
		}
		$this->sendInv($player);
	}

}
