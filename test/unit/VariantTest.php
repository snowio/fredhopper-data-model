<?php
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeValue;
use SnowIO\FredhopperDataModel\AttributeValueSet;
use SnowIO\FredhopperDataModel\Variant;

class VariantTest extends TestCase
{
    public function testObjectInitialisation()
    {
        $attributeValue = AttributeValue::of('no_of_pairs', 2);
        $attributeValueSet = AttributeValueSet::of([$attributeValue]);
        $variant = Variant::of('acme_red_wool_socks', 'acme_wool_socks')
            ->withTimestamp(1506951117)
            ->withAttributeValues($attributeValueSet);
        self::assertEquals('acme_red_wool_socks', $variant->getVariantId());
        self::assertEquals('acme_wool_socks', $variant->getProductId());
        self::assertEquals([$attributeValue], iterator_to_array($variant->getAttributeValues()));
        self::assertEquals(1506951117, $variant->getTimestamp());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidVariantId()
    {
        Variant::of('$acme$wool$socks', 'acme_wool_socks');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidProductId()
    {
        Variant::of('acme_wool_socks', 'acme$wool$socks');
    }

    public function testToJson()
    {
        $attributeValue = AttributeValue::of('no_of_pairs', 2);
        $attributeValueSet = AttributeValueSet::of([$attributeValue]);
        $variant = Variant::of('acme_red_wool_socks', 'acme_wool_socks')
            ->withAttributeValues($attributeValueSet)
            ->withTimestamp(1506951117);

        self::assertEquals([
            '@timestamp' => 1506951117,
            'variant_id' => 'acme_red_wool_socks',
            'product_id' => 'acme_wool_socks',
            'attribute_values' => [
                'no_of_pairs' => 2
            ],
        ], $variant->toJson());
    }

    public function testSanitization()
    {
        $attributeId = Variant::sanitizeId('variant#01-38927');
        self::assertEquals('variant_01_38927', $attributeId);
    }
}