<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\Command\SaveVariantCommand;
use SnowIO\FredhopperDataModel\VariantData;

class SaveVariantCommandTest extends TestCase
{
    public function testToJson()
    {
        $command = SaveVariantCommand::of(VariantData::of('var_1', 'snowio_test_product'))->withTimestamp(1510744232);
        self::assertEquals([
            '@timestamp' => 1510744232,
            'variant_id' => 'var_1',
            'product_id' => 'snowio_test_product',
        ], $command->toJson());
    }

    public function testAccessor()
    {
        $command = SaveVariantCommand::of(VariantData::of('var_1', 'snowio_test_product'));
        self::assertTrue(VariantData::of('var_1', 'snowio_test_product')->equals($command->getVariantData()));
    }
}
