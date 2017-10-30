<?php
namespace SnowIO\FredhopperDataModel;

final class ProductDataSet implements \IteratorAggregate
{
    use SetTrait;

    public function with(ProductData $productData): self
    {
        $result = clone $this;
        $result->items[$productData->getId()] = $productData;
        return $result;
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
