<?php
namespace SnowIO\FredhopperDataModel;

final class ProductData extends ItemData
{
    public static function of(string $id): self
    {
        $product = new self($id);
        $product->categoryIds = CategoryIdSet::create();
        return $product;
    }

    public function getCategoryIds(): CategoryIdSet
    {
        return $this->categoryIds;
    }

    public function withCategoryIds(CategoryIdSet $categoryIds): ProductData
    {
        $result = clone $this;
        $result->categoryIds = $categoryIds;
        return $result;
    }

    public function withCategoryId(string $categoryId): ProductData
    {
        $result = clone $this;
        $result->categoryIds = $this->categoryIds->with($categoryId);
        return $result;
    }

    public function equals($other): bool
    {
        return $other instanceof ProductData
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
