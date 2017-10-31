<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel;

use SnowIO\FredhopperDataModel\Command\SaveAttributeOptionCommand;

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

    public function mapToSaveCommands(float $timestamp): array
    {
        return \array_map(function (AttributeOption $attributeOption) use ($timestamp) {
            return SaveAttributeOptionCommand::of($attributeOption)->withTimestamp($timestamp);
        }, $this->items);
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
