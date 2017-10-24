<?php
namespace SnowIO\FredhopperDataModel\Command;

use SnowIO\FredhopperDataModel\AttributeData;
use SnowIO\FredhopperDataModel\AttributeOption;

class DeleteAttributeOptionCommand extends Command
{
    public static function of(string $attributeId, string $valueId): self
    {
        AttributeData::validateId($attributeId);
        AttributeOption::validateValueId($valueId);
        $command = new self;
        $command->attributeId = $attributeId;
        $command->valueId = $valueId;
        return $command;
    }

    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    public function getValueId(): string
    {
        return $this->valueId;
    }

    public function toJson(): array
    {
        return parent::toJson() + [
            'attribute_id' => $this->attributeId,
            'value_id' => $this->valueId,
        ];
    }

    private $attributeId;
    private $valueId;

    private function __construct()
    {

    }
}
