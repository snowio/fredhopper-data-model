<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeValue;
use SnowIO\FredhopperDataModel\AttributeValueSet;
use SnowIO\FredhopperDataModel\VariantData;

class VariantTest extends TestCase
{
    public function testObjectInitialisation()
    {
        $attributeValue = AttributeValue::of('no_of_pairs', 2);
        $attributeValueSet = AttributeValueSet::of([$attributeValue]);
        $variant = VariantData::of('acme_red_wool_socks', 'acme_wool_socks')
            ->withAttributeValues($attributeValueSet);
        self::assertEquals('acme_red_wool_socks', $variant->getId());
        self::assertEquals('acme_wool_socks', $variant->getProductId());
        self::assertEquals([$attributeValue], iterator_to_array($variant->getAttributeValues()));
    }

    /**
     * @expectedException \SnowIO\FredhopperDataModel\FredhopperDataException
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidVariantId()
    {
        VariantData::of('$acme$wool$socks', 'acme_wool_socks');
    }

    /**
     * @expectedException \SnowIO\FredhopperDataModel\FredhopperDataException
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidProductId()
    {
        VariantData::of('acme_wool_socks', 'acme$wool$socks');
    }

    public function testToJson()
    {
        $attributeValue = AttributeValue::of('no_of_pairs', 2);
        $attributeValueSet = AttributeValueSet::of([$attributeValue]);
        $variant = VariantData::of('acme_red_wool_socks', 'acme_wool_socks')
            ->withAttributeValues($attributeValueSet);

        self::assertEquals([
            'variant_id' => 'acme_red_wool_socks',
            'product_id' => 'acme_wool_socks',
            'attribute_values' => [
                'no_of_pairs' => 2
            ],
        ], $variant->toJson());
    }

    public function testSanitization()
    {
        $attributeId = VariantData::sanitizeId('variant#01-38927');
        self::assertEquals('variant_01_38927', $attributeId);
    }

    /**
     * @expectedException \SnowIO\FredhopperDataModel\FredhopperDataException
     */
    public function testVariantIdSameAsProductIdThrows()
    {
        VariantData::of('foo', 'foo');
    }

    public function testEquals()
    {
        $product1 = VariantData::of('foo', 'bar')
            ->withAttributeValue(AttributeValue::of('colour', 'red'));
        $product2 = VariantData::of('foo', 'bar')
            ->withAttributeValue(AttributeValue::of('colour', 'red'));
        self::assertTrue($product1->equals($product2));
        $product3 = VariantData::of('foo', 'baz')
            ->withAttributeValue(AttributeValue::of('colour', 'red'));
        self::assertFalse($product1->equals($product3));
    }
}
