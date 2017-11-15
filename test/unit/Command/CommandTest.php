<?php
declare(strict_types = 1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\Command\Command;

class CommandTest extends TestCase
{
    public function testToJson()
    {
        /** @var Command $command */
        $command = $this->createCommand()->withTimestamp(1509530316);
        self::assertEquals([
            '@timestamp' => 1509530316,
        ], $command->toJson());

        $command = $this->createCommand();
        self::assertEquals([], $command->toJson());
    }

    public function createCommand()
    {
        $commandClass = new class extends Command {};
        return new $commandClass;
    }

}