<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel;

final class CategoryIdSet implements \IteratorAggregate
{
    use SetTrait {
        overlaps as private;
        add as private;
    }

    public function with(string $categoryId): self
    {
        CategoryData::validateId($categoryId);
        $result = clone $this;
        $result->items[$categoryId] = $categoryId;
        return $result;
    }

    public function add(self $otherSet): self
    {
        $result = new self;
        $result->items = \array_merge($this->items, $otherSet->items);
        return $result;
    }

    public function toJson(): array
    {
        return \array_values($this->items);
    }

    private static function getKey(string $categoryId): string
    {
        CategoryData::validateId($categoryId);
        return $categoryId;
    }
}
