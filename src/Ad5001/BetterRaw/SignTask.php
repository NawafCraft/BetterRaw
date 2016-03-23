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

   class SignTask extends PluginTask  {
    private $player;
	private $plugin;
    public function __construct($plugin, $player){
        parent::__construct($plugin);
        $this->player = $player;
		$this->plugin = $plugin;
		$player->sendMessage("Test");
    }
    public function onRun($tick){
		 foreach ($this->plugin->getServer()->getLevels() as $levels) {
                  foreach ($levels->getTiles() as $tile) {
                     if ($tile instanceof Sign) {
                         if ($tile->getText()[0] === "[BetterRaw]") {
							 $tile->setText("§e-=<>=-", $tile->getText()[1], $tile->getText()[2], $tile->getText()[3]);
						}
						 if ($tile->getText()[0] === "§e-=<>=-") {
							  // Default values
					          $colors = [C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::GOLD, C::GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::WHITE];
					          $mc = "§mc";
					          // Line 2
							  $randcolors = rand(0, 11);
					          $line1 = $tile->getText()[1];
							  $color = [$colors[$randcolors], "§m"];
					          $line1 = str_replace($mc, implode("", $color), $line1);
							  while ($id <= 11) {
								  $color = [$colors[$id], "§m"];
								  $line1 = str_replace($color, implode("", $color), $line1);
								  $id++;
							  }
					          // Line 3
					          $randcolors = rand(0, 11);
					          $line2 = $tile->getText()[2];
							  $color = [$colors[$randcolors], "§m"];
					          $line2 = str_replace($mc, implode("", $color), $line2);
							  $id = 0;
							  while ($id <= 12) {
								  $color = [$colors[$id], "§m"];
								  $line2 = str_replace($color, implode("", $color), $line2);
								  $id++;
							  }
					          // Line 4
					          $randcolors = rand(0, 11);
					          $line3 = $tile->getText()[3];
							  $color = [$colors[$randcolors], "§m"];
					          $line3 = str_replace($mc, implode("", $color), $line3);
							  while ($id <= 11) {
								  $color = [$colors[$id], "§m"];
								  $line3 = str_replace($color, implode("", $color), $line3);
								  $id++;
							  }
                              $tile->setText($tile->getText()[0], $line1, $line2, $line3);
						 }
					 }
				  }
			  }
			  $this->plugin->getServer()->getScheduler()->cancelTask($this->getTaskId());
		switch($tick){
          case 1:
		  $sender->sendMessage("Test");
              foreach ($this->plugin->getServer()->getLevels() as $levels) {
                  foreach ($levels->getTiles() as $tile) {
                     if ($tile instanceof Sign) {
                         if ($tile->getText()[0] === "[BetterRaw]") {
							 $tile->setText("§e-=<>=-", $tile->getText()[1], $tile->getText()[2], $tile->getText()[3]);
						}
						 if ($tile->getText()[0] === "§e-=<>=-") {
							  // Default values
					          $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
					          $lastcolor = "§mc";
					          // Line 2
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line1 = $tile->getText()[1];
					          $line1 = str_replace($lastcolor, implode("", $color), $line1);
					          $lastcolor = implode("", $color);
					          // Line 3
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line2 = $tile->getText()[2];
					          $line2 = str_replace($lastcolor, implode("", $color), $line2);
					          $lastcolor = implode("", $color);
					          // Line 4
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line3 = $tile->getText()[3];
					          $line3 = str_replace($lastcolor, implode("", $color), $line3);
					          $lastcolor = implode("", $color);
                              $tile->setText($tile->getText()[0], $line1, $line2, $line3);
						 }
					 }
				  }
			  }
			  return true;
			  break;
          case 10:
              foreach ($this->plugin->getServer()->getLevels() as $levels) {
                  foreach ($levels->getTiles() as $tile) {
                     if ($tile instanceof Sign) {
                         if ($tile->getText()[0] === "[BetterRaw]") {
							 $tile->setText("§e-=<>=-", $tile->getText()[1], $tile->getText()[2], $tile->getText()[3]);
						}
						 if ($tile->getText()[0] === "§e-=<>=-") {
							  // Default values
					          $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
					          $lastcolor = "§mc";
					          // Line 2
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line1 = $tile->getText()[1];
					          $line1 = str_replace($lastcolor, implode("", $color), $line1);
					          $lastcolor = implode("", $color);
					          // Line 3
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line2 = $tile->getText()[2];
					          $line2 = str_replace($lastcolor, implode("", $color), $line2);
					          $lastcolor = implode("", $color);
					          // Line 4
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line3 = $tile->getText()[3];
					          $line3 = str_replace($lastcolor, implode("", $color), $line3);
					          $lastcolor = implode("", $color);
                              $tile->setText($tile->getText()[0], $line1, $line2, $line3);
						 }
					 }
				  }
			  }
			  return true;
			  break;
          case 20:
              foreach ($this->plugin->getServer()->getLevels() as $levels) {
                  foreach ($levels->getTiles() as $tile) {
                     if ($tile instanceof Sign) {
                         if ($tile->getText()[0] === "[BetterRaw]") {
							 $tile->setText("§e-=<>=-", $tile->getText()[1], $tile->getText()[2], $tile->getText()[3]);
						}
						 if ($tile->getText()[0] === "§e-=<>=-") {
							  // Default values
					          $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
					          $lastcolor = "§mc";
					          // Line 2
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line1 = $tile->getText()[1];
					          $line1 = str_replace($lastcolor, implode("", $color), $line1);
					          $lastcolor = implode("", $color);
					          // Line 3
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line2 = $tile->getText()[2];
					          $line2 = str_replace($lastcolor, implode("", $color), $line2);
					          $lastcolor = implode("", $color);
					          // Line 4
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line3 = $tile->getText()[3];
					          $line3 = str_replace($lastcolor, implode("", $color), $line3);
					          $lastcolor = implode("", $color);
                              $tile->setText($tile->getText()[0], $line1, $line2, $line3);
						 }
					 }
				  }
			  }
			  return true;
			  break;
          case 30:
              foreach ($this->plugin->getServer()->getLevels() as $levels) {
                  foreach ($levels->getTiles() as $tile) {
                     if ($tile instanceof Sign) {
                         if ($tile->getText()[0] === "[BetterRaw]") {
							 $tile->setText("§e-=<>=-", $tile->getText()[1], $tile->getText()[2], $tile->getText()[3]);
						}
						 if ($tile->getText()[0] === "§e-=<>=-") {
							  // Default values
					          $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
					          $lastcolor = "§mc";
					          // Line 2
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line1 = $tile->getText()[1];
					          $line1 = str_replace($lastcolor, implode("", $color), $line1);
					          $lastcolor = implode("", $color);
					          // Line 3
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line2 = $tile->getText()[2];
					          $line2 = str_replace($lastcolor, implode("", $color), $line2);
					          $lastcolor = implode("", $color);
					          // Line 4
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line3 = $tile->getText()[3];
					          $line3 = str_replace($lastcolor, implode("", $color), $line3);
					          $lastcolor = implode("", $color);
                              $tile->setText($tile->getText()[0], $line1, $line2, $line3);
						 }
					 }
				  }
			  }
			  return true;
			  break;
		  case 40:
              foreach ($this->plugin->getServer()->getLevels() as $levels) {
                  foreach ($levels->getTiles() as $tile) {
                     if ($tile instanceof Sign) {
                         if ($tile->getText()[0] === "[BetterRaw]") {
							 $tile->setText("§e-=<>=-", $tile->getText()[1], $tile->getText()[2], $tile->getText()[3]);
						}
						 if ($tile->getText()[0] === "§e-=<>=-") {
							  // Default values
					          $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
					          $lastcolor = "§mc";
					          // Line 2
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line1 = $tile->getText()[1];
					          $line1 = str_replace($lastcolor, implode("", $color), $line1);
					          $lastcolor = implode("", $color);
					          // Line 3
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line2 = $tile->getText()[2];
					          $line2 = str_replace($lastcolor, implode("", $color), $line2);
					          $lastcolor = implode("", $color);
					          // Line 4
					          $randcolors = rand(0, 15);
					          $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					          $line3 = $tile->getText()[3];
					          $line3 = str_replace($lastcolor, implode("", $color), $line3);
					          $lastcolor = implode("", $color);
                              $tile->setText($tile->getText()[0], $line1, $line2, $line3);
						 }
					 }
				  }
			  }
			  return true;
			  break;
        }
    }
    public function tileupdate(SignChangeEvent $event){
                if($event->getBlock()->getID() == 323 || $event->getBlock()->getID() == 63 || $event->getBlock()->getID() == 68){Server::getInstance()->broadcastMessage("DebugASignHasBeenPlaced"); //DEBUG$sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
                   if(!($sign instanceof Sign)){
                      return true;
                   }
                 $sign = $event->getLines();
                   if($sign[0] === $this->plugin->getConfig()->get("SignToChange")) {
					   # On placing block
					   $event->setLine(0, TextFormat::YELLOW . $this->plugin->getConfig()->get("SignChanged"));
				    } if ($sign[0] === TextFormat::YELLOW . $this->plugin->getConfig()->get("SignChanged")) {
					   // Default values
					   $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
					   $lastcolor = "§mc";
					   // Line 2
					   $randcolors = rand(0, 15);
					   $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					   $line1 = $sign[1];
					   $line1 = str_replace($lastcolor, implode("", $color), $line1);
					   $lastcolor = implode("", $color);
                       $event->setLine(1, $line1);
					   // Line 3
					   $randcolors = rand(0, 15);
					   $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					   $line2 = $sign[2];
					   $line2 = str_replace($lastcolor, implode("", $color), $line2);
					   $lastcolor = implode("", $color);
                       $event->setLine(2, $line2);
					   // Line 4
					   $randcolors = rand(0, 15);
					   $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
					   $line3 = $sign[3];
					   $line3 = str_replace($lastcolor, implode("", $color), $line3);
					   $lastcolor = implode("", $color);
                       $event->setLine(3, $line3);
				 }
				}	
	}
}