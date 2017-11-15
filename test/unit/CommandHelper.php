<?php
namespace SnowIO\FredhopperDataModel\Test;
use SnowIO\FredhopperDataModel\Command\Command;
trait CommandHelper
{
    private function getJson(array $commands): array
    {
        return \array_map(function (Command $command) {
            return $command->toJson();
        }, $commands);
    }
}