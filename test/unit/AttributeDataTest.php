<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Test;

use Exception;
use SnowIO\FredhopperDataModel\AttributeData;
use SnowIO\FredhopperDataModel\InternationalizedString;

class AttributeDataTest extends \PHPUnit\Framework\TestCase
{

    public function testObjectInitialisation()
    {
        $attributeNames = InternationalizedString::create()
            ->withValue('Color', 'en_GB')
            ->withValue('Coleur', 'fr_FR');
        $attribute = AttributeData::of(
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
        AttributeData::of(
            '$colour',
            'list',
            InternationalizedString::create()
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
        AttributeData::of(
            'colour',
            'object',
            InternationalizedString::create()
                ->withValue('Color', 'en_GB')
                ->withValue('Coleur', 'fr_FR')
        );
    }

    public function testToJson()
    {
        $attribute = AttributeData::of(
            'colour',
            'list',
            InternationalizedString::create()
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
        $attributeId = AttributeData::sanitizeId('tile-color');
        self::assertEquals('tile_color', $attributeId);
    }
}
