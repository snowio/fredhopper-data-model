<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\Command\DeleteAttributeOptionCommand;

class DeleteAttributeOptionCommandTest extends TestCase
{
    public function testToJson()
    {
        $command  = DeleteAttributeOptionCommand::of('size', 'large')->withTimestamp(1510744232);
        self::assertEquals([
            '@timestamp' => 1510744232,
            'attribute_id' => 'size',
            'value_id' => 'large',
        ], $command->toJson());
    }

    public function testAccessor()
    {
        $command = DeleteAttributeOptionCommand::of('size', 'large');
        self::assertEquals('size', $command->getAttributeId());
        self::assertEquals('large', $command->getValueId());
    }
}
