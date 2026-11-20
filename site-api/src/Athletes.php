<?php
declare(strict_types=1);

function validateAthlete(array $input): array
{
    $event = $input['event'] ?? null;
    if (!is_string($event) || trim($event) === '' || mb_strlen($event) > 190) {
        return [[], ['event' => 'Informe o nome do evento com até 190 caracteres.']];
    }
    $event = trim($event);
    $fields = json_decode(file_get_contents(__DIR__ . '/../schema/athlete.json'), true, 512, JSON_THROW_ON_ERROR);
    $data = [];
    $errors = [];
    foreach ($fields as $field) {
        $key = $field['key'];
        $value = $input[$key] ?? (($field['type'] ?? '') === 'boolean' ? false : '');
        if (($field['type'] ?? '') === 'boolean') {
            if (!is_bool($value)) $errors[$key] = 'Informe uma resposta válida.';
        } else {
            if ($key === 'idade' && is_int($value)) $value = (string) $value;
            if (!is_string($value)) {
                $errors[$key] = 'Informe uma resposta válida.';
                continue;
            }
            $value = trim($value);
            if (($value === '' && !($field['optional'] ?? false)) || mb_strlen($value) > $field['max']) {
                $errors[$key] = 'Preencha este campo respeitando o tamanho permitido.';
            }
        }
        $data[$key] = $value;
    }
    if ($errors) return [[], $errors];
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Informe um e-mail válido.';
    if (!ctype_digit($data['idade']) || (int) $data['idade'] > 120) $errors['idade'] = 'Informe uma idade válida.';
    $format = 'd/m/Y';
    $date = DateTimeImmutable::createFromFormat('!' . $format, $data['dataNascimento']);
    if (!$date || $date->format($format) !== $data['dataNascimento'] || $date->format('Y-m-d') < '1900-01-01' || $date->format('Y-m-d') > gmdate('Y-m-d')) {
        $errors['dataNascimento'] = 'Informe uma data de nascimento válida.';
    }
    if (!$data['estrangeiro'] && strlen(preg_replace('/\D/', '', $data['cpf'])) !== 11) $errors['cpf'] = 'Informe o CPF com 11 dígitos ou marque estrangeiro.';
    if ($data['provasAnteriores'] === '') $errors['provasAnteriores'] = 'Informe suas provas anteriores.';
    if ($data['concordaRegulamento'] !== true) $errors['concordaRegulamento'] = 'Você deve concordar com o regulamento.';
    if ($errors) return [[], $errors];
    return [[
        'event' => $event,
        'birth_date' => $date->format('Y-m-d'),
        'answers' => $data,
    ], []];
}

function saveAthlete(PDO $db, array $registration): void
{
    $data = $registration['answers'];
    $statement = $db->prepare(
        'INSERT INTO athlete_registrations (
            event_code, name, surname, email, phone, nationality, cpf, is_foreign, age,
            birth_date, previous_events, dietary_restrictions, shirt_size, modality,
            discount_code, regulations_accepted
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $statement->execute([
        $registration['event'], $data['nome'], $data['sobrenome'],
        strtolower($data['email']), $data['telefone'], $data['nacionalidade'], $data['cpf'],
        (int) $data['estrangeiro'], (int) $data['idade'], $registration['birth_date'],
        $data['provasAnteriores'], $data['restricaoAlimentar'], $data['tamanhoCamiseta'],
        $data['modalidade'], $data['cupomDesconto'], (int) $data['concordaRegulamento'],
    ]);
}

function adminAthletes(PDO $db, string $path, string $method): void
{
    if ($path === '/site-api/v1/admin/athletes' && $method === 'GET') {
        $direction = adminSortDirection();
        $page = max(1, min(1000000, (int) ($_GET['page'] ?? 1)));
        $search = $_GET['search'] ?? '';
        if (!is_string($search) || mb_strlen($search) > 180) respond(400, ['message' => 'Busca inválida.']);
        $search = trim($search);
        $modality = $_GET['modality'] ?? '';
        if (!is_string($modality) || mb_strlen($modality) > 180) respond(400, ['message' => 'Modalidade inválida.']);
        $conditions = [];
        $params = [];
        if ($search !== '') {
            $conditions[] = "(CONCAT(name, ' ', surname) LIKE ? OR email LIKE ?)";
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
        }
        if ($modality !== '') {
            $conditions[] = 'modality = ?';
            $params[] = $modality;
        }
        $where = $conditions ? ' WHERE ' . implode(' AND ', $conditions) : '';
        $query = $db->prepare('SELECT COUNT(*) FROM athlete_registrations' . $where);
        $query->execute($params);
        $total = (int) $query->fetchColumn();
        $page = min($page, max(1, (int) ceil($total / 20)));
        $query = $db->prepare("SELECT id, CONCAT(name, ' ', surname) AS name, email, phone, modality, event_code, created_at FROM athlete_registrations" . $where . " ORDER BY created_at $direction, id $direction LIMIT 20 OFFSET " . (($page - 1) * 20));
        $query->execute($params);
        $rows = $query->fetchAll();
        $modalities = $db->query('SELECT DISTINCT modality FROM athlete_registrations ORDER BY modality')->fetchAll(PDO::FETCH_COLUMN);
        respond(200, ['items' => $rows, 'total' => $total, 'page' => $page, 'page_size' => 20, 'modalities' => $modalities]);
    }
    if ($method === 'GET' && preg_match('~^/site-api/v1/admin/athletes/([1-9][0-9]*)$~D', $path, $match)) {
        $query = $db->prepare('SELECT * FROM athlete_registrations WHERE id = ?');
        $query->execute([$match[1]]);
        $row = $query->fetch();
        if (!$row) respond(404, ['message' => 'Inscrição não encontrada.']);
        $answers = [
            'nome' => $row['name'],
            'sobrenome' => $row['surname'],
            'email' => $row['email'],
            'telefone' => $row['phone'],
            'nacionalidade' => $row['nationality'],
            'cpf' => $row['cpf'],
            'estrangeiro' => (bool) $row['is_foreign'],
            'idade' => (int) $row['age'],
            'dataNascimento' => (new DateTimeImmutable($row['birth_date']))->format('d/m/Y'),
            'provasAnteriores' => $row['previous_events'],
            'restricaoAlimentar' => $row['dietary_restrictions'],
            'tamanhoCamiseta' => $row['shirt_size'],
            'modalidade' => $row['modality'],
            'cupomDesconto' => $row['discount_code'],
            'concordaRegulamento' => (bool) $row['regulations_accepted'],
        ];
        respond(200, ['registration' => [
            'id' => $row['id'],
            'name' => $row['name'] . ' ' . $row['surname'],
            'email' => $row['email'],
            'event_code' => $row['event_code'],
            'created_at' => $row['created_at'],
            'answers' => $answers,
        ]]);
    }
}
