<?php
namespace SnowIO\FredhopperDataModel;

use function SnowIO\FredhopperDataModel\Internal\sanitizeId;
use function SnowIO\FredhopperDataModel\Internal\validateId;

final class Attribute
{
    public static function of(string $id, string $type, LocalizedStringSet $names): self
    {
        validateId($id);
        AttributeType::validate($type);
        if ($names->isEmpty()) {
            throw new \Exception('A name must be provided for at least one locale.');
        }
        $attribute = new self;
        $attribute->id = $id;
        $attribute->type = $type;
        $attribute->names = $names;
        return $attribute;
    }

    public static function sanitizeId(string $id): string
    {
        return sanitizeId($id);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getNames(): LocalizedStringSet
    {
        return $this->names;
    }

    public function getName(string $locale): ?string
    {
        return $this->names->getValue($locale);
    }

    public function equals($other): bool
    {
        return $other instanceof Attribute
            && $this->id === $other->id
            && $this->type === $other->type
            && $this->names->equals($other->names);
    }

    public function toJson(): array
    {
        return [
            'attribute_id' => $this->id,
            'type' => $this->type,
            'names' => $this->names->toJson(),
        ];
    }

    private $id;
    private $type;
    /** @var LocalizedStringSet */
    private $names;

    private function __construct()
    {
    }
}
