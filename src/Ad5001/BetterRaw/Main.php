<?php
namespace Ad5001\BetterTell;

/*
                         _______________________________________________________________
                        /                 BetterTell Plugin by Ad5001 !                 \
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
                 switch($cmd->getName()) { // Command name
                         case "tellraw":
                          if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /tellraw <player> <message...>");
                            return true;
                           } else {
                           if($sender->hasPermission("braw.command.tellraw")){
                                 $sender->sendMessage("§a§l[Tellraw]§r§a Message has been send to " . $args[0] . "!");
                                 $player = $this->getServer()->getPlayer($args[0]);
                                 unset($args[0]);
                                 $player->sendMessage(implode(" ",$args));
                              }
                           }
                           return true;
                           break;
                         case "sayworldraw":
                          if(count($args) < 2){
                            $sender->sendMessage("§4Usage: /sayworldraw <world> <message...>");
                            return true;
                           } else {
                             if($sender->hasPermission("braw.command.sayworldraw")){
                               $sender->sendMessage("§b§l[WorldSayRaw]§r§b Message has been send on world " . $args[0] . " !");
                               foreach($this->getServer()->getLevelByName($args[0])->getPlayers() as $worldplayers){
                                 unset($args[0]);
                                 $worldplayers->sendMessage(implode(" ",$args));
                               }
                             }
                           }
                         default:
                           break;
                  }
          }
          public function onDisable() {
                 $this->getLogger()->info("\nBetterRaw has been disable!\nCommands:\n- /tellraw <player> <message...>\n- /sayworldraw <world> <message...>");
          }
                    public function onEnable() {
                 $this->getLogger()->info("\nBetterRaw has been enable!\n");
          }
   }
?>
