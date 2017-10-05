<?php
namespace SnowIO\FredhopperDataModel;

function validateId(string $id)
{
    if (!\preg_match('{^[a-z0-9_]+$}', $id)) {
        throw new \Exception('Invalid Id');
    }
}

function sanitizeId(string $id): string
{
    $id = \strtolower($id);
    $id = \preg_replace('/[^a-z0-9\_]/', '_', $id);
    $id = \trim($id, '_');
    return $id;
}
