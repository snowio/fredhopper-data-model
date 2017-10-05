<?php
namespace SnowIO\FredhopperDataModel;

use function SnowIO\FredhopperDataModel\Internal\validateId;

class Variant extends Item
{
    public static function of(string $id, string $productId): self
    {
        validateId($productId);
        $variant = new self($id);
        $variant->productId = $productId;
        return $variant;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function toJson(): array
    {
        $json = parent::toJson();
        $json['variant_id'] = $this->getId();
        $json['product_id'] = $this->productId;
        return $json;
    }

    private $productId;
}
