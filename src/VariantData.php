<?php
namespace SnowIO\FredhopperDataModel;

final class VariantData extends ItemData
{
    public static function of(string $id, string $productId): self
    {
        ProductData::validateId($productId);
        $variant = new self($id);
        if ($id === $productId) {
            throw new \Error('variant_id and product_id must not be the same.');
        }
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
