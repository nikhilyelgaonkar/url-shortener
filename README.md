# URL Shortener

A multi-company URL shortening application built with Laravel 12, PHP, and MySQL.

## Features

- Role-based access control with three roles: `superadmin`, `admin`, and `member`.
- SuperAdmin can manage companies and invite Admin users.
- Admin can invite Admins and Members within their own company.
- Invitation links expire after 7 days and can only be accepted once.
- SuperAdmin and Members can create short URLs.
- Admins can view all short URLs created within their company.
- Members can view only the short URLs they created.
- Public short links redirect visitors to the original URL without requiring login.
- Click counts are tracked for short URLs.

## Technology

- PHP 8.2 or later, subject to the requirements of the installed Laravel version
- Laravel 12
- MySQL
- Laravel Breeze (Blade authentication)
- Node.js and npm

## Prerequisites

Install PHP with the Laravel-required extensions, Composer, MySQL, Node.js, npm, and Git.

For Windows/XAMPP, ensure the PHP used by your terminal is the intended XAMPP PHP version:

```bash
php -v
composer --version
node -v
npm -v
```

## Local installation

### 1. Get the source code

Clone the repository and enter the project directory:

```bash
git clone https://github.com/YOUR_GITHUB_USERNAME/url-shortener.git
cd url-shortener
```

Replace `YOUR_GITHUB_USERNAME` with the GitHub account or organization that owns the repository. Alternatively, download and extract the repository ZIP.

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Create your local environment file

Windows Command Prompt:

```cmd
copy .env.example .env
```

Git Bash:

```bash
cp .env.example .env
```

### 4. Create and configure the database

Create a MySQL database:

```sql
CREATE DATABASE url_shortener;
```

Update these values in `.env` to match your local MySQL configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=url_shortener
DB_USERNAME=root
DB_PASSWORD=
```

If your MySQL root account has a password, enter it as `DB_PASSWORD`.

### 5. Generate the Laravel application key

```bash
php artisan key:generate
```

### 6. Run database migrations

```bash
php artisan migrate
```

If the project provides a SuperAdmin seeder, run it using the actual class name found under `database/seeders`. For example:

```bash
php artisan db:seed --class=SuperAdminSeeder
```

Do not run `php artisan migrate:fresh` on a database containing data you want to keep; it drops existing tables.

### 7. Install and build frontend assets

```bash
npm install
npm run build
```

For frontend development with Vite, run `npm run dev` in a separate terminal instead of relying only on the production build.

### 8. Start the local server

```bash
php artisan serve
```

Open the URL printed by Artisan, usually:

```text
http://127.0.0.1:8000
```

## Roles and permissions

| Capability | SuperAdmin | Admin | Member |
|---|---|---|---|
| Create, edit, and delete companies | Yes | No | No |
| Invite an Admin | Yes, choosing a company | Yes, own company only | No |
| Invite a Member | No | Yes, own company only | No |
| Create short URLs | Yes, choosing a company | No | Yes, own company |
| View short URLs | No global URL listing | All URLs in own company | Own URLs only |
| Open public short URLs | Yes | Yes | Yes |

An invited user receives their role and company assignment from the invitation. These values should not be supplied by the registration form. In the current development workflow, the invitation URL may be displayed for manual sharing if email delivery has not been configured.

## Testing the application

After installation, test the following:

- [ ] Log in with the seeded SuperAdmin account.
- [ ] Create a company as SuperAdmin.
- [ ] Invite an Admin to a company and accept the invitation.
- [ ] Log in as Admin and invite an Admin or Member in the same company.
- [ ] Confirm a Member cannot access company management or invitation pages.
- [ ] Create a short URL as SuperAdmin for a selected company.
- [ ] Create a short URL as Member and confirm the member's company is assigned automatically.
- [ ] Confirm Admin cannot create short URLs.
- [ ] Confirm Admin sees only URLs belonging to their company.
- [ ] Confirm Member sees only URLs they created.
- [ ] Open a generated public short URL and confirm it redirects to the original URL.
- [ ] Confirm the click count increases after redirection.
- [ ] Confirm expired and already accepted invitations cannot be reused.

## Useful commands

Clear Laravel's cached configuration, routes, and views:

```bash
php artisan optimize:clear
```

List application routes:

```bash
php artisan route:list
```

Check migration status:

```bash
php artisan migrate:status
```

Run automated tests:

```bash
php artisan test
```

## Security and repository notes

- Never commit `.env`, credentials, API keys, or production secrets.
- Keep `vendor/` and `node_modules/` out of Git; install them locally with Composer and npm.
- Check that `.env` is ignored by `.gitignore` before committing.
- Enforce authorization in routes and controllers. Hiding navigation links alone does not secure a feature.
- Use HTTPS and production-safe environment settings when deploying.

## License

Add the applicable license information here if you plan to distribute this project.
