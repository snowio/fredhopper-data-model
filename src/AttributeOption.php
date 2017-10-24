<?php
namespace SnowIO\FredhopperDataModel;

use function SnowIO\FredhopperDataModel\Internal\sanitizeId;
use function SnowIO\FredhopperDataModel\Internal\validateId;

final class AttributeOption
{
    public static function of(string $attributeId, string $valueId): self
    {
        validateId($attributeId);
        self::validateValueId($valueId);
        $attributeOption = new self;
        $attributeOption->attributeId = $attributeId;
        $attributeOption->valueId = $valueId;
        $attributeOption->displayValues = InternationalizedString::create();
        return $attributeOption;
    }

    public static function validateValueId(string $valueId): void
    {
        validateId($valueId);
    }

    public static function sanitizeValueId(string $valueId): string
    {
        return sanitizeId($valueId);
    }

    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    public function getValueId(): string
    {
        return $this->valueId;
    }

    public function withDisplayValues(InternationalizedString $displayValues): self
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

    public function getDisplayValues(): InternationalizedString
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
        return [
            'value_id' => $this->valueId,
            'attribute_id' => $this->attributeId,
            'display_values' => $this->displayValues->toJson(),
        ];
    }

    private $valueId;
    private $attributeId;
    /** @var InternationalizedString */
    private $displayValues;

    private function __construct()
    {
    }
}
