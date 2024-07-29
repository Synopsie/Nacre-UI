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
 * @author SynopsieTeam
 * @link https://nacre.arkaniastudios.com/home.html
 * @version 2.0.1
 *
 */

declare(strict_types=1);

namespace nacre\libs\muqsit\simplepackethandler\monitor;

use Closure;
use pocketmine\plugin\Plugin;

final class PacketMonitor implements IPacketMonitor {
	private PacketMonitorListener $listener;

	public function __construct(Plugin $register, bool $handle_cancelled) {
		$this->listener = new PacketMonitorListener($register, $handle_cancelled);
	}

	public function monitorIncoming(Closure $handler) : IPacketMonitor {
		$this->listener->monitorIncoming($handler);
		return $this;
	}

	public function monitorOutgoing(Closure $handler) : IPacketMonitor {
		$this->listener->monitorOutgoing($handler);
		return $this;
	}

	public function unregisterIncomingMonitor(Closure $handler) : IPacketMonitor {
		$this->listener->unregisterIncomingMonitor($handler);
		return $this;
	}

	public function unregisterOutgoingMonitor(Closure $handler) : IPacketMonitor {
		$this->listener->unregisterOutgoingMonitor($handler);
		return $this;
	}
}
