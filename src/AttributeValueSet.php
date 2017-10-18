<?php
namespace SnowIO\FredhopperDataModel;

class AttributeValueSet implements \IteratorAggregate
{
    public static function of(array $attributeValues): self
    {
        $attributeValuesWithKeys = [];
        foreach ($attributeValues as $attributeValue) {
            $key = self::getKey($attributeValue);
            if (isset($attributeValuesWithKeys[$key])) {
                throw new \Error;
            }
            $attributeValuesWithKeys[$key] = $attributeValue;
        }
        return new self($attributeValuesWithKeys);
    }

    public function withAttributeValue(AttributeValue $attributeValue): self
    {
        $result = clone $this;
        $key = self::getKey($attributeValue);
        $result->attributeValues[$key] = $attributeValue;
        return $result;
    }

    public function add(self $otherSet): self
    {
        if ($otherSet->overlaps($this)) {
            throw new \Error;
        }
        $mergedValues = \array_merge($this->attributeValues, $otherSet->attributeValues);
        return new self($mergedValues);
    }

    public function overlaps(AttributeValueSet $otherSet): bool
    {
        return !empty(\array_intersect_key($this->attributeValues, $otherSet->attributeValues))
            || !empty(\array_intersect_key($otherSet->attributeValues, $this->attributeValues));
    }

    public function equals($object): bool
    {
        if (!$object instanceof self || \count($object->attributeValues) != \count($this->attributeValues)) {
            return false;
        }

        foreach ($this->attributeValues as $attributeValueId => $attributeValue) {
            $otherAttributeValue = $object->attributeValues[$attributeValueId] ?? null;
            if (!$attributeValue->equals($otherAttributeValue)) {
                return false;
            }
        }

        return true;
    }

    public function toArray(): array
    {
        return \array_values($this->attributeValues);
    }

    public function getIterator(): \Iterator
    {
        foreach ($this->attributeValues as $attributeValue) {
            yield $attributeValue;
        }
    }

    /** @var AttributeValue[] */
    private $attributeValues;

    private function __construct(array $attributeValues)
    {
        $this->attributeValues = $attributeValues;
    }

    private static function getKey(AttributeValue $attributeValue): string
    {
        return "{$attributeValue->getAttributeId()}-{$attributeValue->getLocale()}";
    }
}
