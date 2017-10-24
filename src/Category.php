<?php
namespace SnowIO\FredhopperDataModel;

final class Category
{
    public static function of(string $id, LocalizedStringSet $names): self
    {
        self::validateId($id);
        if ($names->isEmpty()) {
            throw new \Exception('A name must be provided for at least one locale.');
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

    public static function validateId(string $id): void
    {
        if (!\preg_match('{^[a-z][a-z0-9_]+$}', $id)) {
            throw new \Exception('Invalid Id');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNames(): LocalizedStringSet
    {
        return $this->names;
    }

    public function getName(string $locale): ?string
    {
        return $this->names->getValue($locale);
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

    public function equals($other): bool
    {
        return $other instanceof Category
            && $this->id === $other->id
            && $this->parentId === $other->parentId
            && $this->names->equals($other->names);
    }

    public function toJson(): array
    {
        return [
            'category_id' => $this->id,
            'parent_id' => $this->parentId,
            'names' => $this->names->toJson(),
        ];
    }

    private $id;
    private $parentId;
    /** @var LocalizedStringSet */
    private $names;

    private function __construct()
    {
    }
}
