<?php
namespace SnowIO\FredhopperDataModel;

class AttributeValueSet implements \IteratorAggregate
{
    public static function of(array $attributeValues): self
    {
        $attributeValueSet = new self;
        $attributeValueSet->attributeValues = $attributeValues;
        return $attributeValueSet;
    }

    public function withAttributeValue(AttributeValue $attributeValue): self
    {
        $attributeValueSet = clone $this;
        $attributeValueSet->attributeValues[] = $attributeValue;
        return $attributeValueSet;
    }

    public function getIterator(): \Iterator
    {
        foreach ($this->attributeValues as $attributeValue) {
            yield $attributeValue;
        }
    }

    private $attributeValues;

    private function __construct()
    {

    }
}
