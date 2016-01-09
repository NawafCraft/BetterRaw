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
                 switch($cmd->getName()) { // Command name
                         case "tellraw":
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
                                 $sender->sendMessage("§a§l[Tellraw]§r§a Message (" . implode(" ",$args) . ") has been send to " . $player . "!");
                              }
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
                               foreach($this->getServer()->getLevelByName($args[0])->getPlayers() as $worldplayers){
                                 if(!$this->owner->getServer()->isLevelGenerated($worldplayers)) {
                                   $sender->sendMessage("§l§4[Error]§r§4 Level not found");
                                 } else {
                                 unset($args[0]);
                                 $worldplayers->sendMessage(implode(" ",$args));
                                 $sender->sendMessage("§b§l[SayWorldRaw]§r§b Message (" . implode(" ",$args) . ") has been send on world '" . $worldplayers . "' !");
                               }
                             }
                           }
                         default:
                           break;
                  }
          }
          public function onDisable() {
                 $this->getLogger()->info("\nBetterRaw has been disable!");
          }
                    public function onEnable() {
                 $this->getLogger()->info("\nBetterRaw has been enable!\nCommands:\n- /tellraw <player> <message...>\n- /sayworldraw <world> <message...>");
          }
   }
?>
