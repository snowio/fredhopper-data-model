<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Command;

use SnowIO\FredhopperDataModel\ProductData;

final class SaveProductCommand extends Command
{
    public static function of(ProductData $productData): self
    {
        $command = new self;
        $command->productData = $productData;
        return $command;
    }

    public function getProductData(): ProductData
    {
        return $this->productData;
    }

    public function toJson(): array
    {
        return parent::toJson() + $this->productData->toJson();
    }

    /** @var ProductData */
    private $productData;

    private function __construct()
    {

    }
}
