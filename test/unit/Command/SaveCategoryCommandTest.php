<?php
declare(strict_types = 1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\CategoryData;
use SnowIO\FredhopperDataModel\Command\SaveCategoryCommand;
use SnowIO\FredhopperDataModel\InternationalizedString;
use SnowIO\FredhopperDataModel\LocalizedString;

class SaveCategoryCommandTest extends TestCase
{
    public function testToJson()
    {
        $command = SaveCategoryCommand::of(CategoryData::of('mensshoes', InternationalizedString::of([
            LocalizedString::of('Men\'s Shoes', 'en_GB')
        ])))->withTimestamp(1510744232);
        self::assertEquals([
            '@timestamp' => 1510744232,
            'category_id' => 'mensshoes',
            'parent_id' => null,
            'names' => [
                'en_GB' => 'Men\'s Shoes',
            ],
        ], $command->toJson());

    }

    public function testAccessor()
    {
        $command = SaveCategoryCommand::of(CategoryData::of('mensshoes', InternationalizedString::of([
            LocalizedString::of('Men\'s Shoes', 'en_GB')
        ])));
        self::assertTrue(
            CategoryData::of('mensshoes', InternationalizedString::of([
                LocalizedString::of('Men\'s Shoes', 'en_GB')
            ]))->equals($command->getCategoryData())
        );
    }
}
