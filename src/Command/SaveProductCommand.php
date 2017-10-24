<?php
namespace SnowIO\FredhopperDataModel\Command;

use SnowIO\FredhopperDataModel\Product;

final class SaveProductCommand extends Command
{
    public static function of(Product $product): self
    {
        $command = new self;
        $command->product = $product;
        return $command;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function toJson(): array
    {
        return parent::toJson() + $this->product->toJson();
    }

    /** @var Product */
    private $product;

    private function __construct()
    {

    }
}
