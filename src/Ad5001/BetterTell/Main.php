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
                           if($sender->hasPermission("btell.command.tellraw")){
                                 $sender->sendMessage("§a§l[Tellraw]§r§a Message has been display if you had tipe EXACTLY the player name!");
                                 $this->getServer()->getPlayer("$args[0]")->sendMessage("$args[1]");
                                 $this->getServer()->getPlayer("$sender")->sendMessage("§a§l[Tellraw]§r§a Message has been display if you had tipe EXACTLY the player name!");
                                 $telled->getPlayerExact->sendMessage("$message");
                           }
                           return true;
                           break;
                         default:
                           if($sender->hasPermission("btell.command.tellraw")){
                                 $sender->sendMessage("§4Usage: /tellraw <player> <message>");
                                 $this->getServer()->getPlayer("$sender")->sendMessage("§4Usage: /tellraw <player> <message>");
                           } else {
                                 $this->getServer()->getPlayer("$sender")->sendMessage("§4You don't have the permission to access TellRaw");
                           }
                          
                  }
          }
          public function onDisable() {
                 $this->getLogger()->info("\nTellRaw plugin has been disable!\n");
          }
   }
?>
