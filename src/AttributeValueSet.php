<?php
namespace SnowIO\FredhopperDataModel;

use SnowIO\FredhopperDataModel\Internal\SetTrait;

class AttributeValueSet implements \IteratorAggregate
{
    use SetTrait;

    public function with(AttributeValue $attributeValue): self
    {
        $result = clone $this;
        $key = self::getKey($attributeValue);
        $result->items[$key] = $attributeValue;
        return $result;
    }

    private static function getKey(AttributeValue $attributeValue): string
    {
        return "{$attributeValue->getAttributeId()}-{$attributeValue->getLocale()}";
    }

    private static function itemsAreEqual(AttributeValue $item1, AttributeValue $item2): bool
    {
        return $item1->equals($item2);
    }
}
