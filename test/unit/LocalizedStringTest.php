<?php
namespace SnowIO\FredhopperDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\FredhopperDataModel\LocalizedString;

class LocalizedStringTest extends TestCase
{
    public function testValidObjectConstruction()
    {
        $localizedString = LocalizedString::of('Hello!', 'en_GB');
        self::assertSame('Hello!', $localizedString->getValue());
        self::assertSame('en_GB', $localizedString->getLocale());
    }

    /**
     * @expectedException \Exception
     */
    public function testInvalidLocaleThrows()
    {
        LocalizedString::of('Foo', 'en_FR');
    }

    public function testEquals()
    {
        $localizedString1 = LocalizedString::of('Hello!', 'en_GB');
        $localizedString2 = LocalizedString::of('Hello!', 'en_GB');
        $localizedString3 = LocalizedString::of('Hello!', 'de_DE');
        $localizedString4 = LocalizedString::of('Hello', 'en_GB');
        self::assertTrue($localizedString1->equals($localizedString2));
        self::assertFalse($localizedString1->equals($localizedString3));
        self::assertFalse($localizedString1->equals($localizedString4));
    }
}
