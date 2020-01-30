<?php

namespace Swapi\Enrichment\Component\Modifier;

class SnakeCaseModifier
{
    public function modify(string $value): string
    {
        $value = preg_replace('/[^A-Za-z0-9 ]/', '', $value);
        $delimiter = '_';
        if (!ctype_lower($value)) {
            $value = str_replace('&', 'And', $value);
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $value = mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value), 'UTF-8');
        }

        return $value;
    }
}