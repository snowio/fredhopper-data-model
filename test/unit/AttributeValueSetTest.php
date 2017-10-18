<?php
namespace SnowIO\FredhopperDataModel\Test;

use SnowIO\FredhopperDataModel\AttributeValue;
use SnowIO\FredhopperDataModel\AttributeValueSet;

class AttributeValueSetTest extends \PHPUnit\Framework\TestCase
{

    public function testAddingAnAttributeValue()
    {
        $red = AttributeValue::of('color', 'red');
        $blue = AttributeValue::of('color', 'blue');
        $green = AttributeValue::of('color', 'green');
        $white = AttributeValue::of('color', 'white');
        $black = AttributeValue::of('color', 'black');
        $colors = AttributeValueSet::of($colorArray = [$red, $blue, $green, $white]);
        self::assertCount(4, iterator_to_array($colors));
        $colors = $colors->withAttributeValue($black);
        $colorArray [] = $black;
        self::assertCount(5, iterator_to_array($colors));
        self::assertEquals($colorArray, iterator_to_array($colors));
    }

    public function testAddingAnAttributeSet()
    {
        $color = AttributeValue::of('color', 'red');
        $size = AttributeValue::of('size', 'large');
        $length = AttributeValue::of('length', 300);
        $weight = AttributeValue::of('weight', 80);
        $voltage = AttributeValue::of('voltage', 30);
        $attributes = AttributeValueSet::of($attributeArray = [$color, $size, $length]);
        $otherColors = AttributeValueSet::of($otherAttributeArray = [$weight, $voltage]);
        $attributes = $attributes->add($otherColors);
        $allAttributes = array_merge($attributeArray, $otherAttributeArray);
        self::assertEquals($allAttributes, iterator_to_array($attributes));
    }

    /**
     * @expectedException \Exception
     */
    public function testAddingTheSameAttributeSet()
    {
        $color = AttributeValue::of('color', 'red');
        $size = AttributeValue::of('size', 'large');
        $length = AttributeValue::of('length', 300);
        $attributes = AttributeValueSet::of($attributeArray = [$color, $size, $length]);
        $otherAttributes = AttributeValueSet::of($otherAttributeArray = [$color, $size, $length]);
        $attributes = $attributes->add($otherAttributes);
        $attributes->add($otherAttributes);
    }
}
