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
                           if($sender->hasPermission("btell.command.tellraw")){
                                 $sender->sendMessage("§a§l[Tellraw]§r§a Message has been displayed!");
                                 $this->getServer()->getPlayer($args[0])->sendMessage(implode(" ",$args));
                              }
                           }
                           return true;
                           break;
                         default:
                           break;
                           }
                          
                  }
          }
          public function onDisable() {
                 $this->getLogger()->info("\nBetterTell has been disable!\n");
          }
                    public function onEnable() {
                 $this->getLogger()->info("\nBetterTell has been enable!\n");
          }
   }
?>
