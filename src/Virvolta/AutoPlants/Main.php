<?php

namespace Virvolta\AutoPlants;

use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Virvolta\AutoPlants\listener\BlockBreakListener;

class Main extends PluginBase
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @var Config
     */
    private static $data;

    /**
     * @return static
     */
    public static function getInstance() : self
    {
        return self::$instance;
    }

    /**
     * @return Config
     */
    public static function getData() : Config
    {
        return self::$data;
    }

    public function onLoad()
    {
        self::$instance = $this;
        @mkdir($this->getDataFolder());

        if(!file_exists($this->getDataFolder()."config.yml")){

            $this->saveResource('config.yml');

        }

        self::$data = new Config($this->getDataFolder().'config.yml', Config::YAML, ["id" => "" . Item::GOLD_HOE . ""]);
    }

    public function onEnable()
    {
        $this->getLogger()->info("§a----------=----------");
        $this->getLogger()->info("§ais loaded");
        $this->getLogger()->info("§aby VirVolta");
        $this->getLogger()->info("§a----------=----------");

        new BlockBreakListener();
    }

}