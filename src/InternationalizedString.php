<?php
declare(strict_types=1);
namespace SnowIO\FredhopperDataModel;

final class InternationalizedString implements \IteratorAggregate
{
    use SetTrait;

    public function get(string $locale): ?LocalizedString
    {
        if (!isset($this->items[$locale])) {
            Locale::validate($locale);
            return null;
        }
        return $this->items[$locale];
    }

    public function with(LocalizedString $localizedString): self
    {
        $set = clone $this;
        $set->items[$localizedString->getLocale()] = $localizedString;
        return $set;
    }

    public function getValue(string $locale): ?string
    {
        if (!isset($this->items[$locale])) {
            Locale::validate($locale);
            return null;
        }
        return $this->items[$locale]->getValue();
    }

    public function withValue(string $value, string $locale): self
    {
        return $this->with(LocalizedString::of($value, $locale));
    }

    public function getLocales(): array
    {
        return \array_keys($this->items);
    }

    public function toJson(): array
    {
        return \array_map(
            function (LocalizedString $localizedString) {
                return $localizedString->getValue();
            },
            $this->items
        );
    }

    /** @var LocalizedString[] */
    private $items = [];

    private static function getKey(LocalizedString $localizedString): string
    {
        return $localizedString->getLocale();
    }

    private static function itemsAreEqual(LocalizedString $item1, LocalizedString $item2): bool
    {
        return $item1->equals($item2);
    }
}
