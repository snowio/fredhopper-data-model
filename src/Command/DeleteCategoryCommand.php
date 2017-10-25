<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Command;

use SnowIO\FredhopperDataModel\CategoryData;

class DeleteCategoryCommand extends Command
{
    public static function of(string $categoryId)
    {
        CategoryData::validateId($categoryId);
        $command = new self;
        $command->categoryId = $categoryId;
        return $command;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function toJson(): array
    {
        return parent::toJson() + ['category_id' => $this->categoryId];
    }

    private $categoryId;

    private function __construct()
    {

    }
}
