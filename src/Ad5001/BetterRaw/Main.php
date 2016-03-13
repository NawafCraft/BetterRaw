<?php
namespace Ad5001\BetterRaw;

/*
                         _______________________________________________________________
                        /                 BetterRaw Plugin by Ad5001 !                  \
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
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\ServerScheduler;
use pocketmine\level\sound\AnvilBreakSound;
use pocketmine\level\sound\AnvilFallSound;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\level\sound\BatSound;
use pocketmine\level\sound\BlazeShootSound;
use pocketmine\level\sound\ButtonClickSound;
use pocketmine\level\sound\ButtonReturnSound;
use pocketmine\level\sound\ClickSound;
use pocketmine\level\sound\DoorBumpSound;
use pocketmine\level\sound\DoorCrashSound;
use pocketmine\level\sound\DoorSound;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\level\sound\FizzSound;
use pocketmine\level\sound\GhastShootSound;
use pocketmine\level\sound\GhastSound;
use pocketmine\level\sound\LaunchSound;
use pocketmine\level\sound\NoteblockSound;
use pocketmine\level\sound\PopSound;
use pocketmine\level\sound\ZombieHealSound;
use pocketmine\level\sound\ZombieInfectSound;
use pocketmine\level\sound\Sound;
use pocketmine\server;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\plugin\PluginBase;
   class Main extends PluginBase {
          public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
                 switch($cmd->getName()) {
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
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
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
                             if($sender->hasPermission("braw.command.tellworldraw")){
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
								 $level->addSound(new AnvilBreakSound($sender));
								 $level->addSound(new AnvilBreakSound($sender));
								 $level->addSound(new AnvilBreakSound($sender));
                                 $sender->sendMessage("§b§l[TellWorldRaw]§r§b " . $msg);
                               }
                               }
                             }
                             return true;
                             break;
                           }
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
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
                                 $player->sendTip(implode(" ",$args));
								 $this->getServer()->getScheduler()->scheduleDelayedTask(new tip($this, $player, $args), 20);
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
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
                                 $player->sendPopup(implode(" ",$args));
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
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
                                 $worldplayers->sendPopup(implode(" ",$args));
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
								 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									 $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									 $id++;
								 }
                                 $worldplayers->sendTip(implode(" ",$args));
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
											 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									             $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									             $id++;
								             }
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
							               	 $msg = str_replace("{world}", $levelname, $msg);
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
											 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									             $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									             $id++;
								             }
		 	                                 $this->getServer()->broadcastTip(implode(" ",$args));
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
							               	 $msg = str_replace("{world}", $levelname, $msg);
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
											 while ($this->getConfig()->get("Replace" . $id) ==! null) {
									             $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									             $id++;
								             }
		 	                                 $this->getServer()->broadcastPopup(implode(" ",$args));
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
							               	 $msg = str_replace("{world}", $levelname, $msg);
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
								   while ($this->getConfig()->get("Replace" . $id) ==! null) {
									     $args = str_replace($this->getConfig()->get("Replace" . $id), $this->getConfig()->get("ReplaceWith" . $id), $args);
									     $id++;
								   }
								   $player->kick(implode(" ", $args), false);
								   $command = $this->getConfig()->get("CkickCmd");
								   $command = str_replace("&", "§", $command);
								   $command = str_replace("{player}", $player->getName(), $command);
								   $command = str_replace("{sender}", $sender->getName(), $command);
								   $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
								   $this->getServer()->getLogger()->info("§6" . $sender->getName() . " kicked " . $player->getName() . ". Reason: " . implode(" ",$args));
											 $msg = $this->getConfig()->get("CkickMSG");
								             $msg = str_replace("&", "§", $msg);
							              	 $msg = str_replace("{reason}", implode(" ",$args), $msg);
							               	 $msg = str_replace("{player}", $player->getName(), $msg);
								             $msg = str_replace("{sender}", $sender->getName(), $msg);
		 	                                 $sender->sendMessage("§1§l[Ckick]§r§1 " . $msg);
								 }
							   }
							   return true;
							   break;
			     }
          }
                    public function onEnable() {
						$this->saveDefaultConfig();
                        $this->reloadConfig();
                 $this->getLogger()->info("BetterRaw has been enable!\nCommands:\n- /tellraw <player> <message...>\n- /tellworldraw <world> <message...>\n- /tip <player> <message...>\n- /tipworld <world> <message...>\n- /popup <player> <message...>\n- /popupworld <world> <message...>\n- /sayraw <message...>\n- /saypopup <message...>\n- /saytip <message...>\n- /ckick <player> <reason>");
                 $this->purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
          }
   }
