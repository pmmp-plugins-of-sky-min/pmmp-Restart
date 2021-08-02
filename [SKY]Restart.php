<?php

/**
 * @name DragonDeathEffect
 * @main skymin\server\Restart
 * @author skymin
 * @version SKY
 * @api 3.0.0
 */

declare(strict_types = 1);

namespace skymin\server;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

use pocketmine\scheduler\ClosureTask;

class Restart extends PluginBase{
  
  private static $instance = null;
  
  private const DELAY = 30;
  
  public static function getInstance():Restart{
    return self::$instance;
  }
	
  public function onLoad ():void{
    if (self::$instance === null)
      self::$instance = $this;
  }
  
  public function onEnable():void{
    $cmd = new PluginCommand('reboot', $this);
    $cmd->setPermission('op');
    $cmd->setUsage('/reboot');
    $cmd->setDescription('made  by sinestrea');
    $this->getServer()->getCommandMap()->register($this->getDescription()->getName(), $cmd);
    $this->getScheduler()->scheduleDelayedTask(new ClosureTask(function() : void{
      $this->getServer()->broadcastMessage('§l§a[§f재부팅§a]§r 3초뒤 재부팅 됩니다.');
    }), 120 * self::DELAY - 60);
    $this->getScheduler()->scheduleDelayedTask(new ClosureTask(function() : void{
      $this->restart();
    }), 120 * self::DELAY);
  }
  
  public function restart():void{
    $server = $this->getServer();
    $ip = $server->getIp();
    $port = $server->getPort();
    foreach($server->getLevels() as $level){
      $level->save(true);
    }
    foreach($server->getOnlinePlayers() as $player){
      $player->save();
      $player->transfer($ip, $port, '자동 재접속을 시도 합니다.');
    }
    $this->plugin->getServer()->shutdown();
  }
  
}
