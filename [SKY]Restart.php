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
    $this->getScheduler()->scheduleDelayedTask(new ClosureTask(function() : void{
      $this->restart();
    }), 120 * self::DELAY);
  }
  
  public function restart():void{
    $server = $this->getServer();
    foreach($server->getLevels() as $level){
      $level->save();
    }
    foreach($server->getOnlinePlayers() as $player){
      
    }
  }
  
}
