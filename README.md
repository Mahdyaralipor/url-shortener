# راهنمای کامل کلون و اجرای پروژه Laravel از GitHub

## پیش‌نیازها

قبل از شروع، مطمئن شوید این ابزارها نصب هستند:

- ✅ PHP 8.1 یا بالاتر
- ✅ Composer
- ✅ Git
- ✅ MySQL یا PostgreSQL
- ✅ Node.js و NPM (اختیاری - برای فرانت‌اند)

---

## مرحله 1️⃣: کلون کردن پروژه

### از طریق HTTPS:
```bash
git clone https://github.com/username/project-name.git
cd project-name
```

### از طریق SSH (اگر کلید SSH تنظیم کرده‌اید):
```bash
git clone git@github.com:username/project-name.git
cd project-name
```

### دانلود به صورت ZIP:
اگر Git ندارید:
1. به صفحه GitHub پروژه بروید
2. روی دکمه سبز **Code** کلیک کنید
3. **Download ZIP** را انتخاب کنید
4. فایل را Extract کنید

---

## مرحله 2️⃣: نصب Dependencies

### نصب پکیج‌های PHP:
```bash
composer install
```

اگر خطای مجوز گرفتید (در Linux/Mac):
```bash
sudo composer install
```

### نصب پکیج‌های JavaScript (اختیاری):
اگر پروژه فرانت‌اند دارد:
```bash
npm install
# یا
yarn install
```

---

## مرحله 3️⃣: تنظیم فایل Environment

### کپی کردن فایل .env:
```bash
cp .env.example .env
```

در ویندوز (اگر دستور بالا کار نکرد):
```bash
copy .env.example .env
```

### ویرایش فایل .env:
فایل `.env` را با ویرایشگر متن باز کنید و تنظیمات زیر را انجام دهید:

```env
APP_NAME="URL Shortener"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# تنظیمات دیتابیس
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=your_password

# اگر از SQLite استفاده می‌کنید:
# DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database.sqlite
```

---

## مرحله 4️⃣: ساخت Application Key

این کلید برای رمزنگاری داده‌ها استفاده می‌شود:

```bash
php artisan key:generate
```

این دستور خودکار `APP_KEY` را در فایل `.env` پر می‌کند.

---

## مرحله 5️⃣: ایجاد و تنظیم دیتابیس

### روش 1: MySQL/MariaDB
```bash
# ورود به MySQL
mysql -u root -p

# ساخت دیتابیس
CREATE DATABASE your_database_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# نمایش دیتابیس‌ها برای تایید
SHOW DATABASES;

# خروج
exit;
```

### روش 2: SQLite (ساده‌تر برای توسعه)
```bash
# ایجاد فایل دیتابیس
touch database/database.sqlite
```

سپس در `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=/مسیر_کامل/database/database.sqlite
```

### روش 3: PostgreSQL
```bash
# ورود به PostgreSQL
psql -U postgres

# ساخت دیتابیس
CREATE DATABASE your_database_name;

# خروج
\q
```

---

## مرحله 6️⃣: اجرای Migrations

این دستور جداول دیتابیس را ایجاد می‌کند:

```bash
php artisan migrate
```

### اگر خطا گرفتید:
```bash
# پاک کردن تمام جداول و اجرای دوباره
php artisan migrate:fresh

# با Seeder (داده‌های نمونه)
php artisan migrate:fresh --seed
```

---

## مرحله 7️⃣: اجرای Seeders (اختیاری)

اگر پروژه داده‌های نمونه دارد:

```bash
php artisan db:seed
```

یا برای seeder خاص:
```bash
php artisan db:seed --class=UserSeeder
```

---

## مرحله 8️⃣: ایجاد Storage Link

برای دسترسی عمومی به فایل‌های آپلود شده:

```bash
php artisan storage:link
```

این دستور یک symbolic link از `public/storage` به `storage/app/public` ایجاد می‌کند.

---

## مرحله 9️⃣: تنظیم دسترسی‌های فایل

### در Linux/Mac:
```bash
# دادن مجوز نوشتن به Laravel
chmod -R 775 storage bootstrap/cache

# اگر مشکل داشتید:
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

### در ویندوز:
معمولاً نیازی به تنظیم ندارید.

---

## مرحله 🔟: کامپایل Assets (اختیاری)

اگر پروژه از Vite یا Laravel Mix استفاده می‌کند:

### با Vite (Laravel 9+):
```bash
# برای Development
npm run dev

# برای Production
npm run build
```

### با Laravel Mix (Laravel 8):
```bash
# برای Development
npm run dev

# برای Production
npm run production
```

---

## مرحله 1️⃣1️⃣: اجرای سرور

### روش 1: سرور داخلی PHP
```bash
php artisan serve
```

پروژه در `http://localhost:8000` اجرا می‌شود.

### روش 2: تعیین پورت و Host
```bash
php artisan serve --host=0.0.0.0 --port=8080
```

### روش 3: استفاده از Laravel Valet (Mac)
```bash
valet link
valet secure project-name # برای HTTPS
```

### روش 4: استفاده از Docker
اگر پروژه `docker-compose.yml` دارد:
```bash
docker-compose up -d
```

---

## مرحله 1️⃣2️⃣: تنظیمات اضافی (در صورت نیاز)

### کش کردن تنظیمات (برای بهبود سرعت):
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### پاک کردن کش‌ها:
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### تنظیم Queue Worker (اگر پروژه از Queue استفاده می‌کند):
```bash
php artisan queue:work
```

---

## ✅ چک‌لیست نهایی

قبل از شروع کار، بررسی کنید:

- [ ] `composer install` با موفقیت اجرا شد
- [ ] فایل `.env` ایجاد و تنظیم شد
- [ ] `php artisan key:generate` اجرا شد
- [ ] دیتابیس ایجاد شد
- [ ] `php artisan migrate` اجرا شد
- [ ] `php artisan storage:link` اجرا شد
- [ ] دسترسی‌های فولدرها تنظیم شد
- [ ] سرور Laravel اجرا شد

---

## 🔧 رفع مشکلات رایج

### خطای "Class not found"
```bash
composer dump-autoload
```

### خطای "Permission denied"
```bash
sudo chmod -R 777 storage bootstrap/cache
```

### خطای "No application encryption key"
```bash
php artisan key:generate
```

### خطای "SQLSTATE[HY000] [1049]"
دیتابیس وجود ندارد. دیتابیس را ایجاد کنید.

### خطای "could not find driver"
درایور دیتابیس نصب نیست:
```bash
# برای MySQL
sudo apt-get install php-mysql

# برای PostgreSQL
sudo apt-get install php-pgsql

# برای SQLite
sudo apt-get install php-sqlite3
```

### خطای npm
```bash
rm -rf node_modules package-lock.json
npm install
```

---

## 📚 دستورات مفید Laravel

```bash
# نمایش لیست routeها
php artisan route:list

# نمایش لیست commandها
php artisan list

# ساخت کنترلر جدید
php artisan make:controller NameController

# ساخت مدل با migration
php artisan make:model ModelName -m

# اجرای تست‌ها
php artisan test

# مشاهده لاگ‌ها
tail -f storage/logs/laravel.log

# وارد شدن به tinker (کنسول Laravel)
php artisan tinker
```

---

## 🎯 نکات مهم

1. ⚠️ **هرگز فایل `.env` را commit نکنید** - حاوی اطلاعات حساس است
2. 📝 **فایل `.env.example` را به‌روز نگه دارید** - راهنمای دیگران
3. 🔒 **APP_DEBUG را در production روی false قرار دهید**
4. 🗂️ **از Git Ignore استفاده کنید** - فولدرهای vendor و node_modules
5. 🔐 **رمزهای قوی استفاده کنید** - برای دیتابیس و APP_KEY

---

## 🚀 مراحل Deploy به Production

1. تنظیم `.env` برای production
2. `APP_DEBUG=false`
3. `APP_ENV=production`
4. اجرای `composer install --optimize-autoloader --no-dev`
5. اجرای `php artisan config:cache`
6. اجرای `php artisan route:cache`
7. اجرای `php artisan view:cache`
8. تنظیم HTTPS
9. تنظیم فایروال و امنیت

---

## 🎉 پروژه شما آماده است!

اکنون می‌توانید به `http://localhost:8000` بروید و پروژه را ببینید.

موفق باشید! 💪
