<?php
namespace SnowIO\FredhopperDataModel;

use function SnowIO\FredhopperDataModel\Internal\validateId;
use function SnowIO\FredhopperDataModel\Internal\validateLocale;

class AttributeOption extends Entity
{
    public static function of(string $attributeId, string $valueId): self
    {
        validateId($attributeId);
        validateId($valueId);
        $attributeOption = new self;
        $attributeOption->attributeId = $attributeId;
        $attributeOption->valueId = $valueId;
        return $attributeOption;
    }

    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    public function getValueId(): string
    {
        return $this->valueId;
    }

    public function withDisplayValues(array $displayValues): self
    {
        foreach ($displayValues as $locale => $displayValue) {
            validateLocale($locale);
        }
        $attributeOption = clone $this;
        $attributeOption->displayValues = $displayValues;
        return $attributeOption;
    }

    public function withDisplayValue(string $displayValue, string $locale): self
    {
        validateLocale($locale);
        $attributeOption = clone $this;
        $attributeOption->displayValues[$locale] = $displayValue;
        return $attributeOption;
    }

    public function getDisplayValues(): array
    {
        return $this->displayValues ?? [];
    }

    public function getDisplayValue($locale): ?string
    {
        return $this->displayValues[$locale] ?? null;
    }

    public function toJson(): array
    {
        $json = parent::toJson();
        $json['value_id'] = $this->valueId;
        $json['attribute_id'] = $this->attributeId;
        $json['display_values'] = $this->displayValues;
        return $json;
    }

    private $valueId;
    private $attributeId;
    private $displayValues = [];

    private function __construct()
    {
    }
}
