<?php
declare(strict_types = 1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeOption;
use SnowIO\FredhopperDataModel\Command\SaveAttributeOptionCommand;
use SnowIO\FredhopperDataModel\LocalizedString;

class SaveAttributeOptionCommandTest extends TestCase
{
    public function testToJson()
    {
        $command = SaveAttributeOptionCommand::of(AttributeOption::of('size',
            'large')->withDisplayValue(LocalizedString::of('Large', 'en_GB')))->withTimestamp(1510744232);
        self::assertEquals([
            '@timestamp' => 1510744232,
            'value_id' => 'large',
            'attribute_id' => 'size',
            'display_values' => [
                'en_GB' => 'Large',
            ]
        ], $command->toJson());
    }

    public function testAccessors()
    {
        $command = SaveAttributeOptionCommand::of(AttributeOption::of('size',
            'large')->withDisplayValue(LocalizedString::of('Large', 'en_GB')));
        self::assertTrue(AttributeOption::of('size',
            'large')->withDisplayValue(LocalizedString::of('Large', 'en_GB'))->equals($command->getAttributeOption()));
    }
}