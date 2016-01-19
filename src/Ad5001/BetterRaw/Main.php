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
                         case "saygmraw":
                           if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /saygmraw <gamemode> <message...>");
                            return true;
                           } else {
                             if($sender->hasPermission("braw.command.saygmraw")){
                               switch($args[0]) {
                                 case "0":
                                   {
                                   unset($args[0]);
                                   $p = $this->getServer()->getOnlinePlayers();
                                   if($p->getGamemode() === 0) {
                                     $gm = $p->getName();
                                     $gm->sendMessage(implode(" ",$args));
                                     $sender->sendMessage("§e§l[SayGMRaw]§r§e Message (" . implode(" ",$args) . ")§e has been send to everyone in gamemode survival !");
                                   }
                                   return true;
                                   break;
                                 }
                                 case "1":
                                   {
                                   unset($args[0]);
                                   $p = $this->getServer()->getOnlinePlayers();
                                   if($p->getGamemode() === 1) {
                                     $gm = $p->getName();
                                     $gm->sendMessage(implode(" ",$args));
                                     $sender->sendMessage("§e§l[SayGMRaw]§r§e Message (" . implode(" ",$args) . ")§e has been send to everyone in gamemode creative !");
                                   }
                                   return true;
                                   break;
                                 }
                                 case "2":
                                   {
                                   unset($args[0]);
                                   $p = $this->getServer()->getOnlinePlayers();
                                   if($p->getGamemode() === 2) {
                                     $gm = $p->getName();
                                     $gm->sendMessage(implode(" ",$args));
                                     $sender->sendMessage("§e§l[SayGMRaw]§r§e Message (" . implode(" ",$args) . ")§e has been send to everyone in gamemode adventure !");
                                   }
                                   return true;
                                   break;
                                 }
                                 case "3":
                                   {
                                   unset($args[0]);
                                   $p = $this->getServer()->getOnlinePlayers();
                                   if($p->getGamemode() === 3) {
                                     $gm = $p->getName();
                                     $gm->sendMessage(implode(" ",$args));
                                     $sender->sendMessage("§e§l[SayGMRaw]§r§e Message (" . implode(" ",$args) . ")§e has been send to everyone in gamemode spectator !");
                                   }
                                   return true;
                                   break;
                                 }
                                 case "survival":
                                   {
                                   unset($args[0]);
                                   $p = $this->getServer()->getOnlinePlayers();
                                   if($p->getGamemode() === 0) {
                                     $gm = $p->getName();
                                     $gm->sendMessage(implode(" ",$args));
                                     $sender->sendMessage("§e§l[SayGMRaw]§r§e Message (" . implode(" ",$args) . ")§e has been send to everyone in gamemode survival !");
                                   }
                                   return true;
                                   break;
                                 }
                                 case "creative":
                                   {
                                   unset($args[0]);
                                   $p = $this->getServer()->getOnlinePlayers();
                                   if($p->getGamemode() === 1) {
                                     $gm = $p->getName();
                                     $gm->sendMessage(implode(" ",$args));
                                     $sender->sendMessage("§e§l[SayGMRaw]§r§e Message (" . implode(" ",$args) . ")§e has been send to everyone in gamemode creative !");
                                   }
                                   return true;
                                   break;
                                   }
                                 case "adventure":
                                   {
                                   unset($args[0]);
                                   $p = $this->getServer()->getOnlinePlayers();
                                   if($p->getGamemode() === 2) {
                                     $gm = $p->getName();
                                     $gm->sendMessage(implode(" ",$args));
                                     $sender->sendMessage("§e§l[SayGMRaw]§r§e Message (" . implode(" ",$args) . ")§e has been send to everyone in gamemode adventure !");
                                   }
                                   return true;
                                   break;
                                 }
                                 case "spectator":
                                   {
                                   unset($args[0]);
                                   $p = $this->getServer()->getOnlinePlayers();
                                   if($p->getGamemode() === 3) {
                                     $gm = $p->getName();
                                     $gm->sendMessage(implode(" ",$args));
                                     $sender->sendMessage("§e§l[SayGMRaw]§r§e Message (" . implode(" ",$args) . ")§e has been send to everyone in gamemode spectator !");
                                   }
                                   return true;
                                   break;
                                 }
                                 default:
                                   $sender->sendMessage("§l§4[Error]§r§4 Gamemode not found");
                                   return true;
                                   break;
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
                                 $sender->sendMessage("§c§l[Popup]§r§c Popup (" . implode(" ",$args) . ")§c has been send to " . $player->getName() . "!");
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
                                 $sender->sendMessage("§e§l[PopupWorld]§r§e Popup (" . implode(" ",$args) . ")§e has been send on world '" . $levelname . "' !");
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
                                 $sender->sendMessage("§l§4[Error]§r§4 Level not found");
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
                  }
          }
          public function onDisable() {
                 $this->getLogger()->info("\nBetterRaw has been disable!");
          }
                    public function onEnable() {
                 $this->getLogger()->info("BetterRaw has been enable!\nCommands:\n- /tellraw <player> <message...>\n- /sayworldraw <world> <message...>");
          }
   }
?>
