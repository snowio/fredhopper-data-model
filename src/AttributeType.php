<?php
namespace SnowIO\FredhopperDataModel;

final class AttributeType
{
    const FLOAT = 'float';
    const INT = 'int';
    const TEXT = 'text';
    const LIST = 'list';
    const SET = 'set';
    const ASSET = 'asset';

    const ALL = [
        self::FLOAT,
        self::INT,
        self::TEXT,
        self::LIST,
        self::SET,
        self::ASSET,
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
