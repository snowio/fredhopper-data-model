<?php
namespace SnowIO\FredhopperDataModel;

use SnowIO\FredhopperDataModel\Command\DeleteCategoryCommand;
use SnowIO\FredhopperDataModel\Command\SaveCategoryCommand;

final class CategoryDataSet implements \IteratorAggregate
{
    use SetTrait;

    public function with(CategoryData $categoryData): self
    {
        $result = clone $this;
        $result->items[$categoryData->getId()] = $categoryData;
        return $result;
    }

    public function mapToSaveCommands(float $timestamp): array
    {
        return \array_map(function (CategoryData $categoryData) use ($timestamp) {
            return SaveCategoryCommand::of($categoryData)->withTimestamp($timestamp);
        }, $this->items);
    }

    public function mapToDeleteCommands(float $timestamp): array
    {
        return \array_map(function (CategoryData $categoryData) use ($timestamp) {
            return DeleteCategoryCommand::of($categoryData->getId())->withTimestamp($timestamp);
        }, $this->items);
    }

    private static function getKey(CategoryData $categoryData): string
    {
        return $categoryData->getId();
    }

    private static function itemsAreEqual(CategoryData $item1, CategoryData $item2): bool
    {
        return $item1->equals($item2);
    }
}
