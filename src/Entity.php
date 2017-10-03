<?php
namespace SnowIO\FredhopperDataModel;

abstract class Entity
{
    public function getTimestamp(): int
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
        return [
            '@timestamp' => $this->timestamp,
        ];
    }

    private $timestamp = 0;
}
