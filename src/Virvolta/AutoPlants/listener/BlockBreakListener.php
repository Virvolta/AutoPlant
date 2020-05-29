<?php


namespace Virvolta\AutoPlants\listener;


use pocketmine\block\Block;
use pocketmine\block\Crops;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\item\Carrot;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;
use Virvolta\AutoPlants\Main;

class BlockBreakListener implements Listener
{
    public function __construct()
    {
        Server::getInstance()->getPluginManager()->registerEvents($this, Main::getInstance());
    }

    public function onBreak(BlockBreakEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();

        if ($player instanceof Player) {

            if (Main::getData()->exists("id")) {

                if ($data = Main::getData()->get("id")) {


                    if (is_string($data)) {

                        $id = Item::fromString($data);

                        if ($item->getId() === $id->getId() and ($id->getDamage() == 0 or $item->getDamage() == $id->getDamage())) {

                            $block = $event->getBlock();

                            if ($block instanceof Crops) {

                                if ($block->getDamage() >= 7) {

                                    if($block->getSide(Vector3::SIDE_DOWN)->getId() === Block::FARMLAND) {

                                        $event->setCancelled();
                                        $block->getLevel()->setBlock($block->asVector3(), Block::get($block->getId(), 0), true, true);

                                        $n = true;
                                        foreach ($event->getDrops() as $item) {

                                            if (in_array($item->getId(), [Item::SEEDS,Item::BEETROOT_SEEDS,Item::MELON_SEEDS,Item::PUMPKIN_SEEDS,Item::CARROT,Item::POTATOES]) and $n) {

                                                $n = false;

                                            } else {

                                                $block->getLevel()->dropItem($block,$item);

                                            }

                                        }

                                    }

                                }

                            }

                        }

                    }

                }

            }

        }

    }

}