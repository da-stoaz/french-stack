# Physiotherapy Clinic Booking Platform

Production-ready physiotherapy clinic website built with Laravel 12, PostgreSQL, Inertia.js + React + TypeScript, Inertia SSR, Filament 3, Sanctum, queued mailables, and Cloudflare R2 storage configuration.

## Stack

- Backend: Laravel 12
- Database: PostgreSQL
- Frontend: Inertia.js + React + TypeScript
- SSR: Inertia SSR (`resources/js/ssr.tsx`)
- Admin/CMS: Filament 3 (`/admin`)
- Auth: Laravel Sanctum + web sessions
- Email: Queued mailables (`BookingConfirmation`, `BookingNotification`)
- Storage: Cloudflare R2 via Laravel filesystem disk `r2`
- Deployment target: Laravel Cloud + Cloudflare

## Rebranding

All brand content is centralized in:

- `config/brand.php`

Update that file to change:

- name/tagline/description
- contact details/social links
- brand colors
- fonts
- logo path

Brand config is shared via Inertia middleware and injected as CSS custom properties in `resources/views/app.blade.php`.

## Local Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan inertia:start-ssr   # SSR node process
php artisan queue:work          # Queue worker
npm run dev                     # Vite dev server
php artisan serve               # Laravel dev server
```

## Default Seed Data

- 5 physiotherapy services
- 30 days of weekday slots at 09:00, 10:00, 11:00, 14:00, 15:00, 16:00
- 6 testimonials
- 1 admin user:
  - email: `admin@<brand-email-domain>` (derived from `config('brand.email')`)
  - password: `password`

## Key Routes

- `/` home
- `/services` full service list
- `/book` booking form
- `/booking/confirmed` post-booking confirmation
- `/login` admin login
- `/admin` Filament admin panel

## Queue + Email

- Queue driver: `database`
- Jobs table migration included
- Both booking mailables implement `ShouldQueue`
- For local preview, use Mailpit or another SMTP sink by setting `.env` mail variables

## Cloudflare R2 + Laravel Cloud

- Filesystem disk `r2` is configured in `config/filesystems.php`
- Placeholder env keys are present in `.env.example`:
  - `R2_ACCESS_KEY_ID`
  - `R2_SECRET_ACCESS_KEY`
  - `R2_BUCKET`
  - `R2_REGION`
  - `R2_ENDPOINT`
  - `R2_URL`
- `FILESYSTEM_CLOUD=r2` is preconfigured for production intent

For Laravel Cloud deployment, connect the repository, set environment variables, and run queue/SSR workers as managed processes.
