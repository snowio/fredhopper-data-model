<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Command;

use SnowIO\FredhopperDataModel\AttributeData;

class DeleteAttributeCommand extends Command
{
    public static function of(string $attributeId)
    {
        AttributeData::validateId($attributeId);
        $command = new self;
        $command->attributeId = $attributeId;
        return $command;
    }

    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    public function toJson(): array
    {
        return parent::toJson() + ['attribute_id' => $this->attributeId];
    }

    private $attributeId;

    private function __construct()
    {

    }
}
