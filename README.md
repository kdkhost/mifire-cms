# MiFire CMS - Laravel 12

Sistema de Gerenciamento de Conteúdo desenvolvido para a **MiFire** (Soluções de Combate a Incêndio).

Painel administrativo completo com gerenciamento de páginas, produtos, blog, banners, marcas, downloads, configurações, e-mail, menus, endereços, redes sociais, contatos e visitantes.

---

## Requisitos

- PHP >= 8.4
- MySQL 8.0+ / MariaDB 10.6+
- Node.js >= 20
- Composer 2.x
- Extensões PHP: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd`

---

## Instalação Local

```bash
git clone <repo-url> mifire-cms
cd mifire-cms
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run dev
# Acesse: http://localhost:8000
```

---

## Deploy cPanel / WHM

1. `composer install --no-dev --optimize-autoloader`
2. `npm run build`
3. Upload dos arquivos via FTP para a raiz do domínio
4. Criar banco MySQL no cPanel e preencher o `.env`
5. `chmod -R 775 storage bootstrap/cache`
6. `php artisan migrate`
7. `php artisan storage:link`
8. Acesse `https://seudominio.com.br/install` para configuração inicial

---

## Funcionalidades

| Módulo | Descrição |
|---|---|
| Páginas | CMS de páginas estáticas com slug automático |
| Produtos | Catálogo com galeria, fichas técnicas e filtros |
| Blog | Posts com imagem destaque, SEO e controle de publicação |
| Banners | Slider com reordenação drag-and-drop |
| Marcas | Logos de marcas parceiras |
| Downloads | Arquivos para download público |
| Categorias | Categorias para produtos e blog |
| Contatos | Formulário público com resposta por e-mail |
| Visitas | Rastreamento de visitas com gráficos |
| Menus | Header e footer configuráveis |
| Endereços | Múltiplos endereços no footer |
| Redes Sociais | Links de redes sociais |
| Configurações | SEO, e-mail SMTP, PWA, scripts personalizados |
| Usuários | Controle de acesso ao painel |
| PWA | Progressive Web App com service worker |

---

## Desenvolvedor

**George Marcelo** — KDKHost Soluções

---

## Histórico de Atualizações

### 2026-03-04 — 13:00

**Arquitetura: Persistência AJAX e Máscaras Globais**

- **Painel Administrativo Fluidizado**: Todas as operações de criação e edição agora utilizam AJAX, proporcionando uma experiência sem recarregamento de página.
- **Feedback em Tempo Real**: Integração com **SweetAlert2** para notificações de sucesso e erro de forma padronizada.
- **Sistema de Máscaras Globais**: Implementação do `vanilla-masker` com inicialização automática via atributo `data-mask`.
  - Suporte a: Telefone (fixo/celular dinâmico), CPF, CNPJ, CEP, Moeda (R$) e Datas.
  - Re-inicialização automática pós-requisições AJAX garantindo funcionalidade contínua.
- **Upload Híbrido de Redes Sociais**: Novo sistema que permite escolher entre ícones CSS ou upload de arquivos de imagem no painel de redes sociais.

### 2026-03-04 — 12:20

**Melhoria: Migração global do painel administrativo para AJAX**

- Implementação de handler global para requisições AJAX.
- Integração com SweetAlert2 para feedback visual.
- Refatoração de todos os controllers e views (Configurações, Blog, Produtos, Usuários, Páginas, Banners, Marcas, etc) para uma experiência sem recarregamento de página.

### 2026-03-04 — 12:04

**Correção: Sincronização e Persistência de Configurações**

- **SettingController:** Refatorado para retornar mapeamento direto de chaves para a view. Corrigida falha onde campos ficavam vazios após salvar devido à estrutura de dados agrupada.
- **Sincronia Admin/Site:** Chaves renomeadas no Admin para baterem com as chaves esperadas no Frontend (`email`, `phone`, `whatsapp`, `theme_color`, etc.).
- **Gestão Institucional:** Adicionados campos `phone2`, `logo_white` (rodapé), `company_description` e seção de "Sobre a Empresa" (`mission`, `vision`, `values`) no painel.

### 2026-03-04 — 11:49

**Correção: ViteManifestNotFoundException em produção (erro 500)**

- Assets do Vite (`public/build/`) removidos do `.gitignore` e incluídos no repositório
- Necessário pois o servidor cPanel não possui Node.js para executar `npm run build`
- `npm run build` deve ser executado localmente antes de cada deploy e os arquivos commitados

### 2026-03-04 — 11:22

**Auditoria completa: correção de 8 bugs críticos**

- **BUG #1+#8 — SettingController:** campos de upload renomeados para `site_logo`, `site_favicon`, `pwa_icon_192` e `pwa_icon_512`, alinhando com a view. Ícones PWA agora salvos separadamente por tamanho (192px e 512px).
- **BUG #2 — BlogPostController:** corrigidos redirecionamentos e view names de `admin.blog-posts.*` para `admin.blog.*`. Parâmetro de route model binding renomeado de `$blogPost` para `$blog` em todos os métodos. View `edit.blade.php` atualizada para usar `$blog`.
- **BUG #3 — Blog index view:** filtro de categoria corrigido de `name="category"` para `name="category_id"`.
- **BUG #4 — Banners index view:** payload do drag-and-drop reorder corrigido de `{ids:[]}` para `{items:[{id, order}]}`.
- **BUG #6 — Site layout:** `head_scripts`, `body_scripts` e `custom_css` agora injetados corretamente no frontend. Chaves de imagem atualizadas de `logo`/`favicon` para `site_logo`/`site_favicon`.
- **BUG #7 — Storage link:** verificado e caches do Laravel limpos (`config`, `cache`, `view`, `route`).

> **Atenção ao subir para produção:** rodar `UPDATE settings SET key='site_logo' WHERE key='logo'` e `UPDATE settings SET key='site_favicon' WHERE key='favicon'` antes do deploy para manter imagens cadastradas.
