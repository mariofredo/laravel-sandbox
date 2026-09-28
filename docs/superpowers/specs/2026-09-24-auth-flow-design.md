# Auth Flow Design — Register, Login, Logout, Dashboard

Date: 2026-09-24
Status: Draft — awaiting review

## Goal

Learn Laravel's structure by hand-building session-based authentication (no starter kit, no Fortify). Success = a user can register, log in, log out, and reach a dashboard that guests cannot see, with every flow covered by passing feature tests.

## Scope

In scope:
- Register (name, email, password + confirmation)
- Login (email, password)
- Logout
- Protected `/dashboard` page

Out of scope (possible follow-ups): remember me, password reset, email verification, login rate limiting, Form Request classes.

## Constraints / existing state

- Laravel 13, Blade, Tailwind 4 via Vite — already installed.
- `users` table and `User` model exist and are used unchanged. `User` already has `#[Fillable(['name', 'email', 'password'])]` and the `'password' => 'hashed'` cast.
- Tests run on in-memory SQLite (`phpunit.xml`); local MySQL `crud_db` is not touched by tests.

## Routes (`routes/web.php`)

| Method | URI | Action | Name | Middleware |
|---|---|---|---|---|
| GET | /register | RegisteredUserController@create | register | guest |
| POST | /register | RegisteredUserController@store | — | guest |
| GET | /login | SessionController@create | login | guest |
| POST | /login | SessionController@store | — | guest |
| GET | /dashboard | closure → `view('dashboard')` | dashboard | auth |
| POST | /logout | SessionController@destroy | logout | auth |

The `login` route name is required: the `auth` middleware redirects guests to it. Logout is POST (CSRF-protected), never GET.

## Controllers (`app/Http/Controllers/Auth/`)

### RegisteredUserController
- `create()` → `view('auth.register')`
- `store(Request $request)`:
  1. Validate: `name` required|string|max:255; `email` required|string|email|max:255|unique:users; `password` required|string|min:8|confirmed.
  2. `$user = User::create($validated)` (hashing handled by model cast).
  3. `Auth::login($user)`.
  4. `$request->session()->regenerate()`.
  5. `redirect()->route('dashboard')`.

### SessionController
- `create()` → `view('auth.login')`
- `store(Request $request)`:
  1. Validate: `email` required|email; `password` required.
  2. If `! Auth::attempt($credentials)` → throw `ValidationException::withMessages(['email' => 'These credentials do not match our records.'])`.
  3. `$request->session()->regenerate()`.
  4. `redirect()->intended(route('dashboard'))`.
- `destroy(Request $request)`:
  1. `Auth::logout()`.
  2. `$request->session()->invalidate()`.
  3. `$request->session()->regenerateToken()`.
  4. `redirect('/')`.

Failed login uses one generic message so it does not reveal whether an email is registered.

## Views (`resources/views/`)

- `components/layout.blade.php` — anonymous Blade component used as `<x-layout>`. Contains `<head>` with `@vite(['resources/css/app.css', 'resources/js/app.js'])`, a nav bar, and `{{ $slot }}`.
  - `@guest`: Login and Register links.
  - `@auth`: user name, Dashboard link, Logout button inside a `POST` form with `@csrf`.
- `auth/register.blade.php` — form with name, email, password, password_confirmation; link to login.
- `auth/login.blade.php` — form with email, password; link to register.
- `dashboard.blade.php` — "Welcome, {{ auth()->user()->name }}".

Every form includes `@csrf`. Text inputs repopulate with `old()`; password inputs never do. Each field shows its error via `@error(...)`. Styling: simple centered Tailwind card.

## Tests (`tests/Feature/`, PHPUnit, `RefreshDatabase`)

Written before the implementation (TDD).

**Auth/RegistrationTest**
- Register page renders (200).
- Valid data creates user, user is authenticated, redirects to dashboard.
- Duplicate email fails validation on `email`, user stays guest.
- Mismatched password confirmation fails validation on `password`.

**Auth/LoginTest**
- Login page renders (200).
- Correct credentials authenticate and redirect to dashboard.
- Wrong password fails with error on `email`, user stays guest.
- Authenticated user visiting `/login` is redirected to `/dashboard` (Laravel's `guest` middleware picks the `dashboard` route by name automatically).
- Logout makes user a guest and redirects to `/`.

**DashboardTest**
- Guest visiting `/dashboard` is redirected to `/login`.
- Authenticated user sees their name.

Verification: `php artisan test` passes; manual check in browser via `composer run dev` or `php artisan serve` + `npm run dev`.

## Files created / modified

Created:
- `app/Http/Controllers/Auth/RegisteredUserController.php`
- `app/Http/Controllers/Auth/SessionController.php`
- `resources/views/components/layout.blade.php`
- `resources/views/auth/register.blade.php`
- `resources/views/auth/login.blade.php`
- `resources/views/dashboard.blade.php`
- `tests/Feature/Auth/RegistrationTest.php`
- `tests/Feature/Auth/LoginTest.php`
- `tests/Feature/DashboardTest.php`

Modified:
- `routes/web.php`
