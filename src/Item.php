<?php
namespace SnowIO\FredhopperDataModel;

abstract class Item extends Entity
{
    public static function sanitizeId(string $productId): string
    {
        return sanitizeId($productId);
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getAttributeValues(): AttributeValueSet
    {
        return $this->attributeValues;
    }

    public function withAttributeValues(AttributeValueSet $attributeValues): self
    {
        $item = clone $this;
        $item->attributeValues = $attributeValues;
        return $item;
    }

    public function toJson(): array
    {
        $json = parent::toJson();
        $attributeValues = [];
        /** @var AttributeValue $attributeValue */
        foreach ($this->attributeValues as $attributeValue) {
            $attributeValues += $attributeValue->toJson();
        }
        $json['product_id'] = $this->productId;
        $json['attribute_values'] = $attributeValues;
        return $json;
    }

    private $productId;
    private $attributeValues;

    protected function __construct(string $productId)
    {
        validateId($productId);
        $this->productId = $productId;
        $this->attributeValues = AttributeValueSet::of([]);
    }
}
