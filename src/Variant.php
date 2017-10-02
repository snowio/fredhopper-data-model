<?php
namespace SnowIO\FredhopperDataModel;

class Variant extends Item
{
    public static function of(string $id, string $productId): self
    {
        validateId($id);
        $variant = new self($productId);
        $variant->variantId = $id;
        return $variant;
    }

    public function getVariantId(): string
    {
        return $this->variantId;
    }

    public function toJson(): array
    {
        $json = parent::toJson();
        $json['variant_id'] = $this->variantId;
        return $json;
    }

    private $variantId;
}
