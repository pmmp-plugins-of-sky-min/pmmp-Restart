<?php
declare(strict_types = 1);

namespace origin\reboot\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\scheduler\ClosureTask;

use origin\reboot\Loader;
use origin\reboot\utils\RebootTrait;

final class MainCmd extends Command{
	use RebootTrait;
	
	public function __construct(private Loader $plugin){
		parent::__construct('reboot', '서버 재부팅', '/reboot', ['재부팅', '제부팅']);
		$this->setPermission('reboot.cmd.permission');
	}
	
	public function execute(CommandSender $sender, string $commandLabel, array $args) :void{
		$this->alert();
		$this->plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(function() : void{
			$this->restart();
		}), 60);
	}
	
}
