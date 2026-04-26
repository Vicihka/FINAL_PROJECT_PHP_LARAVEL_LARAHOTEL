# LaraHotel

A hotel room booking web application built with Laravel — PHP Laravel Final Project at IT STEP Cambodia.

---

## Team

| Name | Role |
|------|------|
| Yeun Vicheka | Leader / Full Stack |
| Kim Hun | Developer |
| Meimei Siv | Developer |
| Heang Lyly | Developer |

---

## Features

**Guest (public)**
- Browse rooms and room types with photos and pricing
- Register / Login
- Book a room (choose check-in and check-out dates)
- View and track personal bookings
- Online payment flow (confirm & success pages)
- Contact form

**Admin panel** (`/admin`)
- Dashboard with booking and revenue stats
- Manage room categories, room types, and individual rooms
- Bulk room creation
- Approve / reject / cancel bookings
- Print check-in slip
- View all registered guests
- Read contact messages
- Notifications

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 13, PHP 8.3 |
| Database | MySQL |
| Frontend (guest) | Blade + custom CSS |
| Frontend (admin) | Blade + Tailwind CSS (Vite) |
| Auth | Laravel built-in session auth |

---

## Requirements

- PHP 8.3+
- Composer
- Node.js + npm
- MySQL (e.g. MySQL Workbench, XAMPP, or any MySQL server)

---

## Clone & Setup

### 1. Clone the repository

```bash
git clone https://github.com/Vicihka/FINAL_PROJECT_PHP_LARAVEL-LARAHOTEL.git
cd FINAL_PROJECT_PHP_LARAVEL-LARAHOTEL
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Set up environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Set up the database

Open MySQL Workbench and create a new database:

```sql
CREATE DATABASE larahotel;
```

Then open `.env` and set your database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=larahotel
DB_USERNAME=root
DB_PASSWORD=
```

Then run migrations and seed the data:

```bash
php artisan migrate --seed
```

### 5. Start the servers

**Terminal 1 — Laravel:**

```bash
php artisan serve
```

**Terminal 2 — Vite (admin CSS):**

```bash
npm run dev
```

Open your browser at: **http://localhost:8000**

---

## Default Login Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@larahotel.com | password |
| Guest | register at `/register` | your choice |

Admin panel: **http://localhost:8000/admin**

---

## What the Seeder Creates

Running `php artisan migrate --seed` automatically creates:

- 1 admin account
- 5 room categories (Single, Double, Twin, Family, Suite)
- 8 room types with prices and photos
- 34 individual rooms across 7 floors (rooms 101–702)

---

## Pages & URLs

### Guest

| Page | URL |
|------|-----|
| Home | `/` |
| Rooms list | `/rooms` |
| Room detail | `/rooms/{id}` |
| My Bookings | `/my-bookings` |
| Payment | `/payment/{booking}` |
| Contact | `/contact` |
| About | `/about` |
| Login | `/login` |
| Register | `/register` |
| Notifications | `/notifications` |

### Admin

| Page | URL |
|------|-----|
| Dashboard | `/admin` |
| Bookings | `/admin/bookings` |
| Rooms | `/admin/rooms` |
| Room Types | `/admin/room-types` |
| Room Categories | `/admin/room-categories` |
| Guests | `/admin/guests` |
| Messages | `/admin/messages` |

---

## Project Structure (key folders)

```
app/
  Http/
    Controllers/         ← Guest controllers
    Controllers/Admin/   ← Admin controllers
    Middleware/          ← AdminMiddleware
  Models/                ← Room, RoomType, RoomCategory, Booking, User

database/
  migrations/            ← All table definitions
  seeders/               ← Admin account + room data

resources/views/
  layouts/               ← app.blade.php (shared layout)
  rooms/                 ← Room list & detail pages
  bookings/              ← My bookings page
  payment/               ← Payment flow pages
  admin/                 ← All admin panel views

public/images/           ← Room photos (local, no cloud needed)

routes/web.php           ← All routes
```

---

## Notes

- No external services required — everything runs locally.
- Images are stored in `public/images/` — no S3 or upload server needed.
- Make sure MySQL is running before you run migrations.
- If your MySQL root account has a password, add it to `DB_PASSWORD=` in `.env`.
- Run `npm run dev` in a second terminal to compile admin Tailwind CSS, otherwise admin pages may look unstyled.
