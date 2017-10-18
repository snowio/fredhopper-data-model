<?php
namespace SnowIO\FredhopperDataModel;

final class AttributeType
{
    const FLOAT = 'float';
    const INT = 'int';
    const TEXT = 'text';
    const LIST = 'list';
    const SET = 'set';

    const ALL = [
        self::FLOAT,
        self::INT,
        self::TEXT,
        self::LIST,
        self::SET,
    ];

    public static function validate(string $type): void
    {
        $all = self::ALL;
        if (!in_array($type, $all)) {
            throw new \Exception('Invalid Type');
        }
    }

    private function __construct()
    {

    }
}
