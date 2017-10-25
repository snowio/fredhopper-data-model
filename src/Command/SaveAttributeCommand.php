<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Command;

use SnowIO\FredhopperDataModel\AttributeData;

final class SaveAttributeCommand extends Command
{
    public static function of(AttributeData $attributeData): self
    {
        $command = new self;
        $command->attributeData = $attributeData;
        return $command;
    }

    public function getAttributeData(): AttributeData
    {
        return $this->attributeData;
    }

    public function toJson(): array
    {
        return parent::toJson() + $this->attributeData->toJson();
    }

    /** @var AttributeData */
    private $attributeData;

    private function __construct()
    {

    }
}
