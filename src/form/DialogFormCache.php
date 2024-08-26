<?php
declare(strict_types=1);

namespace nacre\form;

use nacre\form\class\DialogForm;
use pocketmine\entity\Entity;

class DialogFormCache {

    static private array $cache = [];

    public static function getFormByEntity(Entity $entity) : ?DialogForm {
        return self::$cache[$entity->getId()] ?? null;
    }

    public static function addForm(DialogForm $form) : void {
        self::$cache[$form->getEntity()->getId()] = $form;
    }

    public static function removeForm(DialogForm $form) : void {
        unset(self::$cache[$form->getEntity()->getId()]);
    }

}