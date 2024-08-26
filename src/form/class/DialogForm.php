<?php
declare(strict_types=1);

namespace nacre\form\class;

use nacre\form\elements\buttons\Button;
use pocketmine\entity\Entity;
use pocketmine\network\mcpe\protocol\NpcDialoguePacket;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\player\Player;

final class DialogForm {

    private Entity $entity;
    private string $title;
    private string $dialogText;

    /** @var callable $onSubmit */
    private $onSubmit;

    /** @var callable $onClose */
    private $onClose;

    /** @var Button[] */
    private array $buttons = [];

    public function __construct(
        Entity $entity,
        string $title,
        string $dialogText,
        array $buttons,
        callable $onSubmit,
        callable $onClose
    ) {
        $property = $entity->getNetworkProperties();
        $property->setByte(EntityMetadataProperties::HAS_NPC_COMPONENT, 1);
        $property->setString(EntityMetadataProperties::INTERACTIVE_TAG, $dialogText);
        $property->setString(EntityMetadataProperties::NPC_ACTIONS, json_encode($this->buttons));

        $this->entity = $entity;
        $this->title = $title;
        $this->dialogText = $dialogText;
        $this->buttons = $buttons;
        $this->onSubmit = $onSubmit;
        $this->onClose = $onClose;
    }

    public function getSubmitCallable() : callable {
        return $this->onSubmit;
    }

    public function getCloseCallable() : callable {
        return $this->onClose;
    }

    /**
     * @return Entity
     */
    public function getEntity() : Entity {
        return $this->entity;
    }

    public function onOpen(Player $player) : void {
        $packet = NpcDialoguePacket::create(
            $this->entity->getId(),
            NpcDialoguePacket::ACTION_OPEN,
            $this->dialogText,
            (string)$this->entity->getId(),
            $this->title,
            json_encode($this->buttons)
            );
        $player->getNetworkSession()->sendDataPacket($packet);
    }

    public function onClose(Player $player) : void {
        $packet = NpcDialoguePacket::create(
            $this->entity->getId(),
            NpcDialoguePacket::ACTION_CLOSE,
            $this->dialogText,
            (string)$this->entity->getId(),
            $this->title,
            json_encode($this->buttons)
        );
        $player->getNetworkSession()->sendDataPacket($packet);
    }

}