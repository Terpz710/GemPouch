<?php

declare(strict_types=1);

namespace terpz710\gempouch;

use pocketmine\plugin\PluginBase;

use pocketmine\player\Player;

use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\StringToEnchantmentParser;

use pocketmine\nbt\tag\IntTag;

use pocketmine\utils\TextFormat as TextColor;

use function array_map;
use function number_format;

final class GemPouch extends PluginBase {

    protected static $instance;

    protected function onLoad() : void{
        self::$instance = $this;
    }

    protected function onEnable() : void{
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getCommandMap()->register("GemPouch", new PouchCommand());
    }

    public static function getInstance() : self{
        return self::$instance;
    }

    public function givePouch(Player $player, int $amount) : ?Item{
        $star = VanillaItems::NETHER_STAR();

        $star->setCustomName(TextColor::colorize($this->getConfig()->get("pouch-name")));

        $starLore = $this->getConfig()->get("pouch-lore");
        $lore = array_map(static function ($line) use ($amount, $player) {
            return TextColor::colorize(
                str_replace(
                    ["{amount}", "{name}"],
                    [(string) number_format($amount), $player->getName()],
                    $line
                )
            );
        }, (array) $starLore);
        
        $star->setLore($lore);

        $ench = $this->getConfig()->get("pouch-enchantment");
        $ench_level = $this->getConfig()->get("pouch-enchantment-level");

        $enchantment = StringToEnchantmentParser::getInstance()->parse($ench);
        
        if ($enchantment !== null) {
            $star->addEnchantment(new EnchantmentInstance($enchantment, $ench_level));
        }

        $nbt = $star->getNamedTag();
        $nbt->setTag("GemPouch", new IntTag($amount));
        $star->setNamedTag($nbt);
        return $star;
    }
}