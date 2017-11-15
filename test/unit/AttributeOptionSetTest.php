<?php
declare(strict_types = 1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\AttributeOption;
use SnowIO\FredhopperDataModel\AttributeOptionSet;
use SnowIO\FredhopperDataModel\Command\DeleteAttributeOptionCommand;
use SnowIO\FredhopperDataModel\Command\SaveAttributeOptionCommand;

class AttributeOptionSetTest extends TestCase
{
    use CommandHelper;

    public function testWithers()
    {
        $attributeOptionSet = AttributeOptionSet::of([
            AttributeOption::of('size', 'large'),
            AttributeOption::of('color', 'blue'),
            AttributeOption::of('material', 'mahogany')
        ]);

        $attributeOptionSet = $attributeOptionSet->with(AttributeOption::of('terrain', 'woodland'));
        self::assertTrue($attributeOptionSet->equals(AttributeOptionSet::of([
            AttributeOption::of('size', 'large'),
            AttributeOption::of('color', 'blue'),
            AttributeOption::of('material', 'mahogany'),
            AttributeOption::of('terrain', 'woodland')
        ])));

        $attributeOptionSet = $attributeOptionSet->with(AttributeOption::of('terrain', 'tundra'));
        self::assertTrue($attributeOptionSet->equals(AttributeOptionSet::of([
            AttributeOption::of('size', 'large'),
            AttributeOption::of('color', 'blue'),
            AttributeOption::of('material', 'mahogany'),
            AttributeOption::of('terrain', 'woodland'),
            AttributeOption::of('terrain', 'tundra')
        ])));
    }

    public function testMapToSaveCommand()
    {
        $attributeOptionSet = AttributeOptionSet::of([
            AttributeOption::of('size', 'large'),
            AttributeOption::of('color', 'blue'),
        ]);

        $expectedCommands = [
            'size-large' => SaveAttributeOptionCommand::of(AttributeOption::of('size', 'large'))->withTimestamp(1),
            'color-blue' => SaveAttributeOptionCommand::of(AttributeOption::of('color', 'blue'))->withTimestamp(1),
        ];

        self::assertEquals($this->getJson($expectedCommands),
            $this->getJson($attributeOptionSet->mapToSaveCommands(1)));
    }

    public function testMapToDeleteCommand()
    {
        $attributeOptionSet = AttributeOptionSet::of([
            AttributeOption::of('size', 'large'),
            AttributeOption::of('color', 'blue'),
        ]);

        $expectedCommands = [
            'size-large' => DeleteAttributeOptionCommand::of('size','large')->withTimestamp(1),
            'color-blue' => DeleteAttributeOptionCommand::of('color','blue')->withTimestamp(1),
        ];

        self::assertEquals($this->getJson($expectedCommands), $this->getJson($attributeOptionSet->mapToDeleteCommands(1)));
    }

}