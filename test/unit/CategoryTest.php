<?php
namespace SnowIO\FredhopperDataModel\Test;

use SnowIO\FredhopperDataModel\Category;
use SnowIO\FredhopperDataModel\LocalizedStringSet;

class CategoryTest extends \PHPUnit\Framework\TestCase
{

    public function testObjectInitialisation()
    {
        $categoryNames = LocalizedStringSet::create()
            ->withValue('Category 01', 'en_GB')
            ->withValue('Catégorie 01', 'fr_FR');
        $category = Category::of('category01', $categoryNames)->withTimestamp(1506951117);

        self::assertSame('category01', $category->getId());
        self::assertSame(null, $category->getName('de_DE'));
        self::assertSame(null, $category->getParentId());
        self::assertSame(1506951117, $category->getTimestamp());
        self::assertSame($categoryNames, $category->getNames());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidCategoryId()
    {
        $categoryNames = LocalizedStringSet::create()
            ->withValue('Category 01', 'en_GB')
            ->withValue('Catégorie 01', 'fr_FR');
        Category::of('01cat', $categoryNames);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidParentId()
    {
        $categoryNames = LocalizedStringSet::create()
            ->withValue('Category 01', 'en_GB')
            ->withValue('Catégorie 01', 'fr_FR');
        $category = Category::of('category01', $categoryNames);
        $category->withParent('02cat');
    }

    public function testToJson()
    {
        $categoryNames = LocalizedStringSet::create()
            ->withValue('Category 01', 'en_GB')
            ->withValue('Catégorie 01', 'fr_FR');
        $category = Category::of('category01', $categoryNames);
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
