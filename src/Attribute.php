<?php
namespace SnowIO\FredhopperDataModel;

class Attribute extends Entity
{
    public static function of(string $id, string $type, array $names): self
    {
        validateId($id);
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

    public function getNames(): array
    {
        return $this->names;
    }

    public function getName(string $locale): ?string
    {
        return $this->names[$locale] ?? null;
    }

    public function toJson(): array
    {
        $json = parent::toJson();
        $json['attribute_id'] = $this->id;
        $json['type'] = $this->type;
        $json['names'] = $this->names;
        return $json;
    }

    private $id;
    private $type;
    private $names;

    private function __construct()
    {
    }
}
