<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Test;
use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\Command\DeleteVariantCommand;
use SnowIO\FredhopperDataModel\Command\SaveVariantCommand;
use SnowIO\FredhopperDataModel\VariantData;
use SnowIO\FredhopperDataModel\VariantDataSet;

class VariantDataSetTest extends TestCase
{
    use CommandHelper;

    public function testWithers()
    {
        $variantDataSet = VariantDataSet::of(array(
            VariantData::of('var1', 'abc123'),
            VariantData::of('var2', 'abc123'),
            VariantData::of('var3', 'abc123'),
        ));

        $variantDataSet = $variantDataSet->with(VariantData::of('var1', 'abc123'));
        self::assertTrue($variantDataSet->equals(VariantDataSet::of([
            VariantData::of('var1', 'abc123'),
            VariantData::of('var2', 'abc123'),
            VariantData::of('var3', 'abc123'),
        ])));
    }

    public function testMapToSaveCommands()
    {
        $variantDataSet = VariantDataSet::of([
            VariantData::of('var1', 'abc123'),
            VariantData::of('var2', 'abc123'),
        ]);

        $expectedEvents = [
            'var1' => SaveVariantCommand::of(VariantData::of('var1', 'abc123'))->withTimestamp(1),
            'var2' => SaveVariantCommand::of(VariantData::of('var2', 'abc123'))->withTimestamp(1),
        ];

        self::assertEquals(
            $this->getJson($expectedEvents), $this->getJson($variantDataSet->mapToSaveCommands(1))
        );
    }

    public function testMapToDeleteCommands()
    {
        $variantDataSet = VariantDataSet::of([
            VariantData::of('var1', 'abc123'),
            VariantData::of('var2', 'abc123'),
        ]);
        $expectedEvents = [
            'var1' => DeleteVariantCommand::of('var1')->withTimestamp(1),
            'var2' => DeleteVariantCommand::of('var2')->withTimestamp(1),
        ];

        self::assertEquals(
            $this->getJson($expectedEvents), $this->getJson($variantDataSet->mapToDeleteCommands(1))
        );
    }

}