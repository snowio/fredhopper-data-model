<?php
namespace SnowIO\FredhopperDataModel;

class Product extends Item
{
    public static function of(string $id, array $categoryIds): self
    {
        foreach ($categoryIds as $categoryId) {
            Category::validateId($categoryId);
        }
        $product = new self($id);
        $product->categoryIds = $categoryIds;
        return $product;
    }

    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }

    public function toJson(): array
    {
        $json = parent::toJson();
        $json['product_id'] = $this->getId();
        $json['category_ids'] = $this->categoryIds;
        return $json;
    }

    private $categoryIds;
}
