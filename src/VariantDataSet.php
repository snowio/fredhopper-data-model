<?php
namespace SnowIO\FredhopperDataModel;

final class VariantDataSet
{
    use SetTrait;

    public function with(VariantData $variantData): self
    {
        $result = clone $this;
        $result->items[$variantData->getId()] = $variantData;
        return $result;
    }

    private static function getKey(VariantData $variantData): string
    {
        return $variantData->getId();
    }

    private static function itemsAreEqual(VariantData $item1, VariantData $item2): bool
    {
        return $item1->equals($item2);
    }
}
