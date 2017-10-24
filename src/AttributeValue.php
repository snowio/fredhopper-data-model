<?php
namespace SnowIO\FredhopperDataModel;

use function SnowIO\FredhopperDataModel\Internal\sanitizeId;
use function SnowIO\FredhopperDataModel\Internal\validateId;

final class AttributeValue
{
    public static function of(string $attributeId, $value): self
    {
        validateId($attributeId);
        $attributeValue = new self;
        $attributeValue->attributeId = $attributeId;
        $attributeValue->value = $value;
        return $attributeValue;
    }

    public static function sanitizeId(string $valueId): string
    {
        return sanitizeId($valueId);
    }

    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function withLocale(string $locale): self
    {
        Locale::validate($locale);
        $attributeValue = clone $this;
        $attributeValue->locale = $locale;
        return $attributeValue;
    }

    public function equals($object): bool
    {
        return $object instanceof self
            && $object->attributeId === $this->attributeId
            && $object->value === $this->value
            && $object->locale === $this->locale;
    }

    public function toJson(): array
    {
        return [
            $this->attributeId => $this->value,
        ];
    }

    private $attributeId;
    private $value;
    private $locale;

    private function __construct()
    {
    }
}
