<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel;

final class AttributeType
{
    const FLOAT = 'float';
    const INT = 'int';
    const TEXT = 'text';
    const LIST = 'list';
    const SET = 'set';
    const ASSET = 'asset';
    const DATETIME = 'datetime';

    const ALL = [
        self::FLOAT,
        self::INT,
        self::TEXT,
        self::LIST,
        self::SET,
        self::ASSET,
        self::DATETIME
    ];

    public static function isValid(string $type): bool
    {
        return \in_array($type, self::ALL);
    }

    public static function validate(string $type): void
    {
        if (!\in_array($type, self::ALL)) {
            throw new FredhopperDataException('Invalid Type');
        }
    }

    private function __construct()
    {

    }
}
