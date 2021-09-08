<?php
declare(strict_types = 1);

namespace origin\reboot\utils;

use pocketmine\utils\Internet;
use pocketmine\Server;

trait RebootTrait{
	
	public function restart() :void{
		$server = Server::getInstance();
		$ip = Internet::getInternalIP();
		$port = $server->getPort();
		foreach($server->getWorldManager()->getWorlds() as $world){
			$world->save(true);
		}
		foreach($server->getOnlinePlayers() as $player){
			$player->save();
			$player->transfer($ip, $port, '자동 재접속을 시도 합니다.');
		}
		$server->shutdown();
	}
	
	public function alert() :void{
		$server = Server::getInstance();
		$server->broadcastMessage('§l§a[§f재부팅§a]§r 3초뒤 재부팅 됩니다.');
		$server->broadcastTitle('§a재부팅', '3초뒤 재부팅 됩니다.');
	}
	
}