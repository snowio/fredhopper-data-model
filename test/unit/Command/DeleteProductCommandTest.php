<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Test;
use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\Command\DeleteProductCommand;

class DeleteProductCommandTest extends TestCase
{
    public function testToJson()
    {
        $command = DeleteProductCommand::of('snowio_test_product')->withTimestamp(1510744232);
        self::assertEquals([
            '@timestamp' => 1510744232,
            'product_id' => 'snowio_test_product'
        ], $command->toJson());
    }

    public function testAccessor()
    {
        $command = DeleteProductCommand::of('snowio_test_product');
        self::assertEquals('snowio_test_product', $command->getProductId());
    }
}