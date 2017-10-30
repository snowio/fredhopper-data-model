<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel;

final class AttributeOptionSet implements \IteratorAggregate
{
    use SetTrait;

    public function with(AttributeOption $attributeOption): self
    {
        $result = clone $this;
        $key = self::getKey($attributeOption);
        $result->items[$key] = $attributeOption;
        return $result;
    }

    private static function getKey(AttributeOption $attributeOption): string
    {
        return "{$attributeOption->getAttributeId()}-{$attributeOption->getValueId()}";
    }

    private static function itemsAreEqual(AttributeOption $item1, AttributeOption $item2): bool
    {
        return $item1->equals($item2);
    }
}
