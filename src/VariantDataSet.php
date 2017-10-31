<?php
namespace SnowIO\FredhopperDataModel;

use SnowIO\FredhopperDataModel\Command\SaveVariantCommand;

final class VariantDataSet implements \IteratorAggregate
{
    use SetTrait;

    public function with(VariantData $variantData): self
    {
        $result = clone $this;
        $result->items[$variantData->getId()] = $variantData;
        return $result;
    }

    public function mapToSaveCommands(int $timestamp): array
    {
        return \array_map(function (VariantData $variantData) use ($timestamp) {
            return SaveVariantCommand::of($variantData)->withTimestamp($timestamp);
        }, $this->items);
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
