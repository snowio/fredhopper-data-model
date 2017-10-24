<?php
namespace SnowIO\FredhopperDataModel;

use function SnowIO\FredhopperDataModel\Internal\validateId;

class AttributeOption extends Entity
{
    public static function of(string $attributeId, string $valueId): self
    {
        validateId($attributeId);
        validateId($valueId);
        $attributeOption = new self;
        $attributeOption->attributeId = $attributeId;
        $attributeOption->valueId = $valueId;
        $attributeOption->displayValues = LocalizedStringSet::create();
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

    public function withDisplayValues(LocalizedStringSet $displayValues): self
    {
        $attributeOption = clone $this;
        $attributeOption->displayValues = $displayValues;
        return $attributeOption;
    }

    public function withDisplayValue(LocalizedString $displayValue): self
    {
        $attributeOption = clone $this;
        $attributeOption->displayValues = $this->displayValues->with($displayValue);
        return $attributeOption;
    }

    public function getDisplayValues(): LocalizedStringSet
    {
        return $this->displayValues;
    }

    public function getDisplayValue(string $locale): ?string
    {
        return $this->displayValues->getValue($locale);
    }

    public function equals($other): bool
    {
        return $other instanceof AttributeOption
            && $other->valueId === $this->valueId
            && $other->attributeId === $this->attributeId
            && $other->displayValues->equals($this->displayValues);
    }

    public function toJson(): array
    {
        $json = parent::toJson();
        $json['value_id'] = $this->valueId;
        $json['attribute_id'] = $this->attributeId;
        $json['display_values'] = $this->displayValues->toJson();
        return $json;
    }

    private $valueId;
    private $attributeId;
    /** @var LocalizedStringSet */
    private $displayValues;

    private function __construct()
    {
    }
}
