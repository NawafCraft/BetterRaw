<?php
namespace Ad5001\BetterRaw;

/*
                         _______________________________________________________________
                        /                 BetterRaw Plugin by Ad30001 !                  \
                        /               This plugin is work in progress!                \
                        /  Feel free to make issues or/and help me correcting bugs :)   \
                        -----------------------------------------------------------------
*/

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\katana\Console;
use pocketmine\IPlayer;
use Ad5001\BetterRaw\SignTask;
use Ad5001\BetterRaw\BanTask;
use Ad5001\BetterRaw\ConfigReloadTask;
use Ad5001\BetterRaw\FloatingTask;
use pocketmine\utils\TextFormat as C;
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\ServerScheduler;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\server;
use pocketmine\plugin\PluginBase;
   class Main extends PluginBase implements Listener {
          public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
                 switch($cmd->getName()) {
					     case "betterrawlang":
						 if(empty($args[0])) {
							 $sender->sendMessage("§4Usage /brl <en | fr | de | es>");
						 } else {
							 switch($args[0]) {
								 case "en":
							    file_put_contents($this->getDataFolder() . "config.yml", $this->getResource("en.yml"));
								$sender->sendMessage("English has been succefuly set to your language!");
								return true;
								break;
							case "fr":
							    file_put_contents($this->getDataFolder() . "config.yml", $this->getResource("fr.yml"));
								$sender->sendMessage("Le français a bien été selctionné comme votre langue");
								return true;
								break;
						    case "de":
							    file_put_contents($this->getDataFolder() . "config.yml", $this->getResource("de.yml"));
								$sender->sendMessage("Deutch wurde als Sprache ausgewählt");
								return true;
								break;
						    case "es":
							file_put_contents($this->getDataFolder() . "config.yml", $this->getResource("es.yml"));
								$sender->sendMessage("Lengua española ha sido seleccionada");
							    return true;
								break;
						    default:
							    $sender->sendMessage("Language not recognized! Please select a valid language!");
								return true;
								break;
							 }
						 }
						 return true;
						 break;
						 case "floatingraw":
						  if(count($args) < 1){
                            $sender->sendMessage("§4Usage: /floatingraw <message...>");
                            return true;
                           } else {
                            if($sender->hasPermission("braw.command.floatingraw")){
                                 if(!$sender instanceof Player){
                                   $sender->sendMessage("§4§l[Error]§r§4 You must execute this command in game!");
                                 } else {
                                 $args = str_replace("{line}", "\n", $args);
                                 $args = str_replace("&", "§", $args);
                                 $args = str_replace("fuck", "****", $args);
                                 $args = str_replace("shit", "****", $args);
								 $id = 1;
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
								 $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								 $lastcolor = "§mc";
								 $randcolors = rand(0, 15);
							     $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
								 $args = str_replace($lastcolor, implode("", $color), $args);
								 if(is_numeric($args[0]) and is_numeric($args[1]) and is_numeric($args[2])) {
									 $x = $args[0];
									 $y = $args[1] + 1;
									 $z = $args[2];
									 unset($args[0]);
									 unset($args[1]);
									 unset($args[2]);
								 } else {
								      $x = $sender->x;
								      $y = $sender->y + 1;
								      $z = $sender->z;
								 }
								 $level = $sender->getLevel();
								 $level->addParticle(new \pocketmine\level\particle\FloatingTextParticle(new Vector3($x, $y, $z), implode(" ", $args)));
								 $cfg = new Config($this->getDataFolder() . "floating.yml", Config::YAML);
								 $id = $cfg->get("LastNumber") + 1;
								 $cfg->set("X" . $id, $x);
								 $cfg->set("Y" . $id, $y);
								 $cfg->set("Z" . $id, $z);
								 $cfg->set("Text" . $id, implode("", $args));
								 $cfg->set("LastNumber", $id);
								 $cfg->save();
								 $command = $this->getConfig()->get("FloatingrawCmd");
								 $command = str_replace("&", "§", $command);
                                 $command = str_replace("tellraw", "tell", $command);
                                 $command = str_replace("tellworldraw", "say", $command);
								 $command = str_replace("{sender}", $sender->getName(), $command);
								 $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " added a floating text  (" . implode(" ",$args) . ")");
								 $msg = $this->getConfig()->get("FloatingrawMSG");
								 $msg = str_replace("&", "§", $msg);
								 $msg = str_replace("{message}", implode(" ",$args), $msg);
								 $msg = str_replace("{sender}", $sender->getName(), $msg);
                                 $sender->sendMessage("§a§l[FloatingRaw]§r§a " . $msg);
                              }
                            }
                           }
                           return true;
                           break;
					     case "betterrawload":
						 if($sender instanceof Player) {
								 $sender->sendMessage("§l§a[BetterRaw]§r§a Loading ...");
								 $this->getServer()->getScheduler()->scheduleRepeatingTask(new SignTask($this, $sender), 10);
								 $sender->sendMessage("§l§a[SignRaw]§r§a Signs have been loaded !");
								 $this->getServer()->getScheduler()->scheduleRepeatingTask(new ConfigReloadTask($this, $sender), 10);
								 $sender->sendMessage("§l§a[ConfigRaw]§r§a You can change your config at any time, change will be INSTANTLY APPLIED");
								 $this->getServer()->getScheduler()->scheduleRepeatingTask(new FloatingTask($this, $sender), 10);
								 $sender->sendMessage("§l§a[FloatingRaw]§r§a Floating texts now reloading proprely !");
						 } else {
							 $sender->sendMessage("§l§4[BetterRaw]§r§4 Please use this command in-game !");
						 }
						 return true;
						 break;
						 case "news":
					       if($this->getConfig()->get("TellNews") === "onCommand") {
							   $news = file_get_contents("http://ad5001.cf/news.txt");
							   $sender->sendMessage("Last news: \n" . $news);
						    }
						 return true;
						 break;
                         case "tellraw":
                           // tellraw command
                          if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /tellraw <player> <message...>");
                            return true;
                           } else {
                            if($sender->hasPermission("braw.command.tellraw")){
                                 $player = $this->getServer()->getPlayer($args[0]);
                                 if(!$player instanceof Player){
                                   $sender->sendMessage("§4§l[Error]§r§4 Player not found");
                                 } else {
                                 unset($args[0]);
                                 $args = str_replace("{line}", "\n", $args);
                                 $args = str_replace("&", "§", $args);
                                 $args = str_replace("fuck", "****", $args);
                                 $args = str_replace("shit", "****", $args);
								 $id = 1;
								 $chars = ["a", "b", "c", "d", "e", "f",  "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", 1, 2, 3 ,4, 5, 6, 7, 8, 9, 0,];
                   $circled = ["ⓐ", "ⓑ", "ⓒ", "ⓓ", "ⓔ", "ⓕ", "ⓖ", "ⓗ", "ⓘ", "ⓙ", "ⓚ", "ⓛ", "ⓜ", "ⓝ", "ⓞ", "ⓟ", "ⓠ", "ⓡ", "ⓢ", "ⓣ", "ⓤ", "ⓥ", "ⓦ", "ⓧ", "ⓨ", "ⓩ", "①", "②", "③", "④", "⑤⑤
", "⑥", "⑦", "⑧", "⑨", "⓪"]
								 $i = 0;
								 while($i  <= 35) {
									 $args = str_ireplace("°" . $char[$i], $circled[$i], $args);
									 $args = str_ireplace("_" . $char[$i],  $underline[$i],  $args);
									 $i++;
								 }
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
								 $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								 $lastcolor = "§mc";
								 $randcolors = rand(0, 15);
							     $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
								 $args = str_replace($lastcolor, implode("", $color), $args);
                                 $player->sendMessage(implode(" ",$args));
								 $command = $this->getConfig()->get("TellrawCmd");
								 $command = str_replace("&", "§", $command);
                                 $command = str_replace("tellraw", "tell", $command);
                                 $command = str_replace("tellworldraw", "say", $command);
								 $command = str_replace("{player}", $player->getName(), $command);
								 $command = str_replace("{sender}", $sender->getName(), $command);
								 $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " tellrawed " . $player->getName() . " (" . implode(" ",$args) . ")");
								 $msg = $this->getConfig()->get("TellrawMSG");
								 $msg = str_replace("&", "§", $msg);
								 $msg = str_replace("{message}", implode(" ",$args), $msg);
								 $msg = str_replace("{player}", $player->getName(), $msg);
								 $msg = str_replace("{sender}", $sender->getName(), $msg);
                                 $sender->sendMessage("§a§l[Tellraw]§r§a " . $msg);
                              }
                            }
                           }
                           return true;
                           break;
                         case "tellworldraw":
                           // tellworldraw command
                          if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /tellworldraw <world> <message...>");
                            return true;
                           } else {
                               if(!$this->getServer()->isLevelGenerated($args[0])) {
                                 $sender->sendMessage("§l§4[Error]§r§4 Level not found");
                               } else {
                               foreach($this->getServer()->getLevelByName($args[0])->getPlayers() as $worldplayers){
								   $level = $this->getServer()->getLevelByName($args[0]);
                                 $levelname = $args[0];
                                 unset($args[0]);
                                 $args = str_replace("{line}", "\n", $args);
                                 $args = str_replace("&", "§", $args);
                                 $args = str_replace("fuck", "****", $args);
                                 $args = str_replace("shit", "****", $args);
								 $id = 1;
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
								 $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								 $lastcolor = "§mc";
								 $randcolors = rand(0, 15);
								 $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
								 $args = str_replace($lastcolor, implode("", $color), $args);
                                 $worldplayers->sendMessage(implode(" ",$args));
								 $command = $this->getConfig()->get("TellWorldRawCmd");
								 $command = str_replace("&", "§", $command);
                                 $command = str_replace("tellraw", "tell", $command);
                                 $command = str_replace("tellworldraw", "say", $command);
								 $command = str_replace("{world}", $levelname, $command);
								 $command = str_replace("{sender}", $sender->getName(), $command);
								 $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " sent a message on world :" . $levelname . " (" . implode(" ",$args) . ")");
								 $msg = $this->getConfig()->get("TellworldrawMSG");
								 $msg = str_replace("&", "§", $msg);
								 $msg = str_replace("{message}", implode(" ",$args), $msg);
								 $msg = str_replace("{world}", $levelname, $msg);
								 $msg = str_replace("{sender}", $sender->getName(), $msg);
                                 $sender->sendMessage("§b§l[TellWorldRaw]§r§b " . $msg);
                               }
                               }
                             }
                             return true;
                             break;
                         case "tip":
                           // tip command
                          if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /tip <player> <message...>");
                            return true;
                           } else {
                            if($sender->hasPermission("braw.command.tip")){
                                 $player = $this->getServer()->getPlayer($args[0]);
                                 if(!$player instanceof Player){
                                   $sender->sendMessage("§4§l[Error]§r§4 Player not found");
                                 } else {
                                 unset($args[0]);
                                 $args = str_replace("{line}", "\n", $args);
                                 $args = str_replace("&", "§", $args);
                                 $args = str_replace("fuck", "****", $args);
                                 $args = str_replace("shit", "****", $args);
								 $id = 1;
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
                                 $player->sendTip(implode(" ",$args));
								 $ntip = 0;
								 $time = 0;
								 $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								 $lastcolor = "§mc";
								 while ($ntip < 40) {
									 while ($time < 3000) {
										 $time++;
										 $player->sendPopup("§§" . $time);
									 }
									 if($time = 3000) {
										 $randcolors = rand(0, 15);
										 $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
										 $args = str_replace($lastcolor, implode("", $color), $args);
										 $player->sendTip(implode(" ",$args));
										 $time = 0;
										 $lastcolor = implode("", $color);
										 $ntip++;
									 }
								 }
								 $command = $this->getConfig()->get("TipCmd");
								 $command = str_replace("&", "§", $command);
                                 $command = str_replace("tip", "tell", $command);
                                 $command = str_replace("tipworld", "say", $command);
								 $command = str_replace("{player}", $player->getName(), $command);
								 $command = str_replace("{sender}", $sender->getName(), $command);
								 $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " sent a tip to " . $player->getName() . " (" . implode(" ",$args) . ")");
								 $msg = $this->getConfig()->get("TipMSG");
								 $msg = str_replace("&", "§", $msg);
								 $msg = str_replace("{message}", implode(" ",$args), $msg);
								 $msg = str_replace("{player}", $player->getName(), $msg);
								 $msg = str_replace("{sender}", $sender->getName(), $msg);
                                 $sender->sendMessage("§4§l[Tip]§r§4 " . $msg);
                              }
                            }
                           }
                           return true;
                           break;
                         case "popup":
                           // popup command
                          if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /popup <player> <message...>");
                            return true;
                           } else {
                            if($sender->hasPermission("braw.command.popup")){
                                 $player = $this->getServer()->getPlayer($args[0]);
                                 if(!$player instanceof Player){
                                   $sender->sendMessage("§4§l[Error]§r§4 Player not found");
                                 } else {
                                 unset($args[0]);
                                 $args = str_replace("{line}", "\n", $args);
                                 $args = str_replace("&", "§", $args);
                                 $args = str_replace("fuck", "****", $args);
                                 $args = str_replace("shit", "****", $args);
								 $id = 1;
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
                                 $player->sendPopup(implode(" ",$args));
								 $ntip = 0;
								 $time = 0;
								 $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								 $lastcolor = "§mc";
								 while ($ntip < 40) {
									 while ($time < 3000) {
										 $time++;
										 $player->sendTip("§§" . $time);
									 }
									 if($time = 3000) {
										 $randcolors = rand(0, 15);
										 $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
										 $args = str_replace($lastcolor, implode("", $color), $args);
										 $player->sendPopup(implode(" ",$args));
										 $time = 0;
										 $lastcolor = implode("", $color);
										 $ntip++;
									 }
								 }
								 $command = $this->getConfig()->get("PopupCmd");
								 $command = str_replace("&", "§", $command);
                                 $command = str_replace("popup", "tell", $command);
                                 $command = str_replace("popupworld", "say", $command);
								 $command = str_replace("{player}", $player->getName(), $command);
								 $command = str_replace("{sender}", $sender->getName(), $command);
								 $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " sent a popup to " . $player->getName() . " (" . implode(" ",$args) . ")");
								 $msg = $this->getConfig()->get("PopupMSG");
								 $msg = str_replace("&", "§", $msg);
								 $msg = str_replace("{message}", implode(" ",$args), $msg);
								 $msg = str_replace("{player}", $player->getName(), $msg);
								 $msg = str_replace("{sender}", $sender->getName(), $msg);
                                 $sender->sendMessage("§e§l[Popup]§r§e " . $msg);
                              }
                            }
                           }
                           return true;
                           break;
                          case "popupworld":
                           // popupworld command
                          if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /popupworld <world> <message...>");
                            return true;
                           } else {
                             if($sender->hasPermission("braw.command.popupworld")){
                               if(!$this->getServer()->isLevelGenerated($args[0])) {
                                 $sender->sendMessage("§l§4[Error]§r§4 Level not found");
                               } else {
                               foreach($this->getServer()->getLevelByName($args[0])->getPlayers() as $worldplayers){
                                 $levelname = $args[0];
                                 unset($args[0]);
                                 $args = str_replace("{line}", "\n", $args);
                                 $args = str_replace("&", "§", $args);
                                 $args = str_replace("fuck", "****", $args);
                                 $args = str_replace("shit", "****", $args);
								 $id = 1;
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
                                 $worldplayers->sendPopup(implode(" ",$args));
								 $ntip = 0;
								 $time = 0;
								 $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								 $lastcolor = "§mc";
								 while ($ntip < 40) {
									 while ($time < 3000) {
										 $time++;
										 $worldplayers->sendPopup("§§" . $time);
									 }
									 if($time = 3000) {
										 $randcolors = rand(0, 15);
										 $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
										 $args = str_replace($lastcolor, implode("", $color), $args);
										 $worldplayers->sendPopup(implode(" ",$args));
										 $time = 0;
										 $lastcolor = implode("", $color);
										 $ntip++;
									 }
								 }
								 $command = $this->getConfig()->get("PopupWorldCmd");
								 $command = str_replace("&", "§", $command);
                                 $command = str_replace("popup", "tell", $command);
                                 $command = str_replace("popupworld", "say", $command);
								 $command = str_replace("{world}", $levelname, $command);
								 $command = str_replace("{sender}", $sender->getName(), $command);
								 $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " sent a popup on world :" . $levelname . " (" . implode(" ",$args) . ")");
								 $msg = $this->getConfig()->get("PopupworldMSG");
								 $msg = str_replace("&", "§", $msg);
								 $msg = str_replace("{message}", implode(" ",$args), $msg);
								 $msg = str_replace("{world}", $levelname, $msg);
								 $msg = str_replace("{sender}", $sender->getName(), $msg);
                                 $sender->sendMessage("§d§l[PopupWorld]§r§d " . $msg);
                               }
                               }
                             }
                             return true;
                             break;
                           }
                          case "tipworld":
                           // tipworld command
                          if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /tipworld <world> <message...>");
                            return true;
                           } else {
                             if($sender->hasPermission("braw.command.tipworld")){
                               if(!$this->getServer()->isLevelGenerated($args[0])) {
                                 $sender->sendTip("§l§4[Error]§r§4 Level not found");
                               } else {
                               foreach($this->getServer()->getLevelByName($args[0])->getPlayers() as $worldplayers){
                                 $levelname = $args[0];
                                 unset($args[0]);
                                 $args = str_replace("{line}", "\n", $args);
                                 $args = str_replace("&", "§", $args);
                                 $args = str_replace("fuck", "****", $args);
                                 $args = str_replace("shit", "****", $args);
								 $id = 1;
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
                                 $worldplayers->sendTip(implode(" ",$args));
								 $ntip = 0;
								 $time = 0;
								 $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								 $lastcolor = "§mc";
								 while ($ntip < 40) {
									 while ($time < 3000) {
										 $time++;
										 $worldplayers->sendPopup("§§" . $time);
									 }
									 if($time = 3000) {
										 $randcolors = rand(0, 15);
										 $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
										 $args = str_replace($lastcolor, implode("", $color), $args);
										 $worldplayers->sendTip(implode(" ",$args));
										 $time = 0;
										 $lastcolor = implode("", $color);
										 $ntip++;
									 }
								 }
								 $command = $this->getConfig()->get("TipWorldCmd");
								 $command = str_replace("&", "§", $command);
                                 $command = str_replace("tip", "tell", $command);
                                 $command = str_replace("tipworld", "say", $command);
								 $command = str_replace("{world}", $levelname, $command);
								 $command = str_replace("{sender}", $sender->getName(), $command);
								 $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " sent a tip on world :" . $levelname . " (" . implode(" ",$args) . ")");
								 $msg = $this->getConfig()->get("TipworldMSG");
								 $msg = str_replace("&", "§", $msg);
								 $msg = str_replace("{message}", implode(" ",$args), $msg);
								 $msg = str_replace("{world}", $levelname, $msg);
								 $msg = str_replace("{sender}", $sender->getName(), $msg);
                                 $sender->sendMessage("§c§l[TipWorld]§r§c " . $msg);
                               }
                               }
                             }
                             return true;
                             break;
                           }
						   case "sayraw":
		 	                           // sayraw command
		 	                          if(count($args) < 1){
		 	                            $sender->sendMessage("§4Usage: /sayraw <message...>");
		 	                            return true;
		 	                           } else {
		 	                            if($sender->hasPermission("braw.command.sayraw")){
		 	                                 $args = str_replace("{line}", "\n", $args);
		 	                                 $args = str_replace("&", "§", $args);
		 	                                 $args = str_replace("fuck", "****", $args);
		 	                                 $args = str_replace("shit", "****", $args);
											 $id = 1;
											 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									             $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									             $id++;
								             }
											 $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								             $lastcolor = "§mc";
								             $randcolors = rand(0, 15);
								             $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
								             $args = str_replace($lastcolor, implode("", $color), $args);
		 	                                 $this->getServer()->broadcastMessage(implode(" ",$args));
											 $command = $this->getConfig()->get("SayrawCmd");
								             $command = str_replace("&", "§", $command);
                                             $command = str_replace("saytip", "say", $command);
								             $command = str_replace("saypopup", "say", $command);
                                             $command = str_replace("sayraw", "say", $command);
								             $command = str_replace("{sender}", $sender->getName(), $command);
								             $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
											 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " send a message to everyone in the server (" . implode(" ",$args) . ")");
											 $msg = $this->getConfig()->get("SayrawMSG");
								             $msg = str_replace("&", "§", $msg);
							              	 $msg = str_replace("{message}", implode(" ",$args), $msg);
							              	 $msg = str_replace("{message}", implode(" ",$args), $msg);
								             $msg = str_replace("{sender}", $sender->getName(), $msg);
		 	                                 $sender->sendMessage("§6§l[Sayraw]§r§6 " . $msg);
		 	                              }
		 	                            }
										return true;
										break;
						   case "saytip":
		 	                           // saytip command
		 	                          if(count($args) < 1){
		 	                            $sender->sendMessage("§4Usage: /saytip <message...>");
		 	                            return true;
		 	                           } else {
		 	                            if($sender->hasPermission("braw.command.saytip")){
		 	                                 $args = str_replace("{line}", "\n", $args);
		 	                                 $args = str_replace("&", "§", $args);
		 	                                 $args = str_replace("fuck", "****", $args);
		 	                                 $args = str_replace("shit", "****", $args);
											 $id = 1;
											 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									             $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									             $id++;
								             }
		 	                                 $this->getServer()->broadcastTip(implode(" ",$args));
											 $ntip = 0;
								             $time = 0;
								             $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								             $lastcolor = "§mc";
								             while ($ntip < 40) {
									             while ($time < 3000) {
										               $time++;
													   $this->getServer()->broadcastPopup("§§" . $time);
									             }
									             if($time = 3000) {
										             $randcolors = rand(0, 15);
										             $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
										             $args = str_replace($lastcolor, implode("", $color), $args);
										             $this->getServer()->broadcastTip(implode(" ",$args));
										             $time = 0;
										             $lastcolor = implode("", $color);
										             $ntip++;
									             }
								             }
											 $command = $this->getConfig()->get("SaytipCmd");
								             $command = str_replace("&", "§", $command);
                                             $command = str_replace("saytip", "say", $command);
								             $command = str_replace("saypopup", "say", $command);
                                             $command = str_replace("sayraw", "say", $command);
								             $command = str_replace("{sender}", $sender->getName(), $command);
								             $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
											 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " send a tip to everyone in the server (" . implode(" ",$args) . ")");
											 $msg = $this->getConfig()->get("SaytipMSG");
								             $msg = str_replace("&", "§", $msg);
							              	 $msg = str_replace("{message}", implode(" ",$args), $msg);
								             $msg = str_replace("{sender}", $sender->getName(), $msg);
		 	                                 $sender->sendMessage("§9§l[SayTip]§r§9 " . $msg);
		 	                              }
		 	                            }
										return true;
										break;
		 			       case "saypopup":
		 	                           // saypopup command
		 	                          if(count($args) < 1){
		 	                            $sender->sendMessage("§4Usage: /saypopup <message...>");
		 	                            return true;
		 	                           } else {
		 	                            if($sender->hasPermission("braw.command.saypopup")){
		 	                                 $args = str_replace("{line}", "\n", $args);
		 	                                 $args = str_replace("&", "§", $args);
		 	                                 $args = str_replace("fuck", "****", $args);
		 	                                 $args = str_replace("shit", "****", $args);
											 $id = 1;
											 $ntip = 0;
								             $time = 0;
								             $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								             $lastcolor = "§mc";
											 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									             $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									             $id++;
								             }
		 	                                 $this->getServer()->broadcastPopup(implode(" ",$args));
											 while ($ntip < 40) {
									             while ($time < 3000) {
										               $time++;
													   $this->getServer()->broadcastTip("§§" . $time);
									             }
									             if($time = 3000) {
										             $randcolors = rand(0, 15);
										             $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
										             $args = str_replace($lastcolor, implode("", $color), $args);
										             $this->getServer()->broadcastPopup(implode(" ",$args));
										             $time = 0;
										             $lastcolor = implode("", $color);
										             $ntip++;
									             }
								             }
											 $command = $this->getConfig()->get("SaypopupCmd");
								             $command = str_replace("&", "§", $command);
                                             $command = str_replace("saytip", "say", $command);
								             $command = str_replace("saypopup", "say", $command);
                                             $command = str_replace("sayraw", "say", $command);
								             $command = str_replace("{sender}", $sender->getName(), $command);
								             $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
											 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " send a popup to everyone in the server (" . implode(" ",$args) . ")");
											 $msg = $this->getConfig()->get("SaypopupMSG");
								             $msg = str_replace("&", "§", $msg);
							              	 $msg = str_replace("{message}", implode(" ",$args), $msg);
								             $msg = str_replace("{sender}", $sender->getName(), $msg);
		 	                                 $sender->sendMessage("§2§l[SayPopup]§r§2 " . $msg);
		 	                              }
		 	                            }
										return true;
										break;
						   case "ckick":
						       if(count($args) < 2) {
								   $sender->sendMessage("§4Usage: /ckick <player> <reason>");
							   } else {
								   $player = $this->getServer()->getPlayer($args[0]);
                                 if(!$player instanceof Player){
                                   $sender->sendMessage("§4§l[Error]§r§4 Player not found");
                                 } else {
									 unset($args[0]);
		 	                       $args = str_replace("{line}", "\n", $args);
		 	                       $args = str_replace("&", "§", $args);
		 	                       $args = str_replace("fuck", "****", $args);
		 	                       $args = str_replace("shit", "****", $args);
								   $id = 1;
								   while ($this->getConfig()->get("Replace" . $id) ==! null) {
									     $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									     $id++;
								   }
								   $command = $this->getConfig()->get("CkickRawCmd");
								   $command = str_replace("&", "§", $command);
								   $command = str_replace("{player}", $player->getName(), $command);
								   $command = str_replace("{sender}", $sender->getName(), $command);
								   $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								   $lastcolor = "§mc";
								   $randcolors = rand(0, 15);
								   $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
								   $args = str_replace($lastcolor, implode("", $color), $args);
								   $player->kick(implode(" ", $args), false);
								   $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								   $this->getServer()->getLogger()->info("§6" . $sender->getName() . " kicked " . $player->getName() . ". Reason: " . implode(" ",$args));
											 $msg = $this->getConfig()->get("CkickRawMSG");
								             $msg = str_replace("&", "§", $msg);
							              	 $msg = str_replace("{reason}", implode(" ",$args), $msg);
							               	 $msg = str_replace("{player}", $player->getName(), $msg);
								             $msg = str_replace("{sender}", $sender->getName(), $msg);
		 	                                 $sender->sendMessage("§1§l[CkickRaw]§r§1 " . $msg);
								 }
							   }
							   return true;
							   break;
						   case "cban":
						       if(count($args) < 2) {
								   $sender->sendMessage("§4Usage: /cban <player> <reason>");
							   } else {
								   $player = $this->getServer()->getPlayer($args[0]);
                                 if(!$player instanceof Player){
                                   $sender->sendMessage("§4§l[Error]§r§4 Player not found");
                                 } else {
									 unset($args[0]);
		 	                       $args = str_replace("{line}", "\n", $args);
		 	                       $args = str_replace("&", "§", $args);
		 	                       $args = str_replace("fuck", "****", $args);
		 	                       $args = str_replace("shit", "****", $args);
								   $id = 1;
								   while ($this->getConfig()->get("Replace" . $id) ==! null) {
									     $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									     $id++;
								   }
								   $command = $this->getConfig()->get("CbanCmd");
								   $command = str_replace("&", "§", $command);
								   $command = str_replace("{player}", $player->getName(), $command);
								   $command = str_replace("{sender}", $sender->getName(), $command);
								   $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								   $lastcolor = "§mc";
								   $randcolors = rand(0, 15);
								   $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
								   $args = str_replace($lastcolor, implode("", $color), $args);
								   $playername = $player->getName();
								   $pl = $player;
								   
								   $this->getServer()->getNameBans()->addBan($player, implode(" ",$args), null, $sender->getName());
								   $this->getConfig()->set("LastBanMSG", implode(" ",$args));
								   $this->getServer()->getScheduler()->scheduleRepeatingTask(new BanTask($this, $pl), 3);
								   if(($player = $sender->getServer()->getPlayerExact($playername)) instanceof Player){
			                           $player->kick(implode("", $args), false);
		                            }
								   
								   $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								   $this->getServer()->getLogger()->info("§6" . $sender->getName() . " kicked " . $playername . ". Reason: " . implode(" ",$args));
								   $msg = $this->getConfig()->get("CbanMSG");
								   $msg = str_replace("&", "§", $msg);
								   $msg = str_replace("{reason}", implode(" ",$args), $msg);
								   $msg = str_replace("{player}", $playername, $msg);
								   $msg = str_replace("{sender}", $sender->getName(), $msg);
								   $sender->sendMessage("§c§l[CbanRaw]§r§c " . $msg);
								 }
							   }
							   return true;
							   break;
						   case "cban-ip":
						       if(count($args) < 2) {
								   $sender->sendMessage("§4Usage: /cban-ip <player> <reason>");
							   } else {
								   $player = $this->getServer()->getPlayer($args[0]);
                                 if(!$player instanceof Player){
                                   $sender->sendMessage("§4§l[Error]§r§4 Player not found");
                                 } else {
									 unset($args[0]);
		 	                       $args = str_replace("{line}", "\n", $args);
		 	                       $args = str_replace("&", "§", $args);
		 	                       $args = str_replace("fuck", "****", $args);
		 	                       $args = str_replace("shit", "****", $args);
								   $id = 1;
								   while ($this->getConfig()->get("Replace" . $id) ==! null) {
									     $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									     $id++;
								   }
								   $command = $this->getConfig()->get("CbanIpCmd");
								   $command = str_replace("&", "§", $command);
								   $command = str_replace("{player}", $player->getName(), $command);
								   $command = str_replace("{sender}", $sender->getName(), $command);
								   $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								   $lastcolor = "§mc";
								   $randcolors = rand(0, 15);
								   $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
								   $args = str_replace($lastcolor, implode("", $color), $args);
								   
								   
								   $sender->getServer()->getIPBans()->addBan($player->getAddress(), implode(" ", $args), null, $sender->getName());
								   foreach($sender->getServer()->getOnlinePlayers() as $players){
									   if($players->getAddress() === $player->getAddress()){
										   $player->kick(implode("", $args), false);
										}
									}
									$sender->getServer()->getNetwork()->blockAddress($player->getAddress(), -1);
								   
								   
								   $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								   $this->getServer()->getLogger()->info("§6" . $sender->getName() . " kicked " . $player->getName() . ". Reason: " . implode(" ",$args));
											 $msg = $this->getConfig()->get("CbanIpMSG");
								             $msg = str_replace("&", "§", $msg);
							              	 $msg = str_replace("{reason}", implode(" ",$args), $msg);
							               	 $msg = str_replace("{player}", $player->getName(), $msg);
								             $msg = str_replace("{sender}", $sender->getName(), $msg);
		 	                                 $sender->sendMessage("§4§l[CbanIpRaw]§r§4 " . $msg);
								 }
							   }
							   return true;
							   break;
						   case "ckickworld":
                           // ckickworld command
                          if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /ckickworld <world> <reason...>");
                            return true;
                           } else {
                               if(!$this->getServer()->isLevelGenerated($args[0])) {
                                 $sender->sendMessage("§l§4[Error]§r§4 Level not found");
                               } else {
                               foreach($this->getServer()->getLevelByName($args[0])->getPlayers() as $worldplayers){
								   $level = $this->getServer()->getLevelByName($args[0]);
                                 $levelname = $args[0];
                                 unset($args[0]);
                                 $args = str_replace("{line}", "\n", $args);
                                 $args = str_replace("&", "§", $args);
                                 $args = str_replace("fuck", "****", $args);
                                 $args = str_replace("shit", "****", $args);
								 $id = 1;
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
								 $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								 $lastcolor = "§mc";
								 $randcolors = rand(0, 15);
								 $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
								 $args = str_replace($lastcolor, implode("", $color), $args);
                                 $worldplayers->kick(implode(" ",$args), false);
								 $command = $this->getConfig()->get("CkickWorldCmd");
								 $command = str_replace("&", "§", $command);
								 $command = str_replace("{world}", $levelname, $command);
								 $command = str_replace("{sender}", $sender->getName(), $command);
								 $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " kicked everyone on world :" . $levelname . ". Reason: (" . implode(" ",$args) . ")");
								 $msg = $this->getConfig()->get("CkickWorldMSG");
								 $msg = str_replace("&", "§", $msg);
								 $msg = str_replace("{reason}", implode(" ",$args), $msg);
								 $msg = str_replace("{world}", $levelname, $msg);
								 $msg = str_replace("{sender}", $sender->getName(), $msg);
                                 $sender->sendMessage("§3§l[CkickWorld]§r§3 " . $msg);
                               }
                               }
                             }
                             return true;
                             break;
						case "ckickall":
                           // ckickall command
                          if(count($args) < 1){
                            $sender->sendMessage("§4Usage: /ckickall <reason...>");
                            return true;
                           } else {
                               foreach($this->getServer()->getOnlinePlayers() as $players){
                                 $args = str_replace("{line}", "\n", $args);
                                 $args = str_replace("&", "§", $args);
                                 $args = str_replace("fuck", "****", $args);
                                 $args = str_replace("shit", "****", $args);
								 $id = 1;
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
								 $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								 $lastcolor = "§mc";
								 $randcolors = rand(0, 15);
								 $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
								 $args = str_replace($lastcolor, implode("", $color), $args);
                                 $players->kick(implode(" ",$args), false);
								 $command = $this->getConfig()->get("CkickAllCmd");
								 $command = str_replace("&", "§", $command);
								 $command = str_replace("{sender}", $sender->getName(), $command);
								 $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								 $this->getServer()->getLogger()->info("§6" . $sender->getName() . " kicked everyone in the server. Reason: (" . implode(" ",$args) . ")");
								 $msg = $this->getConfig()->get("CkickAllMSG");
								 $msg = str_replace("&", "§", $msg);
								 $msg = str_replace("{reason}", implode(" ",$args), $msg);
								 $msg = str_replace("{sender}", $sender->getName(), $msg);
                                 $sender->sendMessage("§0§l[CkickAll]§r§0 " . $msg);
                               }
                               }
                             return true;
                             break;
							   
						   case "tellradiusraw":
						       $radius = $args[0];
						       if(count($args) < 2) {
								   $sender->sendMessage("§4Usage: /tellradiusraw <radius> <message>");
							   } else {
                                 if(!is_numeric($radius)){
                                   $sender->sendMessage("§4§l[Error]§r§4 Radius must be numeric");
                                 } else {
									 unset($args[0]);
		 	                       $args = str_replace("{line}", "\n", $args);
		 	                       $args = str_replace("&", "§", $args);
		 	                       $args = str_replace("fuck", "****", $args);
		 	                       $args = str_replace("shit", "****", $args);
								   $id = 1;
								   while ($this->getConfig()->get("Replace" . $id) ==! null) {
									     $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									     $id++;
								   }
								   $command = $this->getConfig()->get("TellRadiusRawCmd");
								   $command = str_replace("&", "§", $command);
								   $command = str_replace("{radius}", $radius, $command);
								   $command = str_replace("{sender}", $sender->getName(), $command);
								   $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								   $lastcolor = "§mc";
								   $randcolors = rand(0, 15);
								   $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
								   $args = str_replace($lastcolor, implode("", $color), $args);
								   foreach($sender->getLevel()->getPlayers() as $players){
                                      if($sender->distance($players) <= $radius){
										  $players->sendMessage(implode(" ", $args));
                                      }
                                   }
								   $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								   $this->getServer()->getLogger()->info("§6" . $sender->getName() . " tellrawed all players in a radius of " . $radius . ". Message: " . implode(" ",$args));
								   $msg = $this->getConfig()->get("TellRadiusRawMSG");
								   $msg = str_replace("&", "§", $msg);
							       $msg = str_replace("{message}", implode(" ",$args), $msg);
							       $msg = str_replace("{radius}", $radius, $msg);
								   $msg = str_replace("{sender}", $sender->getName(), $msg);
		 	                       $sender->sendMessage("§8§l[TellRadiusRaw]§r§8 " . $msg);
								 }
							   }
							   return true;
							   break;
						    case "popupradius":
						       $radius = $args[0];
						       if(count($args) < 2) {
								   $sender->sendMessage("§4Usage: /popupradius <radius> <message>");
							   } else {
                                 if(!is_numeric($radius)){
                                   $sender->sendMessage("§4§l[Error]§r§4 Radius must be numeric");
                                 } else {
									 unset($args[0]);
		 	                       $args = str_replace("{line}", "\n", $args);
		 	                       $args = str_replace("&", "§", $args);
		 	                       $args = str_replace("fuck", "****", $args);
		 	                       $args = str_replace("shit", "****", $args);
								   $id = 1;
								   $ntip = 0;
								   $time = 0;
								   $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								   $lastcolor = "§mc";
								   while ($this->getConfig()->get("Replace" . $id) ==! null) {
									     $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									     $id++;
								   }
								   $command = $this->getConfig()->get("PopupRadiusCmd");
								   $command = str_replace("&", "§", $command);
								   $command = str_replace("{radius}", $radius, $command);
								   $command = str_replace("{sender}", $sender->getName(), $command);
								   foreach($sender->getLevel()->getPlayers() as $players){
                                      if($sender->distance($players) <= $radius){
										  while ($ntip < 40) {
									             while ($time < 3000) {
										               $time++;
													   $players->sendTip("§§" . $time);
									             }
									             if($time = 3000) {
										             $randcolors = rand(0, 15);
										             $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
										             $args = str_replace($lastcolor, implode("", $color), $args);
										             $players->sendPopup(implode(" ",$args));
										             $time = 0;
										             $lastcolor = implode("", $color);
										             $ntip++;
									             }
								             }
                                      }
                                   }
								   $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								   $this->getServer()->getLogger()->info("§6" . $sender->getName() . " tellrawed all players in a radius of " . $radius . ". Message: " . implode(" ",$args));
								   $msg = $this->getConfig()->get("PopupRadiusMSG");
								   $msg = str_replace("&", "§", $msg);
							       $msg = str_replace("{message}", implode(" ",$args), $msg);
							       $msg = str_replace("{radius}", $radius, $msg);
								   $msg = str_replace("{sender}", $sender->getName(), $msg);
		 	                       $sender->sendMessage("§5§l[PopupRadius]§r§5 " . $msg);
								 }
							   }
							   return true;
							   break;
							case "tipradius":
						       $radius = $args[0];
						       if(count($args) < 2) {
								   $sender->sendMessage("§4Usage: /tipradius <radius> <message>");
							   } else {
                                 if(!is_numeric($radius)){
                                   $sender->sendMessage("§4§l[Error]§r§4 Radius must be numeric");
                                 } else {
									 unset($args[0]);
		 	                       $args = str_replace("{line}", "\n", $args);
		 	                       $args = str_replace("&", "§", $args);
		 	                       $args = str_replace("fuck", "****", $args);
		 	                       $args = str_replace("shit", "****", $args);
								   $id = 1;
								   $ntip = 0;
								   $time = 0;
								   $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								   $lastcolor = "§mc";
								   while ($this->getConfig()->get("Replace" . $id) ==! null) {
									     $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									     $id++;
								   }
								   $command = $this->getConfig()->get("TipRadiusCmd");
								   $command = str_replace("&", "§", $command);
								   $command = str_replace("{radius}", $radius, $command);
								   $command = str_replace("{sender}", $sender->getName(), $command);
								   foreach($sender->getLevel()->getPlayers() as $players){
                                      if($sender->distance($players) <= $radius){
										  while ($ntip < 40) {
									             while ($time < 3000) {
										               $time++;
													   $players->sendPopup("§§" . $time);
									             }
									             if($time = 3000) {
										             $randcolors = rand(0, 15);
										             $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
										             $args = str_replace($lastcolor, implode("", $color), $args);
										             $players->sendTip(implode(" ",$args));
										             $time = 0;
										             $lastcolor = implode("", $color);
										             $ntip++;
									             }
								             }
                                      }
                                   }
								   $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								   $this->getServer()->getLogger()->info("§6" . $sender->getName() . " tellrawed all players in a radius of " . $radius . ". Message: " . implode(" ",$args));
								   $msg = $this->getConfig()->get("TipRadiusMSG");
								   $msg = str_replace("&", "§", $msg);
							       $msg = str_replace("{message}", implode(" ",$args), $msg);
							       $msg = str_replace("{radius}", $radius, $msg);
								   $msg = str_replace("{sender}", $sender->getName(), $msg);
		 	                       $sender->sendMessage("§d§l[TipRadius]§d§8 " . $msg);
								 }
							   }
							   return true;
							   break;
							case "ckickradius":
						       $radius = $args[0];
						       if(count($args) < 2) {
								   $sender->sendMessage("§4Usage: /ckickradius <radius> <message>");
							   } else {
                                 if(!is_numeric($radius)){
                                   $sender->sendMessage("§4§l[Error]§r§4 Radius must be numeric");
                                 } else {
									 unset($args[0]);
		 	                       $args = str_replace("{line}", "\n", $args);
		 	                       $args = str_replace("&", "§", $args);
		 	                       $args = str_replace("fuck", "****", $args);
		 	                       $args = str_replace("shit", "****", $args);
								   $id = 1;
								   while ($this->getConfig()->get("Replace" . $id) ==! null) {
									     $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									     $id++;
								   }
								   $command = $this->getConfig()->get("CkickRadiusCmd");
								   $command = str_replace("&", "§", $command);
								   $command = str_replace("{radius}", $radius, $command);
								   $command = str_replace("{sender}", $sender->getName(), $command);
								   $colors = [C::BLACK, C::DARK_BLUE, C::DARK_GREEN, C::DARK_AQUA, C::DARK_RED, C::DARK_PURPLE, C::GOLD, C::GRAY, C::DARK_GRAY, C::BLUE, C::GREEN, C::AQUA, C::RED, C::LIGHT_PURPLE, C::YELLOW, C::WHITE];
								   $lastcolor = "§mc";
								   $randcolors = rand(0, 15);
								   $color = [C::BLACK, C::BOLD, C::STRIKETHROUGH, C::BLUE, C::RESET, $colors[$randcolors]];
								   $args = str_replace($lastcolor, implode("", $color), $args);
								   foreach($sender->getLevel()->getPlayers() as $players){
                                      if($sender->distance($players) <= $radius){
										  $players->kick(implode(" ", $args), false);
                                      }
                                   }
								   $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								   $this->getServer()->getLogger()->info("§6" . $sender->getName() . " kicked all players in a radius of " . $radius . ". Message: " . implode(" ",$args));
								   $msg = $this->getConfig()->get("CkickRadiusMSG");
								   $msg = str_replace("&", "§", $msg);
							       $msg = str_replace("{reason}", implode(" ",$args), $msg);
							       $msg = str_replace("{radius}", $radius, $msg);
								   $msg = str_replace("{sender}", $sender->getName(), $msg);
		 	                       $sender->sendMessage("§8§l[TellRadiusRaw]§r§8 " . $msg);
								 }
							   }
							   return true;
							   break;
							   
			     }
          }
		            public function onPlayerJoin(PlayerJoinEvent $event) {
						$id = 1;
						$player = $event->getPlayer();
						$level = $player->getLevel();
						$cfg = new Config($this->getDataFolder() . "floating.yml", Config::YAML);
						$this->getServer()->broadcastMessage("Test");
						while($cfg->get("X" . $id) ===! null) {
						 $x = $cfg->get("X" . $id);
						 $y = $cfg->get("Y" . $id);
						 $z = $cfg->get("Z" . $id);
						 $text = $cfg->get("Text" . $id);
						 $level->addParticle(new \pocketmine\level\particle\FloatingTextParticle(new Vector3($x, $y, $z), $text));
						 $id++;
						}
					}
                    public function onEnable() {
						$this->saveDefaultConfig();
                        $this->reloadConfig();
						if($this->getConfig()->get("TellNews") === "onStart") {
	                      $news = file_get_contents("http://ad5001.cf/news.txt");
		                  $this->getLogger()->info("Last news: \n" . $news);
		                }
                        $this->getLogger()->info("BetterRaw has been enable!\nCommands:\n- /tellraw <player> <message...>\n- /tellworldraw <world> <message...>\n- /tip <player> <message...>\n- /tipworld <world> <message...>\n- /popup <player> <message...>\n- /popupworld <world> <message...>\n- /sayraw <message...>\n- /saypopup <message...>\n- /saytip <message...>\n- /ckickraw <player> <reason>\n- /ckickworld <world> <reason>\n- /ckickall <reason>\n- /tellradiusraw <radius> <message...>\n- /popupradius <radius> <message...>\n- /tipradius <radius> <message...>\n- /ckickradius <radius> <reason...>");	 
						switch($this->getConfig()->get("ResetLang")) {
							case "en":
							    file_put_contents($this->getDataFolder() . "config.yml", $this->getResource("en.yml"));
								$this->getLogger()->info("English has been succefuly set to your language!");
								return true;
								break;
							case "fr":
							    file_put_contents($this->getDataFolder() . "config.yml", $this->getResource("fr.yml"));
								$this->getLogger()->info("Le français a bien été selctionné comme votre langue");
								return true;
								break;
						    case "de":
							    file_put_contents($this->getDataFolder() . "config.yml", $this->getResource("de.yml"));
								$this->getLogger()->info("Deutch wurde als Sprache ausgewählt");
								return true;
								break;
						    case "es":
							    file_put_contents($this->getDataFolder() . "config.yml", $this->getResource("es.yml"));
								$sender->sendMessage("Lengua española ha sido seleccionada");
						    case "":
							    return true;
								break;
						    default:
							    $this->getLogger()->info("Language not recognized! Please select a valid language!");
								$this->getConfig()->set("ResetLang", "");
								return true;
								break;
						}
						$this->reloadConfig();
                    }
   }
