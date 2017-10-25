<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Command;

use SnowIO\FredhopperDataModel\CategoryData;

final class SaveCategoryCommand extends Command
{
    public static function of(CategoryData $categoryData): self
    {
        $command = new self;
        $command->categoryData = $categoryData;
        return $command;
    }

    public function getCategoryData(): CategoryData
    {
        return $this->categoryData;
    }

    public function toJson(): array
    {
        return parent::toJson() + $this->categoryData->toJson();
    }

    /** @var CategoryData */
    private $categoryData;

    private function __construct()
    {

    }
}
