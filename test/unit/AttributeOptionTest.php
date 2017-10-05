<?php
namespace SnowIO\FredhopperDataModel\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeOption;

class AttributeOptionTest extends TestCase
{
    public function testObjectInitialisation()
    {
        $attributeOption = AttributeOption::of('color', 'red')
            ->withDisplayValues([
                'en_GB' => 'Red',
                'de_DE' => 'Rot',
                'es_ES' => 'Rojo',
                'fr_FR' => 'Rouge',
            ])->withDisplayValue('Rouge', 'fr_FR')
            ->withTimestamp(1506951117);

        self::assertEquals(1506951117, $attributeOption->getTimestamp());
        self::assertEquals('red', $attributeOption->getValueId());
        self::assertEquals('color', $attributeOption->getAttributeId());
        self::assertEquals('Red', $attributeOption->getDisplayValue('en_GB'));
        self::assertEquals([
            'en_GB' => 'Red',
            'de_DE' => 'Rot',
            'es_ES' => 'Rojo',
            'fr_FR' => 'Rouge',
        ], $attributeOption->getDisplayValues());
        self::assertEquals(null, $attributeOption->getDisplayValue('es_US'));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidAttributeId()
    {
        AttributeOption::of('**color__&', 'red');
    }

    public function testToJson()
    {
        $attributeOption = AttributeOption::of('color', 'red')
            ->withDisplayValues([
                'en_GB' => 'Red',
                'de_DE' => 'Rot',
                'es_ES' => 'Rojo',
                'fr_FR' => 'Rouge',
            ])
            ->withTimestamp(1506951117);

        self::assertEquals([
            '@timestamp' => 1506951117,
            'value_id' => 'red',
            'attribute_id' => 'color',
            'display_values' => [
                'en_GB' => 'Red',
                'de_DE' => 'Rot',
                'es_ES' => 'Rojo',
                'fr_FR' => 'Rouge',
            ],
        ], $attributeOption->toJson());
    }
}
