<?php
namespace SnowIO\FredhopperDataModel;

use function SnowIO\FredhopperDataModel\Internal\validateLocale;

class Category extends Entity
{
    public static function of(string $id, array $names): self
    {
        self::validateId($id);
        foreach ($names as $locale => $name) {
            validateLocale($locale);
        }
        $category = new self;
        $category->id = $id;
        $category->names = $names;
        return $category;
    }

    public static function sanitizeId(string $id): string
    {
        $id = \strtolower($id);
        $id = \preg_replace('/[^a-z0-9]/', '', $id);
        return $id;
    }

    public static function validateId($id)
    {
        if (!\preg_match('{^[a-z][a-z0-9_]+$}', $id)) {
            throw new \Exception('Invalid Id');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNames(): array
    {
        return $this->names;
    }

    public function getName(string $locale): ?string
    {
        validateLocale($locale);
        return $this->names[$locale] ?? null;
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function withParent(string $parentId): self
    {
        self::validateId($parentId);
        $category = clone $this;
        $category->parentId = $parentId;
        return $category;
    }

    public function toJson(): array
    {
        $json = parent::toJson();
        $json['category_id'] = $this->id;
        $json['names'] = $this->names;
        $json['parent_id'] = $this->parentId;
        return $json;
    }

    private $id;
    private $parentId;
    private $names;

    private function __construct()
    {
    }
}
