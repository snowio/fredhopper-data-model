<?php

namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\Command\DeleteProductCommand;
use SnowIO\FredhopperDataModel\Command\SaveProductCommand;
use SnowIO\FredhopperDataModel\ProductData;
use SnowIO\FredhopperDataModel\ProductDataSet;

class ProductDataSetTest extends TestCase
{
    use CommandHelper;

    public function testWithers()
    {
        $productDataSet = ProductDataSet::of([
            ProductData::of('acmetshirt'),
            ProductData::of('acmetrousers'),
            ProductData::of('acmeleggings'),
            ProductData::of('acmeties'),
        ]);

        $productDataSet = $productDataSet->with(ProductData::of('acmesocks'));
        self::assertTrue($productDataSet->equals(ProductDataSet::of([
            ProductData::of('acmetshirt'),
            ProductData::of('acmetrousers'),
            ProductData::of('acmeleggings'),
            ProductData::of('acmeties'),
            ProductData::of('acmesocks'),
        ])));
    }

    public function testMapToSaveCommands()
    {
        $productDataSet = ProductDataSet::of([
            ProductData::of('acmetshirt'),
            ProductData::of('acmetrousers'),
        ]);

        $expectedEvents = [
            'acmetshirt' => SaveProductCommand::of(ProductData::of('acmetshirt'))->withTimestamp(1),
            'acmetrousers' => SaveProductCommand::of(ProductData::of('acmetrousers'))->withTimestamp(1),
        ];

        self::assertEquals(
            $this->getJson($expectedEvents), $this->getJson($productDataSet->mapToSaveCommands(1))
        );
    }

    public function testMapToDeleteCommand()
    {
        $productDataSet = ProductDataSet::of([
            ProductData::of('acmetshirt'),
            ProductData::of('acmetrousers'),
        ]);

        $expectedEvents = [
            'acmetshirt' => DeleteProductCommand::of('acmetshirt')->withTimestamp(1),
            'acmetrousers' => DeleteProductCommand::of('acmetrousers')->withTimestamp(1),
        ];

        self::assertEquals(
            $this->getJson($expectedEvents), $this->getJson($productDataSet->mapToDeleteCommands(1))
        );
    }
}