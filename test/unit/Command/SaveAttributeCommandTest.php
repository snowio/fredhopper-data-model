<?php
declare(strict_types = 1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeData;
use SnowIO\FredhopperDataModel\AttributeType;
use SnowIO\FredhopperDataModel\Command\SaveAttributeCommand;
use SnowIO\FredhopperDataModel\InternationalizedString;
use SnowIO\FredhopperDataModel\LocalizedString;

class SaveAttributeCommandTest extends TestCase
{
    public function testToJson()
    {
        $command = SaveAttributeCommand::of(AttributeData::of('volume', AttributeType::FLOAT,
            InternationalizedString::of([LocalizedString::of('Volume', 'en_GB')])))->withTimestamp(1510744232);
        self::assertEquals([
            '@timestamp' => 1510744232,
            'attribute_id' => 'volume',
            'type' => 'float',
            'names' => [
                'en_GB' => 'Volume',
            ]
        ], $command->toJson());
    }

    public function testAccessor()
    {
        $command = SaveAttributeCommand::of(AttributeData::of('volume', AttributeType::FLOAT,
            InternationalizedString::of([LocalizedString::of('Volume', 'en_GB')])));
        self::assertTrue(AttributeData::of('volume', AttributeType::FLOAT,
            InternationalizedString::of([
                LocalizedString::of('Volume', 'en_GB')
            ]))->equals($command->getAttributeData()));
    }

}