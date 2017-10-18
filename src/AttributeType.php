<?php
namespace SnowIO\FredhopperDataModel;

abstract class AttributeType
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
}
