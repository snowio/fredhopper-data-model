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
        self::assertSame(2, $set->count());
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

    /**
     * @expectedException \Error
     */
    public function testPassingNonAttributeValueToConstructorThrows()
    {
        AttributeValueSet::of(['hello dave!']);
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

    public function testEquals()
    {
        $colour1 = AttributeValue::of('color', 'red');
        $colour2 = AttributeValue::of('color', 'red');
        $size1 = AttributeValue::of('size', 'large');
        $size2 = AttributeValue::of('size', 'large');
        $length = AttributeValue::of('length', 'long');
        $set1 = AttributeValueSet::of([$colour1, $size1]);
        $set2 = AttributeValueSet::of([$size2, $colour2]);
        self::assertTrue($set1->equals($set2));
        $set3 = $set2->with($length);
        self::assertFalse($set1->equals($set3));
    }
}
