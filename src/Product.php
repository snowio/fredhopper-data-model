<?php
namespace SnowIO\FredhopperDataModel;

class Product extends Item
{
    public static function of(string $id, CategoryIdSet $categoryIds): self
    {
        $product = new self($id);
        $product->categoryIds = $categoryIds;
        return $product;
    }

    public function getCategoryIds(): CategoryIdSet
    {
        return $this->categoryIds;
    }

    public function withCategoryIds(CategoryIdSet $categoryIds): Product
    {
        $result = clone $this;
        $result->categoryIds = $categoryIds;
        return $result;
    }

    public function withCategoryId(string $categoryId): Product
    {
        $result = clone $this;
        $result->categoryIds = $this->categoryIds->with($categoryId);
        return $result;
    }

    public function equals($other): bool
    {
        return $other instanceof Product
            && parent::equals($other)
            && $this->categoryIds->equals($other->categoryIds);
    }

    public function toJson(): array
    {
        $json = parent::toJson();
        $json['product_id'] = $this->getId();
        $json['category_ids'] = $this->categoryIds->toJson();
        return $json;
    }

    private $categoryIds;
}
