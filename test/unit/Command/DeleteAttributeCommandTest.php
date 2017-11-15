<?php
declare(strict_types = 1);
namespace SnowIO\FredhopperDataModel\Test;
use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\Command\DeleteAttributeCommand;

class DeleteAttributeCommandTest extends TestCase
{
    public function testToJson()
    {
        $command = DeleteAttributeCommand::of('volume')->withTimestamp(1510744232);

        self::assertEquals([
            '@timestamp' => 1510744232,
            'attribute_id' => 'volume',
        ], $command->toJson());
    }

    public function testAccessor()
    {
        $command = DeleteAttributeCommand::of('volume');
        self::assertEquals('volume', $command->getAttributeId());
    }
}