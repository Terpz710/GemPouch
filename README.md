# Description
GemPouch is a bank-note like plugin which holds your [Gems](https://github.com/Terpz710/Gems) currency within a nether star item.

Players can interact with the star to claim the virtual gems.

# Requires
This plugin requires [Gems](https://github.com/Terpz710/Gems) currency plugin for it to work!

# API
**How to obtain a pouch**
```
use terpz710\gempouch\GemPouch;

$api = GemPouch::getInstance();

$player is an instance of Player::class

$amount = 100;

$pouch = $api->givePouch($player, $amount);

$player->getInventory()->addItem($pouch);

or

$pouch = $api->givePouch($player, 100);

$player->getInventory()->addItem($pouch);
```
