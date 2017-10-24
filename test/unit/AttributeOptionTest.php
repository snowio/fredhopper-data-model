<?php
namespace SnowIO\FredhopperDataModel\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeOption;
use SnowIO\FredhopperDataModel\LocalizedString;
use SnowIO\FredhopperDataModel\LocalizedStringSet;

class AttributeOptionTest extends TestCase
{
    public function testObjectInitialisation()
    {
        $displayValues = LocalizedStringSet::create()
            ->withValue('Red', 'en_GB')
            ->withValue('Rot', 'de_DE')
            ->withValue('Rojo', 'es_ES')
            ->withValue('Rouge', 'fr_FR');
        $option = AttributeOption::of('color', 'red')
            ->withDisplayValues($displayValues)
            ->withDisplayValue(LocalizedString::of('Rougee', 'fr_FR'))
            ->withTimestamp(1506951117);

        self::assertSame(1506951117, $option->getTimestamp());
        self::assertSame('red', $option->getValueId());
        self::assertSame('color', $option->getAttributeId());
        self::assertSame('Red', $option->getDisplayValue('en_GB'));
        self::assertTrue($option->getDisplayValues()->equals($displayValues->withValue('Rougee', 'fr_FR')));
        self::assertSame(null, $option->getDisplayValue('es_US'));
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
        $displayValues = LocalizedStringSet::create()
            ->withValue('Red', 'en_GB')
            ->withValue('Rot', 'de_DE')
            ->withValue('Rojo', 'es_ES')
            ->withValue('Rouge', 'fr_FR');
        $attributeOption = AttributeOption::of('color', 'red')
            ->withDisplayValues($displayValues)
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

    public function testChangeDisplayValue()
    {
        $option = AttributeOption::of('color', 'red')
            ->withDisplayValue(LocalizedString::of('Red', 'en_GB'))
            ->withDisplayValue(LocalizedString::of('Red!', 'en_GB'));

        self::assertSame('Red!', $option->getDisplayValue('en_GB'));
    }
}
