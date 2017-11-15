<?php
declare(strict_types = 1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\Command\DeleteCategoryCommand;

class DeleteCategoryCommandTest extends TestCase
{
    public function testToJson()
    {
        $command = DeleteCategoryCommand::of('mensshoes')->withTimestamp(1510744232);
        self::assertEquals([
            '@timestamp' => 1510744232,
            'category_id' => 'mensshoes',
        ], $command->toJson());
    }

    public function testAccessors()
    {
        $command = DeleteCategoryCommand::of('mensshoes');
        self::assertEquals('mensshoes', $command->getCategoryId());
    }
}