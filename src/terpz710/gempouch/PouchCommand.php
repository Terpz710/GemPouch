<?php

declare(strict_types=1);

namespace terpz710\gempouch;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;

use pocketmine\player\Player;

use pocketmine\utils\TextFormat as TextColor;

use function count;
use function intval;
use function number_format;
use function str_replace;

use terpz710\gems\manager\GemManager;

class PouchCommand extends Command implements PluginOwned {

    private $plugin;

    public function __construct() {
        parent::__construct("gempouch");
        $this->setDescription("Give yourself a gempouch");
        $this->setUsage("Usage: /gempouch <amount>");
        $this->setPermission("gempouch.cmd");

        $this->plugin = GemPouch::getInstance();
    }

    public function execute(CommandSender $sender, string $label, array $args) : bool{
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game...");
            return false;
        }

        if (count($args) !== 1) {
            $sender->sendMessage(TextColor::RED . $this->getUsage());
            return false;
        }

        $amount = intval($args[0]);

        if ($amount <= 0) {
            $sender->sendMessage(TextColor::colorize($this->plugin->getConfig()->get("pouch-invalid-number")));
            return false;
        }

        $gemManager = GemManager::getInstance();
        $currentBalance = $gemManager->seeGemBalance($sender);

        if ($currentBalance < $amount) {
            $msg = TextColor::colorize($this->plugin->getConfig()->get("pouch-insufficient-gems"));
            $msg = str_replace("{balance}", (string) number_format($currentBalance), $msg);
            $msg = str_replace("{amount}", (string) number_format($amount), $msg);
            $sender->sendMessage($msg);
            return false;
        }

        $gemManager->removeGem($sender, $amount);
        $pouch = $this->plugin->givePouch($sender, $amount);
        $sender->getInventory()->addItem($pouch);

        $msg = TextColor::colorize($this->plugin->getConfig()->get("pouch-recieve-message"));
        $msg = str_replace("{amount}", (string) number_format($amount), $msg);
        $sender->sendMessage($msg);
        return true;
    }

    public function getOwningPlugin() : Plugin{
        return $this->plugin;
    }
}
