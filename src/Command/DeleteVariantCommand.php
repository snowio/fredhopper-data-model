<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Command;

use SnowIO\FredhopperDataModel\VariantData;

final class DeleteVariantCommand extends Command
{
    public static function of(string $variantId)
    {
        VariantData::validateId($variantId);
        $command = new self;
        $command->variantId = $variantId;
        return $command;
    }

    public function getVariantId(): string
    {
        return $this->variantId;
    }

    public function toJson(): array
    {
        return parent::toJson() + ['variant_id' => $this->variantId];
    }

    private $variantId;

    private function __construct()
    {

    }
}
