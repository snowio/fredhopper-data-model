<?php
namespace SnowIO\FredhopperDataModel\Test;

use Exception;
use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeValue;
use SnowIO\FredhopperDataModel\AttributeValueSet;
use SnowIO\FredhopperDataModel\CategoryIdSet;
use SnowIO\FredhopperDataModel\Product;

class ProductTest extends TestCase
{
    public function testObjectInitialisation()
    {
        $categoryIds = CategoryIdSet::of(['books', 'fiction', 'sci_fi']);
        $attributeValueSet = AttributeValueSet::create()->with(AttributeValue::of('no_of_pages', 33));
        $product = Product::of('an_v2783')
            ->withCategoryIds($categoryIds)
            ->withAttributeValues($attributeValueSet)
            ->withTimestamp(1506951117);
        self::assertSame('an_v2783', $product->getId());
        self::assertSame($categoryIds, $product->getCategoryIds());
        self::assertSame(1506951117, $product->getTimestamp());
        self::assertSame($attributeValueSet, $product->getAttributeValues());
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidProductId()
    {
        Product::of('$0i0ifjgo', CategoryIdSet::of(['books', 'fiction', 'sci_fi']));
    }

    public function testToJson()
    {
        $categoryIds = CategoryIdSet::of(['books', 'fiction', 'sci_fi']);
        $attributeValueSet = AttributeValueSet::create()->with(AttributeValue::of('no_of_pages', 33));
        $product = Product::of('an_v2783')
            ->withCategoryIds($categoryIds)
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

    public function testEquals()
    {
        $product1 = Product::of('foo', CategoryIdSet::of(['bar', 'baz']))
            ->withAttributeValue(AttributeValue::of('colour', 'red'));
        $product2 = Product::of('foo', CategoryIdSet::of(['bar', 'baz']))
            ->withAttributeValue(AttributeValue::of('colour', 'red'));
        self::assertTrue($product1->equals($product2));
        $product3 = $product1->withCategoryId('wibble');
        self::assertFalse($product1->equals($product3));
    }
}
