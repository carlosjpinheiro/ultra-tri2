# Inscrição de staffs 2027

Página `/staff`, acessível no menu **Seja Staff 2027**, conforme páginas 6–8 da especificação. Usa os componentes Vuetify e o tema dos formulários existentes. Instagram e informações adicionais são opcionais; experiência anterior e atividades de marketing são exigidas apenas quando aplicáveis. Os demais campos são obrigatórios. A disponibilidade aceita múltiplas opções; departamentos aceitam até duas; todas as confirmações são necessárias.

## Isolamento

- PHP 8.2+ com `pdo_mysql`, `mbstring` e Apache com rewrite; MySQL com suporte a JSON.
- Criar no cPanel um banco exclusivo do site e um usuário autorizado **somente nesse banco**. Não reutilizar as credenciais do ultra-finance.
- Configuração em `~/ultra-site/db.php`, fora de `public_html`, no formato de `scripts/site-db.example.php`.
- Publicação exclusiva em `public_html/site-api/`. O financeiro continua em `/api/` e `/ultra-finance/`.
- O workflow do site exclui essas três pastas da sincronização. Não habilitar limpeza completa da pasta pública. Conferir o diretório inicial da conta FTP antes do primeiro envio.
- O deploy da API usa secrets próprios: `SITE_FTP_SERVER`, `SITE_FTP_USER`, `SITE_FTP_PASS`; servidor com certificado FTPS válido. Os caminhos pressupõem uma conta FTP cuja raiz contenha `public_html`.

## Banco e migrações

1. Criar o banco e configurar o arquivo privado.
2. Fazer backup antes de aplicar mudanças em banco existente.
3. Executar `php scripts/migrate-site.php` na cópia privada do projeto, com `ULTRA_SITE_DB_CONFIG` apontando para a configuração quando necessário.
4. Publicar a API e o frontend; validar `/site-api/v1/health` e um envio de teste.

O executor mantém `site_schema_migrations`, verifica checksums e usa trava MySQL para evitar execuções simultâneas. Migrações não rodam no build, no deploy FTP nem ao acessar o site. Arquivos aplicados não devem ser editados; mudanças usam nova migração. MySQL faz commit implícito de DDL: em caso de falha parcial, inspecionar e corrigir o banco antes de tentar novamente. Não publicar scripts, configurações nem a pasta `database` na área pública.

Sem SSH, importar os SQL em ordem no phpMyAdmin do **banco do site** e manter controle manual das versões. Escolher um único método; não alternar importação manual e executor sem registrar os checksums no histórico.

## API e armazenamento

`POST /site-api/v1/staff-registrations`, com JSON definido em `site-api/schema/staff.json`. Validação também ocorre no servidor; o ano e a data de inscrição são definidos pelo backend. Campos básicos são colunas indexáveis; todas as respostas e confirmações ficam em `answers` (JSON), com versão da especificação. Um e-mail por edição: repetição retorna 409 sem sobrescrever respostas. Esta regra pode ser alterada conforme a organização definir o fluxo de correção.

Respostas: 201 sucesso; 400 JSON inválido; 405 método inválido; 413 corpo acima de 32 KiB; 415 formato inválido; 422 campos inválidos; 429 limite de 10 envios válidos por IP/hora; 503 banco indisponível. Não há endpoint público de consulta, edição ou listagem de dados pessoais. Não envia e-mails automaticamente. A confirmação no site significa recebimento da candidatura, não seleção para a equipe.

## Desenvolvimento

Criar banco local exclusivo e copiar o exemplo para `config.site.local.php` (ignorado pelo Git). O PHP de linha de comando e o servidor local carregam esse arquivo automaticamente. `ULTRA_SITE_DB_CONFIG`, quando definida, tem prioridade. Na hospedagem, a configuração continua fora da pasta pública em `~/ultra-site/db.php`. Executar a migração, iniciar `php -S 127.0.0.1:8001 scripts/site-router.php` e `npm run dev` em outro terminal. Vite encaminha apenas `/site-api/v1` para essa porta.

Verificações: `php tests/site-validation.php`, sintaxe PHP, `npm run build`. O pipeline valida a API antes de publicá-la. Banco de produção e publicação não são executados durante os testes locais.

Para testar migração, armazenamento JSON, duplicidade e contador de tentativas em MySQL local, definir `ULTRA_SITE_TEST_CONFIG` com o caminho de uma configuração local e executar `php tests/site-database.php`. O teste recusa hosts remotos, cria um banco temporário `us_test_*` e remove apenas esse banco ao terminar; exige permissão local de criação de bancos. No PHP Windows, se necessário, habilitar `mbstring` com `php -d extension=mbstring tests/site-validation.php`.
