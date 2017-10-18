<?php
namespace SnowIO\FredhopperDataModel\Test;

use SnowIO\FredhopperDataModel\AttributeValue;
use SnowIO\FredhopperDataModel\AttributeValueSet;

class AttributeValueSetTest extends \PHPUnit\Framework\TestCase
{
    public function testDuplicateAttributeIdWithDifferentLocaleSupported()
    {
        $red = AttributeValue::of('color', 'red')->withLocale('en_GB');
        $blue = AttributeValue::of('color', 'rot')->withLocale('de_DE');
        $set = AttributeValueSet::of([$red, $blue]);
        self::assertCount(2, $set->toArray());
    }

    /**
     * @expectedException \Error
     */
    public function testDuplicateAttributeIdThrows()
    {
        $red = AttributeValue::of('color', 'red');
        $blue = AttributeValue::of('color', 'blue');
        AttributeValueSet::of([$red, $blue]);
    }

    /**
     * @expectedException \Error
     */
    public function testDuplicateAttributeIdLocaleCombinationThrows()
    {
        $red = AttributeValue::of('color', 'red')->withLocale('en_GB');
        $blue = AttributeValue::of('color', 'blue')->withLocale('en_GB');
        AttributeValueSet::of([$red, $blue]);
    }

    public function testAddingAnAttributeSet()
    {
        $colorUk = AttributeValue::of('color', 'red')->withLocale('en_GB');
        $colorDe = AttributeValue::of('color', 'rot')->withLocale('de_DE');
        $size = AttributeValue::of('size', 'large');
        $length = AttributeValue::of('length', 300);
        $weight = AttributeValue::of('weight', 80);
        $voltage = AttributeValue::of('voltage', 30);
        $attributes = AttributeValueSet::of([$colorUk, $size, $length]);
        $otherAttributes = AttributeValueSet::of([$colorDe, $weight, $voltage]);
        $result = $attributes->add($otherAttributes);
        $expectedResult = AttributeValueSet::of([$colorUk, $colorDe, $size, $length, $weight, $voltage]);
        self::assertTrue($result->equals($expectedResult));
    }

    /**
     * @expectedException \Error
     */
    public function testAddingOverlappingAttributeSetsThrows()
    {
        $red = AttributeValue::of('color', 'red');
        $blue = AttributeValue::of('color', 'blue');
        $size = AttributeValue::of('size', 'large');
        $length = AttributeValue::of('length', 300);
        $attributes = AttributeValueSet::of([$red, $size, $length]);
        $otherAttributes = AttributeValueSet::of([$blue]);
        $attributes->add($otherAttributes);
    }
}
