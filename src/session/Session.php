<?php
declare(strict_types=1);

namespace nacre\session;

use nacre\gui\BaseMenu;

class Session {
    use SessionStorage;

    private static ?BaseMenu $currentInventory = null;

    public function setCurrent(?BaseMenu $inventory) : void {
        self::$currentInventory = $inventory;
    }

    public function getCurrent() : ?BaseMenu {
        return self::$currentInventory;
    }

}