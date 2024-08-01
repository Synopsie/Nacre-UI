<?php
declare(strict_types=1);

namespace nacre\session;

use pocketmine\network\mcpe\NetworkSession;
use pocketmine\player\Player;
use WeakMap;

trait SessionStorage {
    private Player $player;
    private static WeakMap $map;
    protected static ?array $tradeInfos = null;
    protected static bool $tradeMode    = false;

    public static function get(Player $player) : Session {
        if(!isset(self::$map[$player])) {
            /** @var WeakMap<Player, Session> $weakMap */
            $weakMap   = new WeakMap();
            self::$map = $weakMap;
        }
        return self::$map[$player] ?? new Session($player->getNetworkSession());
    }

    public function __construct(NetworkSession $session) {
        $this->player = $session->getPlayer();
    }

    public static function create(NetworkSession $session) : Session {
        return new Session($session);

    }

    public function getPlayer() : Player {
        return $this->player;
    }

}
