<?php
namespace Ad5001\BetterTell;

/*
*
*
*
*
*/

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
class Main extends PluginBase {
  public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
    switch($cmd->getName()){ // Nom de la commande
      case "tellraw":
	      $sender->sendMessage["§a§l[Tellraw]§r§a Message has been display if you had tipe EXACTLY the player name!"];
		  $telled = $args[0];
		  $message = $args[1]->getMessage();
		  $telled->getPlayerExact->sendMessage("$message");
        return true; // return true always unless you want the usage message be shown: return false
		break;
	  default:
	      $sender->sendMessage("§4Unknown command " . $cmd . ". Try /help for the list of commands");
      }
  public function onDisable() {
    $this->getLogger()->info("Test plugin has been disable!");
   }
  }
}
?>
