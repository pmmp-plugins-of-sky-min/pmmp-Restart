<?php
declare(strict_types = 1);

namespace origin\reboot;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;

use origin\reboot\utils\RebootTrait;
use origin\reboot\command\MainCmd;

final class Loader extends PluginBase{
	use RebootTrait;
	
	private static $instance = null;
	
	private const DELAY = 30; //재부팅 주기(분)
	
	public static function getInstance() :?Loader{
		return self::$instance;
	}
	
	public function onLoad() :void{
		if (self::$instance === null)
			self::$instance = $this;
	}
	
	public function onEnable() :void{
		$this->getServer()->getCommandMap()->register('reboot', new MainCmd($this));
		$this->getScheduler()->scheduleDelayedTask(new ClosureTask(function() : void{
			$this->alert();
		}), 1200 * self::DELAY - 65);
		$this->getScheduler()->scheduleDelayedTask(new ClosureTask(function() : void{
			$this->restart();
		}), 1200 * self::DELAY);
	}
	
} 