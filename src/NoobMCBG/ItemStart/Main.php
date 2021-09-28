<?php

declare(strict_types=1);

namespace NoobMCBG\ItemStart;

use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\item\Item;
use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
use pocketmine\event\player\PlayerJoinEvent;

class Main extends PluginBase implements Listener {

   public cfg;
    
   public function onEnable() {
      @mkdir($this->getDataFolder());
      $this->getServer()->getPluginManager()->registerEvents($this,$this);
      $this->saveResource("config.yml");
      $cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
      $cfg->save();
      $this->check = new Config($this->getDataFolder()."check.yml",Config::YAML);
      $this->getLogger()->info("Enable Plugin");
      $this->getServer()->getPluginManager()->registerEvents($this ,$this);
   }

   public function onJoin(PlayerJoinEvent $ev) {
        $name = $ev->getPlayer()->getName();
    if(!$this->check->exists($name)) {
        $this->check->set($name, true);
        $this->check->save();
	$player = $ev->getPlayer();
	$inv = $player->getInventory();  
	$item = Item::get($cfg->get("item1"));
        $item2 = Item::get($cfg->get("item2"));
	$item->setCustomName($cfg->get("item1-name"));
        $item2->setCustomName($cfg->get("item2-name"));
	$inv->addItem($item);
        $inv->addItem($item2);
	$player->sendMessage($cfg->get("itemstart-messenges"));
    }
   }
}
