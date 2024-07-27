<?php
declare(strict_types=1);

namespace nacre\bossbar;

use InvalidArgumentException;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\BossEventPacket;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

class BossListener implements Listener {

    private static ?Plugin $registrant = null;

    public static function isRegistered(): bool {
        if(self::$registrant === null) return false;
        return self::$registrant instanceof Plugin;
    }

    public static function unregister(): void {
        self::$registrant = null;
    }

    public static function register(Plugin $plugin): void {
        if (self::isRegistered()) {
            return;
        }

        self::$registrant = $plugin;
        $plugin->getServer()->getPluginManager()->registerEvents(new self, $plugin);
    }

    public function onDataPacketReceiveEvent(DataPacketReceiveEvent $e) : void{
        if ($e->getPacket() instanceof BossEventPacket) $this->onBossEventPacket($e);
    }

    private function onBossEventPacket(DataPacketReceiveEvent $e) : void {
        if (!($pk = $e->getPacket()) instanceof BossEventPacket) throw new InvalidArgumentException(get_class($e->getPacket()) . " is not a " . BossEventPacket::class);
        /** @var BossEventPacket $pk */
        switch ($pk->eventType) {
            case BossEventPacket::TYPE_REGISTER_PLAYER:
            case BossEventPacket::TYPE_UNREGISTER_PLAYER:
                Server::getInstance()->getLogger()->debug("Got BossEventPacket " . ($pk->eventType === BossEventPacket::TYPE_REGISTER_PLAYER ? "" : "un") . "register by client for player id " . $pk->playerActorUniqueId);
                break;
            default:
                $e->getOrigin()->getPlayer()->kick("Invalid packet received");
        }
    }
}
