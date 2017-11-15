<?php
declare(strict_types = 1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\CategoryData;
use SnowIO\FredhopperDataModel\CategoryDataSet;
use SnowIO\FredhopperDataModel\Command\DeleteCategoryCommand;
use SnowIO\FredhopperDataModel\Command\SaveCategoryCommand;
use SnowIO\FredhopperDataModel\InternationalizedString;
use SnowIO\FredhopperDataModel\LocalizedString;

class CategoryDataSetTest extends TestCase
{
    use CommandHelper;

    public function testWithers()
    {
        $categoryDataSet = CategoryDataSet::of([
            CategoryData::of('mensshoes', InternationalizedString::of([
                LocalizedString::of('Men\'s Shoes', 'en_GB'),
            ])),
            CategoryData::of('mensshirts', InternationalizedString::of([
                LocalizedString::of('Men\'s Shirts', 'en_GB'),
            ])),
            CategoryData::of('mensunderware', InternationalizedString::of([
                LocalizedString::of('Men\'s Underware', 'en_GB'),
            ])),
        ]);

        $categoryDataSet = $categoryDataSet->with(CategoryData::of('menswatches',
            InternationalizedString::of([LocalizedString::of('Men\'s Watches', 'en_GB')])));
        self::assertTrue($categoryDataSet->equals(CategoryDataSet::of([
            CategoryData::of('mensshoes', InternationalizedString::of([
                LocalizedString::of('Men\'s Shoes', 'en_GB'),
            ])),
            CategoryData::of('mensshirts', InternationalizedString::of([
                LocalizedString::of('Men\'s Shirts', 'en_GB'),
            ])),
            CategoryData::of('mensunderware', InternationalizedString::of([
                LocalizedString::of('Men\'s Underware', 'en_GB'),
            ])),
            CategoryData::of('menswatches',
                InternationalizedString::of([LocalizedString::of('Men\'s Watches', 'en_GB')])),
        ])));

        $categoryDataSet = $categoryDataSet->with(CategoryData::of('mensunderware',
            InternationalizedString::of([LocalizedString::of('Men\'s Briefs', 'en_GB')])));
        self::assertTrue($categoryDataSet->equals(CategoryDataSet::of([
            CategoryData::of('mensshoes', InternationalizedString::of([
                LocalizedString::of('Men\'s Shoes', 'en_GB'),
            ])),
            CategoryData::of('mensshirts', InternationalizedString::of([
                LocalizedString::of('Men\'s Shirts', 'en_GB'),
            ])),
            CategoryData::of('mensunderware', InternationalizedString::of([
                LocalizedString::of('Men\'s Briefs', 'en_GB'),
            ])),
            CategoryData::of('menswatches',
                InternationalizedString::of([LocalizedString::of('Men\'s Watches', 'en_GB')])),
        ])));
    }

    public function testMapToSaveCommand()
    {
        $categoryDataSet = CategoryDataSet::of([
            CategoryData::of('mensshoes', InternationalizedString::of([LocalizedString::of('Men\'s Shoes', 'en_GB')])),
            CategoryData::of('mensshirts',
                InternationalizedString::of([LocalizedString::of('Men\'s Shirts', 'en_GB')])),
        ]);

        $expectedSet = [
            'mensshoes' => SaveCategoryCommand::of(CategoryData::of('mensshoes',
                InternationalizedString::of([LocalizedString::of('Men\'s Shoes', 'en_GB')])))->withTimestamp(1),
            'mensshirts' => SaveCategoryCommand::of(CategoryData::of('mensshirts',
                InternationalizedString::of([LocalizedString::of('Men\'s Shirts', 'en_GB')])))->withTimestamp(1),
        ];

        self::assertEquals($this->getJson($expectedSet), $this->getJson($categoryDataSet->mapToSaveCommands(1)));
    }

    public function testMapToDeleteCommand()
    {
        $categoryDataSet = CategoryDataSet::of([
            CategoryData::of('mensshoes', InternationalizedString::of([LocalizedString::of('Men\'s Shoes', 'en_GB')])),
            CategoryData::of('mensshirts', InternationalizedString::of([LocalizedString::of('Men\'s Shirts', 'en_GB')])),
        ]);

        $expectedSet = [
            'mensshoes' => DeleteCategoryCommand::of('mensshoes')->withTimestamp(1),
            'mensshirts' => DeleteCategoryCommand::of('mensshirts')->withTimestamp(1),
        ];

        self::assertEquals($this->getJson($expectedSet), $this->getJson($categoryDataSet->mapToDeleteCommands(1)));
    }
}
