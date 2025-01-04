# Description
GemPouch is a bank-note like plugin which holds your [Gem](https://github.com/Terpz710/Gems) currency within a nether star item.

Players can interact with the star to claim the virtual gems.

# Requires
This plugin requires [Gem](https://github.com/Terpz710/Gems) currency plugin for it to work!

# API
**How to obtain a pouch**
```
use terpz710\gempouch\GemPouch;

$api = GemPouch::getInstance();

$player is an instance of Player::class

$amount = 100;

$api->givePouch($player, $amount);

or

$api->givePouch($player, 100);
```
