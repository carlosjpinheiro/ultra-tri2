<?php
declare(strict_types=1);
require __DIR__ . '/../site-api/src/Validation.php';
function check(bool $condition, string $message): void {
    if (!$condition) throw new RuntimeException($message);
}
$fields = json_decode(file_get_contents(__DIR__ . '/../site-api/schema/staff.json'), true);
$valid = [];
foreach ($fields as $field) {
    if (isset($field['when'])) continue;
    $valid[$field['key']] = match ($field['type']) {
        'multiple' => ($field['all'] ?? false) ? $field['options'] : [$field['options'][0]],
        'confirm' => true,
        'select' => $field['options'][0],
        'date' => '1990-02-15',
        'email' => 'staff@example.com',
        'tel' => '(21) 99999-9999',
        default => 'Resposta de teste',
    };
}
$valid['descricaoExperiencia'] = 'Apoio a atletas';
check(validateStaff($valid)[1] === [], 'Valid form rejected');
foreach (['email' => 'invalid', 'dataNascimento' => '2025-02-31', 'whatsapp' => '123', 'cienteDeslocamento' => false, 'departamentos' => ['Produção e Logística', 'Suporte aos Atletas', 'Cozinha e Alimentação'], 'confirmacoes' => [], 'camiseta' => 'XXL', 'nome' => ['invalid']] as $key => $value) {
    $bad = $valid; $bad[$key] = $value;
    check(isset(validateStaff($bad)[1][$key]), "Invalid $key accepted");
}
$bad = $valid; unset($bad['descricaoExperiencia']);
check(isset(validateStaff($bad)[1]['descricaoExperiencia']), 'Missing experience accepted');
$bad = $valid; $bad['departamentos'] = ['Marketing e Produção de Conteúdo'];
check(isset(validateStaff($bad)[1]['marketing']), 'Missing marketing answer accepted');
$bad['marketing'] = ['Fotografia'];
check(validateStaff($bad)[1] === [], 'Valid marketing rejected');
$bad['marketing'] = [['nested']];
check(isset(validateStaff($bad)[1]['marketing']), 'Nested option accepted');
$bad = $valid; $bad['experienciaEventos'] = 'Não'; $bad['descricaoExperiencia'] = 'stale'; $bad['injected'] = 'ignored';
$clean = validateStaff($bad)[0];
check(!isset($clean['descricaoExperiencia']) && !isset($clean['injected']), 'Unexpected answers persisted');
echo "Staff validation tests passed.\n";
