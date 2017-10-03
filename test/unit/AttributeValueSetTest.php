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

}