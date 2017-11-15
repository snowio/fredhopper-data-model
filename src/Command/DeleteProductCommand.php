<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Command;

use SnowIO\FredhopperDataModel\ProductData;

final class DeleteProductCommand extends Command
{
    public static function of(string $productId)
    {
        ProductData::validateId($productId);
        $command = new self;
        $command->productId = $productId;
        return $command;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function toJson(): array
    {
        return parent::toJson() + ['product_id' => $this->productId];
    }

    private $productId;

    private function __construct()
    {

    }
}
