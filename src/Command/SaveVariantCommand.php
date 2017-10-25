<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Command;

use SnowIO\FredhopperDataModel\VariantData;

class SaveVariantCommand extends Command
{
    public static function of(VariantData $variantData): self
    {
        $command = new self;
        $command->variantData = $variantData;
        return $command;
    }

    public function getVariantData(): VariantData
    {
        return $this->variantData;
    }

    public function toJson(): array
    {
        return parent::toJson() + $this->variantData->toJson();
    }

    /** @var VariantData */
    private $variantData;

    private function __construct()
    {

    }
}
