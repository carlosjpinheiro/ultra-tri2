# ultra-tri2

## Inscrição de staffs

Página `/staff` e backend PHP/MySQL independente em `/site-api/`. Consulte [configuração, migrações e publicação](docs/staff-backend.md). O banco e as migrações são exclusivos do site, separados do ultra-finance.

## Administração

Área `/admin` com autenticação, acesso exclusivo a administradores ativos e consulta das inscrições. Consulte [migração e criação do primeiro administrador](docs/admin.md) antes de publicar esta versão.

a fazer:
    - linkar ou exibir localização(google maps) do clube em ComoChegar
    - criar pagina de Galeria
    - adicionar carrossel na pagina do arete
    
## Fotos do carrossel inicial

Adicione ou remova fotos na pasta `src/assets/images/hero/`. O Hero.vue carrega automaticamente as imagens JPG, JPEG, PNG, WebP, AVIF e GIF diretamente dessa pasta.

A ordem segue o nome dos arquivos; use prefixos como `01-`, `02-`, `03-` para controlar a sequência. Não é necessário editar o componente.

Após mudar as fotos, gere e publique novamente o site para atualizar a versão online.
