<?php
namespace SnowIO\FredhopperDataModel\Test;

use Exception;
use SnowIO\FredhopperDataModel\AttributeValue;

class AttributeValueTest extends \PHPUnit\Framework\TestCase
{
    public function testObjectInitialisation()
    {
        $attributeValue = AttributeValue::of('color', 'Rot')->withLocale('de_DE');
        self::assertEquals('color', $attributeValue->getAttributeId());
        self::assertEquals('Rot', $attributeValue->getValue());
        self::assertEquals('de_DE', $attributeValue->getLocale());
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidAttributeId()
    {
        AttributeValue::of('c%o*lour', 'Rose');
    }

    public function testSanitization()
    {
        $sanitizedValueId = AttributeValue::sanitizeId('red$');
        self::assertEquals('red', $sanitizedValueId);
    }
}
