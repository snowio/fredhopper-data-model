<?php
namespace SnowIO\FredhopperDataModel;

use SnowIO\FredhopperDataModel\Command\SaveProductCommand;

final class ProductDataSet implements \IteratorAggregate
{
    use SetTrait;

    public function with(ProductData $productData): self
    {
        $result = clone $this;
        $result->items[$productData->getId()] = $productData;
        return $result;
    }

    public function mapToSaveCommands(int $timestamp): array
    {
        return \array_map(function (ProductData $productData) use ($timestamp) {
            return SaveProductCommand::of($productData)->withTimestamp($timestamp);
        }, $this->items);
    }

    private static function getKey(ProductData $productData): string
    {
        return $productData->getId();
    }

    private static function itemsAreEqual(ProductData $item1, ProductData $item2): bool
    {
        return $item1->equals($item2);
    }
}
