<?php
namespace SnowIO\FredhopperDataModel;

use SnowIO\FredhopperDataModel\Command\DeleteAttributeCommand;
use SnowIO\FredhopperDataModel\Command\SaveAttributeCommand;

final class AttributeDataSet implements \IteratorAggregate
{
    use SetTrait;

    public function with(AttributeData $attributeData): self
    {
        $result = clone $this;
        $result->items[$attributeData->getId()] = $attributeData;
        return $result;
    }

    public function mapToSaveCommands(float $timestamp): array
    {
        return \array_map(function (AttributeData $attributeData) use ($timestamp) {
            return SaveAttributeCommand::of($attributeData)->withTimestamp($timestamp);
        }, $this->items);
    }

    public function mapToDeleteCommands(float $timestamp): array
    {
        return \array_map(function (AttributeData $attributeData) use ($timestamp) {
            return DeleteAttributeCommand::of($attributeData->getId())->withTimestamp($timestamp);
        }, $this->items);
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
