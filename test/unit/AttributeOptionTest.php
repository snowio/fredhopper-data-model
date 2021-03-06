<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeOption;
use SnowIO\FredhopperDataModel\LocalizedString;
use SnowIO\FredhopperDataModel\InternationalizedString;

class AttributeOptionTest extends TestCase
{
    public function testObjectInitialisation()
    {
        $displayValues = InternationalizedString::create()
            ->withValue('Red', 'en_GB')
            ->withValue('Rot', 'de_DE')
            ->withValue('Rojo', 'es_ES')
            ->withValue('Rouge', 'fr_FR');
        $option = AttributeOption::of('color', 'red')
            ->withDisplayValues($displayValues)
            ->withDisplayValue(LocalizedString::of('Rougee', 'fr_FR'));

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
        $displayValues = InternationalizedString::create()
            ->withValue('Red', 'en_GB')
            ->withValue('Rot', 'de_DE')
            ->withValue('Rojo', 'es_ES')
            ->withValue('Rouge', 'fr_FR');
        $attributeOption = AttributeOption::of('color', 'red')
            ->withDisplayValues($displayValues);

        self::assertEquals([
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
