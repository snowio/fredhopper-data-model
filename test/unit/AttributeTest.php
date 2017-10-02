<?php
namespace SnowIO\FredhopperDataModel\Test;
use Exception;
use SnowIO\FredhopperDataModel\Attribute;

class AttributeTest extends \PHPUnit\Framework\TestCase
{

    public function testObjectInitialisation()
    {
        $attribute = Attribute::of(
            'colour',
            'list',
            [
                'en_GB' => 'Color',
                'fr_Fr' => 'Couleur',
            ]
        );

        self::assertEquals('colour', $attribute->getId());
        self::assertEquals('list', $attribute->getType());
        self::assertEquals([
            'en_GB' => 'Color',
            'fr_Fr' => 'Couleur',
        ], $attribute->getNames());
        self::assertEquals(null, $attribute->getName('en_DE'));
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
            [
                'en_GB' => 'Color',
                'fr_Fr' => 'Couleur',
            ]
        );
    }

    public function testToJson()
    {
        $attribute = Attribute::of(
            'colour',
            'list',
            [
                'en_GB' => 'Color',
                'fr_Fr' => 'Couleur',
            ]
        );

        $attribute = $attribute->withTimestamp(1506948035);
        self::assertEquals([
            '@timestamp' => 1506948035,
            'attribute_id' => 'colour',
            'type' => 'list',
            'names' => [
                'en_GB' => 'Color',
                'fr_Fr' => 'Couleur',
            ]
        ], $attribute->toJson());
    }

    public function testSanitisation()
    {
        $attributeId = Attribute::sanitizeId('tile-color');
        self::assertEquals('tile_color', $attributeId);
    }
}
