<?php
namespace SnowIO\FredhopperDataModel;

final class CategoryDataSet
{
    use SetTrait;

    public function with(CategoryData $categoryData): self
    {
        $result = clone $this;
        $result->items[$categoryData->getId()] = $categoryData;
        return $result;
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
