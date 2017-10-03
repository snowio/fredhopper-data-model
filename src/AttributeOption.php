<?php
namespace SnowIO\FredhopperDataModel;

class AttributeOption extends Entity
{
    public static function of(string $optionId, string $attributeId, array $labels): self
    {
        $attributeOption = new self;
        $attributeOption->optionId = $optionId;
        $attributeOption->labels = $labels;
        return $attributeOption;
    }

    public function getOptionId(): string
    {
        return $this->optionId;
    }

    public function getAttributeId(): string
    {
    }

    public function getLabels(): array
    {
        return $this->labels;
    }

    public function getLabel($locale): ?string
    {
        return $this->labels[$locale] ?? null;
    }

    public function toJson(): array
    {
        $json = parent::toJson();
        $json['option_id'] = $this->optionId;
        $json['labels'] = $this->labels;
        return $json;
    }

    private $optionId;
    private $labels;

    private function __construct()
    {
    }
}
