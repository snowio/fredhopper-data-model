<?php
namespace SnowIO\FredhopperDataModel\Command;

use SnowIO\FredhopperDataModel\AttributeOption;

final class SaveAttributeOptionCommand extends Command
{
    public static function of(AttributeOption $attributeOption): self
    {
        $command = new self;
        $command->attributeOption = $attributeOption;
        return $command;
    }

    public function getAttributeOption(): AttributeOption
    {
        return $this->attributeOption;
    }

    public function toJson(): array
    {
        return parent::toJson() + $this->attributeOption->toJson();
    }

    /** @var AttributeOption */
    private $attributeOption;

    private function __construct()
    {

    }
}
