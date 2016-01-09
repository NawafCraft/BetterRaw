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
use pocketmine\Player;
use pocketmine\Server;
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
                                 $player->sendMessage(implode(" ",$args));
                                 $sender->sendMessage("§a§l[Tellraw]§r§a Message (" . implode(" ",$args) . ")§a has been send to " . $player->getName() . "!");
                              }
                            }
                           }
                           return true;
                           break;
                         case "sayworldraw":
                           // sayworldraw command
                          if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /sayworldraw <world> <message...>");
                            return true;
                           } else {
                             if($sender->hasPermission("braw.command.sayworldraw")){
                               if(!$this->getServer()->isLevelGenerated($args[0])) {
                                 $sender->sendMessage("§l§4[Error]§r§4 Level not found");
                               } else {
                               foreach($this->getServer()->getLevelByName($args[0])->getPlayers() as $worldplayers){
                                 $levelname = $args[0];
                                 unset($args[0]);
                                 $worldplayers->sendMessage(implode(" ",$args));
                                 $sender->sendMessage("§b§l[SayWorldRaw]§r§b Message (" . implode(" ",$args) . ")§e has been send on world '" . $levelname . "' !");
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
                               if($args[0] > 3) {
                                 $sender->sendMessage("§l§4[Error]§r§4 gamemode not found");
                               } else {
                                 foreach($this->getServer()->getOnlinePlayers() as $online){
                                   $goodgm = $online->getGamemode("$args[0]");
                                   $gm = $args[0];
                                   unset($args[0]);
                                   $goodgm->sendMessage(implode(" ",$args));
                                   $sender->sendMessage("§e§l[SayGMRaw]§r§e Message (" . implode(" ",$args) . ")§e has been send for everyone in gamemode '" . $gm . "' !");
                                 }
                               }
                             }
                             return true;
                             break;
                           }
                         default:
                           break;
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
