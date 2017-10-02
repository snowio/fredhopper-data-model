<?php
namespace SnowIO\FredhopperDataModel\Test;

use SnowIO\FredhopperDataModel\Category;

class CategoryTest extends \PHPUnit\Framework\TestCase
{

    public function testObjectInitialisation()
    {
        $category = Category::of('category01', [
            'en_GB' => 'Category 01',
            'fr_FR' => 'Catégorie 01',
        ]);

        self::assertEquals('category01', $category->getId());
        self::assertEquals(null, $category->getName('de_DE'));
        self::assertEquals(null, $category->getParentId());
        self::assertEquals([
            'en_GB' => 'Category 01',
            'fr_FR' => 'Catégorie 01',
        ], $category->getNames());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidCategoryId()
    {
        Category::of('01cat', [
            'en_GB' => 'Category 01',
            'fr_FR' => 'Catégorie 01',
        ]);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidParentId()
    {
        $category = Category::of('category01', [
            'en_GB' => 'Category 01',
            'fr_FR' => 'Catégorie 01',
        ]);
        $category->withParent('02cat');
    }

    public function testToJson()
    {
        $category = Category::of('category01', [
            'en_GB' => 'Category 01',
            'fr_FR' => 'Catégorie 01',
        ]);
        $category = $category->withParent('category02');
        $category = $category->withTimestamp(1506951117);
        self::assertEquals([
            '@timestamp' => 1506951117,
            'category_id' => 'category01',
            'parent_id' => 'category02',
            'names'=> [
                'en_GB' => 'Category 01',
                'fr_FR' => 'Catégorie 01',
            ],
        ], $category->toJson());
    }

    public function testSanitisation()
    {
        $attributeId = Category::sanitizeId('category_01');
        self::assertEquals('category01', $attributeId);
    }
}
