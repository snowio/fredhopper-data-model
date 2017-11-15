<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\Command\DeleteVariantCommand;

class DeleteVariantCommandTest extends TestCase
{

    public function testToJson()
    {
        $command = DeleteVariantCommand::of('snowio_test_variant')->withTimestamp(1510744232);
        self::assertEquals([
            '@timestamp' => 1510744232,
            'variant_id' => 'snowio_test_variant',
        ], $command->toJson());
    }

    public function testAccessors()
    {
        $command = DeleteVariantCommand::of('snowio_test_variant');
        self::assertEquals('snowio_test_variant', $command->getVariantId());
    }
}
