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

    public static function validateId(string $id): void
    {
        validateId($id);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAttributeValues(): AttributeValueSet
    {
        return $this->attributeValues;
    }

    /**
     * @return static
     */
    public function withAttributeValues(AttributeValueSet $attributeValues): self
    {
        $item = clone $this;
        $item->attributeValues = $attributeValues;
        return $item;
    }

    /**
     * @return static
     */
    public function withAttributeValue(AttributeValue $attributeValue): self
    {
        $item = clone $this;
        $item->attributeValues = $this->attributeValues->with($attributeValue);
        return $item;
    }

    public function equals($other): bool
    {
        return $other instanceof Item
            && $this->id === $other->id
            && $this->attributeValues->equals($other->attributeValues);
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
        self::validateId($id);
        $this->id = $id;
        $this->attributeValues = AttributeValueSet::of([]);
    }
}
