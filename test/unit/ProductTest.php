<?php
namespace SnowIO\FredhopperDataModel\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeValue;
use SnowIO\FredhopperDataModel\AttributeValueSet;
use SnowIO\FredhopperDataModel\Product;

class ProductTest extends TestCase
{
    public function testObjectInitialisation()
    {
        $attributeValue = AttributeValue::of('no_of_pages', 33);
        $attributeValueSet = AttributeValueSet::of([$attributeValue]);
        $product = Product::of('an_v2783', ['books', 'fiction', 'sci_fi',])
            ->withAttributeValues($attributeValueSet)
            ->withTimestamp(1506951117);
        self::assertEquals('an_v2783', $product->getId());
        self::assertEquals(['books', 'fiction', 'sci_fi',], $product->getCategoryIds());
        self::assertEquals(1506951117, $product->getTimestamp());
        self::assertEquals([$attributeValue], iterator_to_array($product->getAttributeValues()));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidProductId()
    {
        Product::of('$0i0ifjgo', ['books', 'fiction', 'sci_fi',]);
    }

    public function testToJson()
    {
        $attributeValue = AttributeValue::of('no_of_pages', 33);
        $attributeValueSet = AttributeValueSet::of([$attributeValue]);
        $product = Product::of('an_v2783', ['books', 'fiction', 'sci_fi',])
            ->withTimestamp(1506951117)
            ->withAttributeValues($attributeValueSet);
        self::assertEquals([
            '@timestamp' => 1506951117,
            'product_id' => 'an_v2783',
            'category_ids' => [
                'books', 'fiction', 'sci_fi',
            ],
            'attribute_values' => [
                'no_of_pages' => 33,
            ],
        ], $product->toJson());
    }

    public function testSanitization()
    {
        $attributeId = Product::sanitizeId('product#01-38927');
        self::assertEquals('product_01_38927', $attributeId);
    }
}
