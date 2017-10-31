<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Command;

abstract class Command
{
    public function getTimestamp(): ?float
    {
        return $this->timestamp;
    }

    /**
     * @return static
     */
    public function withTimestamp(float $timestamp)
    {
        $entity = clone $this;
        $entity->timestamp = $timestamp;
        return $entity;
    }

    public function toJson(): array
    {
        if (isset($this->timestamp)) {
            return [
                '@timestamp' => $this->timestamp,
            ];
        }
        return [];
    }

    private $timestamp;
}
