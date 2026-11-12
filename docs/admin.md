# Administração do site

`/admin` é uma página independente, com login, menu lateral, busca por nome/e-mail, paginação de 20 inscrições e consulta de todas as respostas. Não há cadastro nem edição de usuários pela interface. Os administradores ativos compartilham acesso às inscrições do site; não há divisão por proprietário.

## Publicação e primeiro usuário

1. Faça backup e aplique **somente** `database/site-migrations/002_admin.sql` no banco do site pelo phpMyAdmin se a instalação inicial foi manual. Não reaplique a migração 001 nem use o banco financeiro. Se utiliza o executor com histórico, execute `php scripts/migrate-site.php`.
2. Gere o hash da sua senha no computador: no PowerShell, execute `./scripts/site-password-hash.ps1`. PHP precisa estar disponível. A senha é solicitada de forma oculta e não é passada como argumento nem gravada em arquivo. Use uma senha única com pelo menos 12 caracteres. Copie o hash exibido, nunca a senha em texto puro.
3. No phpMyAdmin do banco do site, insira o usuário:

```sql
INSERT INTO site_admin_users (name, email, password_hash, role, active)
VALUES ('Seu nome', 'seu-email@exemplo.com', 'COLE_O_HASH_AQUI', 'admin', 1);
```

4. Publique frontend e API, entre em `https://SEU_DOMINIO/admin` e confira as inscrições. Não há usuário/senha padrão.

Para revogar acesso, altere `active` para `0` no banco. A API verifica usuário ativo e perfil `admin` em cada consulta, inclusive quando a sessão já existe. Perfis diferentes de `admin` não têm acesso. Para alterar senha, gere outro hash e atualize `password_hash`; para revogar sessões existentes, desative a conta (trocar apenas a senha não encerra sessões já abertas).

## Segurança e rotas

- Sessão PHP exclusiva `ultra_site_admin`, sem compartilhar autenticação com ultra-finance. Cookie `HttpOnly`, `SameSite=Strict`, caminho `/site-api`, `Secure` em produção. HTTP é permitido apenas no servidor PHP local em loopback. Hospedagem deve usar HTTPS e `display_errors=Off`.
- Login regenera o identificador da sessão; expira após 1 hora inativa ou 12 horas desde o login. Logout invalida a sessão. Cookies e senhas não são armazenados em localStorage.
- Login e logout exigem token CSRF; token é renovado no login. Tentativas de login limitadas por e-mail (10) e IP (30) em janelas de 15 minutos, inclusive credenciais válidas. Mensagem de erro não distingue conta inexistente, inativa ou senha inválida.
- Todas as rotas de consulta verificam autorização no backend; ocultar componentes no navegador não concede acesso. Respostas privadas usam `Cache-Control: no-store`. Busca parametrizada e paginação limitada. Textos exibidos pelo Vue são escapados.
- `GET /site-api/v1/admin/session`: usuário atual (ou `null`) e token CSRF.
- `POST /site-api/v1/admin/login`: JSON com `email` e `password`, cabeçalho `X-CSRF-Token`.
- `POST /site-api/v1/admin/logout`: cabeçalho `X-CSRF-Token`.
- `GET /site-api/v1/admin/staff?page=1&search=texto`: resumo paginado, somente administrador.
- `GET /site-api/v1/admin/staff/{id}`: respostas completas, somente administrador.

As migrações continuam separadas do build e do deploy. Contas e tabelas financeiras não são alteradas. Não publique scripts, configuração local ou migrações em `public_html`.

## Testes locais

Com Node 22, PHP com `mbstring` e `pdo_mysql`, e MySQL local: defina `ULTRA_SITE_TEST_CONFIG` com o caminho de uma configuração local que tenha permissão para criar bancos e execute `node tests/site-admin.mjs`. O teste cria um banco temporário `us_admin_test_*`, aplica ambas as migrações, testa HTTP e remove o banco ao terminar. Não aponta para o banco de produção.
