<?php
namespace Ad5001\BetterRaw;

use pocketmine\server;
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\ServerScheduler;
use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\Player;
use pocketmine\tile\Sign;
use pocketmine\utils\TextFormat as C;
use pocketmine\IPlayer;
use Ad5001\BetterRaw\Main;
use pocketmine\plugin\PluginBase;

   class BanTask extends PluginTask  {
    private $player;
	private $plugin;
    public function __construct($plugin, $player){
        parent::__construct($plugin);
		$this->plugin = $plugin;
		$this->player = $player;
    }
    public function onRun($tick){
		$this->player = $player;
		if(($this->player = $this->plugin->getServer()->getPlayerExact($this->player)) instanceof Player){
			 $this->player->kick($this->plugin->getConfig()->get("LastBanMSG"), false);
		}
    }
   }