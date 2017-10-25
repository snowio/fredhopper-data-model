<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\LocalizedString;
use SnowIO\FredhopperDataModel\InternationalizedString;

class LocalizedStringSetTest extends TestCase
{
    public function testEmptySetBehavesCorrectly()
    {
        $emptySet = InternationalizedString::create();
        self::assertSame(0, $emptySet->count());
        self::assertSame(true, $emptySet->isEmpty());
        foreach ($emptySet as $item) {
            self::fail();
        }
        self::assertTrue($emptySet->equals(InternationalizedString::create()));
        self::assertNull($emptySet->get('en_GB'));
        self::assertNull($emptySet->getValue('en_GB'));
        self::assertSame([], $emptySet->getLocales());
    }

    public function testGetExistentValue()
    {
        $set = InternationalizedString::create()->withValue('Red', 'en_GB');
        self::assertSame('Red', $set->getValue('en_GB'));
        self::assertTrue($set->get('en_GB')->equals(LocalizedString::of('Red', 'en_GB')));

        $set = InternationalizedString::create()->with(LocalizedString::of('Red', 'en_GB'));
        self::assertSame('Red', $set->getValue('en_GB'));
        self::assertTrue($set->get('en_GB')->equals(LocalizedString::of('Red', 'en_GB')));
    }

    public function testGetNonExistentValue()
    {
        $set = InternationalizedString::create()->withValue('Red', 'en_GB');
        self::assertNull($set->getValue('de_DE'));
        self::assertNull($set->get('de_DE'));
    }

    public function testReplaceValue()
    {
        $set = InternationalizedString::create()
            ->withValue('Red', 'en_GB')
            ->withValue('Red!', 'en_GB');
        self::assertSame('Red!', $set->getValue('en_GB'));
        self::assertTrue($set->get('en_GB')->equals(LocalizedString::of('Red!', 'en_GB')));

        $set = InternationalizedString::create()
            ->withValue('Red', 'en_GB')
            ->with(LocalizedString::of('Red!', 'en_GB'));
        self::assertSame('Red!', $set->getValue('en_GB'));
        self::assertTrue($set->get('en_GB')->equals(LocalizedString::of('Red!', 'en_GB')));
    }
}
