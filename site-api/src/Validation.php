<?php
declare(strict_types=1);

function validateStaff(array $input): array
{
    $fields = json_decode(file_get_contents(__DIR__ . '/../schema/staff.json'), true, 512, JSON_THROW_ON_ERROR);
    $data = [];
    $errors = [];
    foreach ($fields as $field) {
        $key = $field['key'];
        if (isset($field['when'])) {
            $dependency = $input[$field['when']['key']] ?? null;
            $visible = is_array($dependency) ? in_array($field['when']['value'], $dependency, true) : $dependency === $field['when']['value'];
            if (!$visible) continue;
        }
        $value = $input[$key] ?? null;
        $valid = true;
        if ($field['type'] === 'multiple') {
            $valid = is_array($value) && array_is_list($value) && count($value) > 0;
            if ($valid) {
                foreach ($value as $option) {
                    if (!is_string($option) || !in_array($option, $field['options'], true)) $valid = false;
                }
                if ($valid && count(array_unique($value)) !== count($value)) $valid = false;
                if (count($value) > ($field['limit'] ?? count($field['options']))) $valid = false;
                if (($field['all'] ?? false) && count($value) !== count($field['options'])) $valid = false;
            }
        } elseif ($field['type'] === 'confirm') {
            $valid = $value === true;
        } else {
            $valid = is_string($value);
            if ($valid) {
                $value = trim($value);
                $valid = ($value !== '' || ($field['optional'] ?? false)) && mb_strlen($value) <= ($field['max'] ?? 500);
                if ($field['type'] === 'select') $valid = in_array($value, $field['options'], true);
                if ($field['type'] === 'email') $valid = filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                if ($field['type'] === 'tel') {
                    $digits = preg_replace('/\D/', '', $value);
                    $valid = preg_match('/^\+?[\d\s().-]+$/D', $value) === 1 && strlen($digits) >= 10 && strlen($digits) <= 15;
                }
                if ($field['type'] === 'date') {
                    $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
                    $valid = $date && $date->format('Y-m-d') === $value && $value >= '1900-01-01' && $value <= gmdate('Y-m-d');
                }
            } elseif (($field['optional'] ?? false) && $value === null) {
                $valid = true;
                $value = '';
            }
        }
        if (!$valid) $errors[$key] = 'Preencha este campo com uma resposta válida' . (isset($field['limit']) ? ' (até ' . $field['limit'] . ' opções).' : '.');
        else $data[$key] = $value;
    }
    return [$data, $errors];
}
