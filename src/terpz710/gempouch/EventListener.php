<?php

declare(strict_types=1);

namespace terpz710\gempouch;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;

use pocketmine\utils\TextFormat as TextColor;

use function number_format;
use function str_replace;

use terpz710\gems\manager\GemManager;

class EventListener implements Listener {

    private $plugin;

    public function __construct() {
        $this->plugin = GemPouch::getInstance();
    }

    public function claimPouch(PlayerItemUseEvent $event) : void{
        $player = $event->getPlayer();
        $item = $event->getItem();
        $nbt = $item->getNamedTag();

        if ($nbt->getTag("GemPouch")) {
            $amount = $nbt->getInt("GemPouch");
            $item->setCount($item->getCount() - 1);
            $player->getInventory()->setItemInHand($item);
            GemManager::getInstance()->giveGem($player, $amount);
            $msg = TextColor::colorize($this->plugin->getConfig()->get("pouch-claim-message"));
            $msg = str_replace("{amount}", (string)number_format($amount), $msg);
            $player->sendMessage($msg);
            return;
        }
    }
}