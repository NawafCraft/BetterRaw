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
use pocketmine\event\Listener;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\IPlayer;
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
                                 $player->sendMessage(implode(" ",$args));
                                 $sender->sendMessage("§a§l[Tellraw]§r§a Message (" . implode(" ",$args) . ")§a has been send to " . $player->getName() . "!");
                              }
                            }
                           }
                           return true;
                           break;
                         case "tellworldraw":
                           // sayworldraw command
                          if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /tellworldraw <world> <message...>");
                            return true;
                           } else {
                             if($sender->hasPermission("braw.command.tellworldraw")){
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
                                 $worldplayers->sendMessage(implode(" ",$args));
                                 $sender->sendMessage("§b§l[TellWorldRaw]§r§b Message (" . implode(" ",$args) . ")§b has been send on world '" . $levelname . "' !");
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
                                 $player->sendTip(implode(" ",$args));
                                 $sender->sendMessage("§4§l[Tip]§r§4 Tip (" . implode(" ",$args) . ")§4 has been send to " . $player->getName() . "!");
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
                                 $player->sendPopup(implode(" ",$args));
                                 $sender->sendMessage("§e§l[Popup]§r§e Popup (" . implode(" ",$args) . ")§e has been send to " . $player->getName() . "!");
                              }
                            }
                           }
                           return true;
                           break;
                          case "popupworld":
                           // sayworldraw command
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
                                 $worldplayers->sendPopup(implode(" ",$args));
                                 $sender->sendMessage("§d§l[PopupWorld]§r§d Popup (" . implode(" ",$args) . ")§d has been send on world '" . $levelname . "' !");
                               }
                               }
                             }
                             return true;
                             break;
                           }
                          case "tipworld":
                           // sayworldraw command
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
                                 $worldplayers->sendTip(implode(" ",$args));
                                 $sender->sendMessage("§c§l[TipWorld]§r§c Tip (" . implode(" ",$args) . ")§c has been send on world '" . $levelname . "' !");
                               }
                               }
                             }
                             return true;
                             break;
                           }
                           case "tellgroupraw":
                            $purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
                             if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /tellgroupraw <group> <message...>");
                            return true;
                             } elseif($purePerms == null){
                               $sender->sendMessage("§l§4[Error]§r§4 PurePerms not found");
                             } else {
                             if($sender->hasPermission("braw.command.tellgroupraw")){
                               $player = $this->getServer()->getPlayer("Test");
                               $group = $args[0];
                               $pl = $this->purePerms->getPPGroup()->getUsers($group);
                               if($pl == null) {
                                 $sender->sendMessage("§l§4[Error]§r§4 Group not found.");
                               } else {
                                 unset($args[0]);
                                 $args = str_replace("{line}", "\n", $args);
                                 $args = str_replace("&", "§", $args);
                                 $args = str_replace("fuck", "****", $args);
                                 $args = str_replace("shit", "****", $args);
                                 $pl->sendMessage(implode(" ",$args));
                                 $sender->sendMessage("§9§l[TellGroupRaw]§r§9 Tip (" . implode(" ",$args) . ")§9 has been send to group '" . $group . "'");
                               }
                             }
                             }
	                case "sayraw":
	                           // sayraw command
	                          if(count($args) < 1){
	                            $sender->sendMessage("§4Usage: /sayraw <message...>");
	                            return true;
	                           } else {
	                            if($sender->hasPermission("braw.command.sayraw")){
	                                 $online = $this->getServer()->getOnlinePlayers();
	                                 $args = str_replace("{line}", "\n", $args);
	                                 $args = str_replace("&", "§", $args);
	                                 $args = str_replace("fuck", "****", $args);
	                                 $args = str_replace("shit", "****", $args);
	                                 $online->sendMessage(implode(" ",$args));
	                                 $sender->sendMessage("§6§l[Sayraw]§r§6 Message (" . implode(" ",$args) . ")§a has been sayed!");
	                              }
	                            }	                
                                case "saytip":
	                           // saytip command
	                          if(count($args) < 1){
	                            $sender->sendMessage("§4Usage: /saytip <message...>");
	                            return true;
	                           } else {
	                            if($sender->hasPermission("braw.command.saytip")){
	                                 $online = $this->getServer()->getOnlinePlayers();
	                                 $args = str_replace("{line}", "\n", $args);
	                                 $args = str_replace("&", "§", $args);
	                                 $args = str_replace("fuck", "****", $args);
	                                 $args = str_replace("shit", "****", $args);
	                                 $online->sendTip(implode(" ",$args));
	                                 $sender->sendMessage("§9§l[SayTip]§r§9 Tip (" . implode(" ",$args) . ")§a has been sayed!");
	                              }
	                            }
			case "saypopup":
	                           // sayraw command
	                          if(count($args) < 1){
	                            $sender->sendMessage("§4Usage: /saypopup <message...>");
	                            return true;
	                           } else {
	                            if($sender->hasPermission("braw.command.saypopup")){
	                                 $online = $this->getServer()->getOnlinePlayers();
	                                 $args = str_replace("{line}", "\n", $args);
	                                 $args = str_replace("&", "§", $args);
	                                 $args = str_replace("fuck", "****", $args);
	                                 $args = str_replace("shit", "****", $args);
	                                 $online->sendPopup(implode(" ",$args));
	                                 $sender->sendMessage("§7§l[SayPopup]§r§7 Popup (" . implode(" ",$args) . ")§a has been sayed!");
	                              }
	                            }
		}
          }
                    public function onEnable() {
                 $this->getLogger()->info("BetterRaw has been enable!\nCommands:\n- /tellraw <player> <message...>\n- /tellworldraw <world> <message...>\n- /tip <player> <message...>\n- /tipworld <world> <message...>\n- /popup <player> <message...>\n- /popupworld <world> <message...>");
                 $this->purePerms = $this->getServer()->getPluginManager()->getPlugin("PurePerms");
          }
   }
?>
