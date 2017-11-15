<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Test;

use SnowIO\FredhopperDataModel\CategoryData;
use SnowIO\FredhopperDataModel\InternationalizedString;

class CategoryDataTest extends \PHPUnit\Framework\TestCase
{

    public function testObjectInitialisation()
    {
        $categoryNames = InternationalizedString::create()
            ->withValue('Category 01', 'en_GB')
            ->withValue('Catégorie 01', 'fr_FR');
        $category = CategoryData::of('category01', $categoryNames);

        self::assertSame('category01', $category->getId());
        self::assertSame(null, $category->getName('de_DE'));
        self::assertSame(null, $category->getParentId());
        self::assertSame($categoryNames, $category->getNames());
    }

    /**
     * @expectedException \SnowIO\FredhopperDataModel\FredhopperDataException
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidCategoryId()
    {
        $categoryNames = InternationalizedString::create()
            ->withValue('Category 01', 'en_GB')
            ->withValue('Catégorie 01', 'fr_FR');
        CategoryData::of('01cat', $categoryNames);
    }

    /**
     * @expectedException \SnowIO\FredhopperDataModel\FredhopperDataException
     * @expectedExceptionMessage Invalid Id
     */
    public function testInvalidParentId()
    {
        $categoryNames = InternationalizedString::create()
            ->withValue('Category 01', 'en_GB')
            ->withValue('Catégorie 01', 'fr_FR');
        $category = CategoryData::of('category01', $categoryNames);
        $category->withParent('02cat');
    }

    public function testToJson()
    {
        $categoryNames = InternationalizedString::create()
            ->withValue('Category 01', 'en_GB')
            ->withValue('Catégorie 01', 'fr_FR');
        $category = CategoryData::of('category01', $categoryNames);
        $category = $category->withParent('category02');
        self::assertEquals([
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
        $attributeId = CategoryData::sanitizeId('category_01');
        self::assertEquals('category01', $attributeId);
    }
}
