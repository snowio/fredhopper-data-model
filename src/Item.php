<?php
namespace SnowIO\FredhopperDataModel;

use function SnowIO\FredhopperDataModel\Internal\sanitizeId;
use function SnowIO\FredhopperDataModel\Internal\validateId;

abstract class Item extends Entity
{
    public static function sanitizeId(string $id): string
    {
        return sanitizeId($id);
    }

    public function getId(): string
    {
        return $this->id;
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
        $json['attribute_values'] = $attributeValues;
        return $json;
    }

    private $id;
    private $attributeValues;

    protected function __construct(string $id)
    {
        validateId($id);
        $this->id = $id;
        $this->attributeValues = AttributeValueSet::of([]);
    }
}
