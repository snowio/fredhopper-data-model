<?php
namespace SnowIO\FredhopperDataModel;

final class AttributeDataSet
{
    use SetTrait;

    public function with(AttributeData $attributeData): self
    {
        $result = clone $this;
        $result->items[$attributeData->getId()] = $attributeData;
        return $result;
    }

    private static function getKey(AttributeData $attributeData): string
    {
        return $attributeData->getId();
    }

    private static function itemsAreEqual(AttributeData $item1, AttributeData $item2): bool
    {
        return $item1->equals($item2);
    }
}
