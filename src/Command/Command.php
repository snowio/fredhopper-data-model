<?php
namespace SnowIO\FredhopperDataModel\Command;

abstract class Command
{
    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     * @return static
     */
    public function withTimestamp(int $timestamp)
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
