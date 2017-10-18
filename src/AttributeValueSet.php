<?php
namespace SnowIO\FredhopperDataModel;

class AttributeValueSet implements \IteratorAggregate
{
    public static function of(array $attributeValues): self
    {
        return new self($attributeValues);
    }

    public function withAttributeValue(AttributeValue $attributeValue): self
    {
        $attributeValueSet = clone $this;
        $attributeValueSet->attributeValues[] = $attributeValue;
        return $attributeValueSet;
    }

    public function add(self $attributeValueSet): self
    {
        $getId = function (AttributeValue $attributeValue) {
            return $attributeValue->getAttributeId();
        };

        $inputValues = array_map($getId, $attributeValueSet->attributeValues);
        $values = array_map($getId, $this->attributeValues);

        if (
            \array_intersect($values, $inputValues) !== []
            || \array_intersect($inputValues, $values) !== []
        ) {
            throw new \Exception();
        }

        $mergedValues = \array_merge($this->attributeValues, $attributeValueSet->attributeValues);
        return new self($mergedValues);
    }

    public function getIterator(): \Iterator
    {
        foreach ($this->attributeValues as $attributeValue) {
            yield $attributeValue;
        }
    }

    private $attributeValues;

    private function __construct(array $attributeValues)
    {
        $this->attributeValues = $attributeValues;
    }
}
