<?php
namespace SnowIO\FredhopperDataModel\Test;

use Exception;
use SnowIO\FredhopperDataModel\Attribute;
use SnowIO\FredhopperDataModel\LocalizedStringSet;

class AttributeTest extends \PHPUnit\Framework\TestCase
{

    public function testObjectInitialisation()
    {
        $attributeNames = LocalizedStringSet::create()
            ->withValue('Color', 'en_GB')
            ->withValue('Coleur', 'fr_FR');
        $attribute = Attribute::of(
            'colour',
            'list',
            $attributeNames
        );

        self::assertSame('colour', $attribute->getId());
        self::assertSame('list', $attribute->getType());
        self::assertSame($attributeNames, $attribute->getNames());
        self::assertEquals(null, $attribute->getName('de_DE'));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidAttributeId()
    {
        Attribute::of(
            '$colour',
            'list',
            LocalizedStringSet::create()
                ->withValue('Color', 'en_GB')
                ->withValue('Coleur', 'fr_FR')
        );
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid Type
     */
    public function testInvalidAttributeType()
    {
        Attribute::of(
            'colour',
            'object',
            LocalizedStringSet::create()
                ->withValue('Color', 'en_GB')
                ->withValue('Coleur', 'fr_FR')
        );
    }

    public function testToJson()
    {
        $attribute = Attribute::of(
            'colour',
            'list',
            LocalizedStringSet::create()
                ->withValue('Color', 'en_GB')
                ->withValue('Coleur', 'fr_FR')
        );

        self::assertEquals([
            'attribute_id' => 'colour',
            'type' => 'list',
            'names' => [
                'en_GB' => 'Color',
                'fr_FR' => 'Coleur',
            ]
        ], $attribute->toJson());
    }

    public function testSanitisation()
    {
        $attributeId = Attribute::sanitizeId('tile-color');
        self::assertEquals('tile_color', $attributeId);
    }
}
