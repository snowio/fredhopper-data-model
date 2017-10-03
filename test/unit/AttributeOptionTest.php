<?php
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeOption;

class AttributeOptionTest extends TestCase
{
    public function testObjectInitialisation()
    {
        $attributeOption = AttributeOption::of('red', 'color',[
                'de_DE' => 'Rot',
                'es_ES' => 'Rojo',
                'fr_FR' => 'Rouge',
                'en_GB' => 'Red',
            ])
            ->withTimestamp(1506951117);

        self::assertEquals(1506951117, $attributeOption->getTimestamp());
        self::assertEquals('red', $attributeOption->getOptionId());
        self::assertEquals('color', $attributeOption->getAttributeId());
        self::assertEquals('Red', $attributeOption->getLabel('en_GB'));
        self::assertEquals([
            'en_GB' => 'Red',
            'de_DE' => 'Rot',
            'es_ES' => 'Rojo',
            'fr_FR' => 'Rouge',
        ], $attributeOption->getLabels());
        self::assertEquals(null, $attributeOption->getLabel('es_US'));
    }

    public function testToJson()
    {
        $attributeOption = AttributeOption::of('red', 'color', [
            'en_GB' => 'Red',
            'de_DE' => 'Rot',
            'es_ES' => 'Rojo',
            'fr_FR' => 'Rouge',
        ])
            ->withTimestamp(1506951117);

        self::assertEquals([
            '@timestamp' => 1506951117,
            'option_id' => 'red',
            'attribute_id' => 'color',
            'labels' => [
                'en_GB' => 'Red',
                'de_DE' => 'Rot',
                'es_ES' => 'Rojo',
                'fr_FR' => 'Rouge',
            ],
        ], $attributeOption->toJson());
    }
}
