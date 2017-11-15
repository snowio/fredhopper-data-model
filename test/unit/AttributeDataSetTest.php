<?php
declare(strict_types = 1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeData;
use SnowIO\FredhopperDataModel\AttributeDataSet;
use SnowIO\FredhopperDataModel\AttributeType;
use SnowIO\FredhopperDataModel\Command\DeleteAttributeCommand;
use SnowIO\FredhopperDataModel\Command\SaveAttributeCommand;
use SnowIO\FredhopperDataModel\InternationalizedString;
use SnowIO\FredhopperDataModel\LocalizedString;

class AttributeDataSetTest extends TestCase
{
    use CommandHelper;

    public function testWithers()
    {
        $attributeDataSet = AttributeDataSet::of([
            AttributeData::of('volume', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Volume', 'en_GB'))),
            AttributeData::of('density', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Density', 'en_GB'))),
            AttributeData::of('length', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Length', 'en_GB'))),
            AttributeData::of('width', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Width', 'en_GB'))),
        ]);

        $attributeDataSet = $attributeDataSet->with(AttributeData::of('volume', AttributeType::FLOAT, InternationalizedString::create()
            ->with(LocalizedString::of('Volume', 'en_GB'))));

        self::assertTrue($attributeDataSet->equals(AttributeDataSet::of([
            AttributeData::of('volume', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Volume', 'en_GB'))),
            AttributeData::of('density', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Density', 'en_GB'))),
            AttributeData::of('length', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Length', 'en_GB'))),
            AttributeData::of('width', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Width', 'en_GB'))),
        ])));
    }

    public function testMapToSaveCommands()
    {
        $attributeDataSet = AttributeDataSet::of([
            AttributeData::of('volume', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Volume', 'en_GB'))),
            AttributeData::of('density', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Density', 'en_GB'))),
        ]);

        $expectedCommands = [
            'volume' => SaveAttributeCommand::of(AttributeData::of('volume', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Volume', 'en_GB'))))->withTimestamp(1),
            'density' => SaveAttributeCommand::of(AttributeData::of('density', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Density', 'en_GB'))))->withTimestamp(1),
        ];

        self::assertEquals($this->getJson($expectedCommands), $this->getJson($attributeDataSet->mapToSaveCommands(1)));
    }

    public function testMapToDeleteCommands()
    {
        $attributeDataSet = AttributeDataSet::of([
            AttributeData::of('volume', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Volume', 'en_GB'))),
            AttributeData::of('density', AttributeType::FLOAT, InternationalizedString::create()
                ->with(LocalizedString::of('Density', 'en_GB'))),
        ]);

        $expectedCommands = [
            'volume' => DeleteAttributeCommand::of('volume')->withTimestamp(1),
            'density' => DeleteAttributeCommand::of('density')->withTimestamp(1),
        ];

        self::assertEquals($this->getJson($expectedCommands), $this->getJson($attributeDataSet->mapToDeleteCommands(1)));
    }
}
