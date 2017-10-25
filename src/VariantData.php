<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel;

final class VariantData extends ItemData
{
    public static function of(string $id, string $productId): self
    {
        ProductData::validateId($productId);
        $variant = new self($id);
        if ($id === $productId) {
            throw new FredhopperDataException('variant_id and product_id must not be the same.');
        }
        $variant->productId = $productId;
        return $variant;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function equals($other): bool
    {
        return $other instanceof VariantData
            && parent::equals($other)
            && $this->productId === $other->productId;
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
