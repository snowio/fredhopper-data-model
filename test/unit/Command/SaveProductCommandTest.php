<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Test;
use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\Command\SaveProductCommand;
use SnowIO\FredhopperDataModel\ProductData;

class SaveProductCommandTest extends TestCase
{
    public function testToJson()
    {
        $command = SaveProductCommand::of(ProductData::of('snowio_test_product'))->withTimestamp(1510744232);
        self::assertEquals([
            '@timestamp' => 1510744232,
            'product_id' => 'snowio_test_product',
            'category_ids' => [],
        ], $command->toJson());
    }

    public function testAccessors()
    {
        $command = SaveProductCommand::of(ProductData::of('snowio_test_product'));
        self::assertTrue(ProductData::of('snowio_test_product')->equals($command->getProductData()));
    }

}