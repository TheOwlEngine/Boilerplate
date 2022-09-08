# The Boilerplate

A repository containing a copy of our website repository, as a foundation if you want to create a similar blog like [The Owl Engine](https://owlengine.com) that supported multi-language out-of-the-box. We combined several libraries to speed up the process of creating an article-based website, based on the Laravel 9 framework in PHP Filament 2.

## What's is Inside?

- [Framework v9.0](https://github.com/laravel/framework)
- [Filament v2.0](https://github.com/filamentphp/filament)
- [Spatie Laravel Settings Plugin v2.0](https://github.com/filamentphp/spatie-laravel-settings-plugin)
- [Spatie Laravel Tags Plugin v2.15](https://github.com/filamentphp/spatie-laravel-tags-plugin)
- [Spatie Laravel Translatable Plugin v2.0](https://github.com/filamentphp/spatie-laravel-translatable-plugin)
- [Laravel Tags v4.3](https://github.com/spatie/laravel-tags)
- [Laravel Translatable v6.0](https://github.com/spatie/laravel-translatable)
- [Laravel Translation Loader v2.7](https://github.com/spatie/laravel-translation-loader)
- [Seotools v0.22.1](https://github.com/artesaos/seotools)
- [Filament Tiptap Editor v0.3.12](https://github.com/awcodes/filament-tiptap-editor)
- [Filament Email Log v0.2.2](https://github.com/ramnzys/filament-email-log)
- [Filament Navigation v0.3.0](https://github.com/ryangjchandler/filament-navigation)
- [Filament Spatie Laravel Backup v1.2](https://github.com/shuvroroy/filament-spatie-laravel-backup)

## Installation

First, you need to install composer dependencies using this command.

```
composer install
```

Next, create database from migrations.

```
php artisan migrate
```

After that, you can choose using Fresh install from empty databases.

```
php artisan make:filament-user
```

Or using pre-filled database.

```
mysql -u root -p YOUR_DATABASE < pre-filled-data.sql
```

Last, you can run the project.

```
php artisan serve
```

## Sitemap & Route Redirection

To activate sitemap and route redirection for multi-language, you need to run following commands.

```
php artisan sitemap:generator
php artisan cache:clear
```

## Development

For development purposes, you have to install tailwind dependencies first.

```
npm install
npm run watch
```

## Screenshots

Some screenshots of an already running project.

|![Homepage](./screenshots/01-homepage.png)|![Detail Article](./screenshots/02-detail-article.png)|![Dashboard](./screenshots/03-dashboard.png)|
|:---:|:---:|:---:|
|Homepage|Detail Article|Dashboard|
|![Categories](./screenshots/04-categories.png)|![Article Editor](./screenshots/05-article-editor.png)|![Navigation](./screenshots/06-navigation.png)|
|Categories|Article Editor|Navigation|
|![Navigation Editor](./screenshots/07-navigation-editor.png)|![Site Settings](./screenshots/08-site-settings.png)|![Site Backup](./screenshots/09-site-backup.png)|
|Navigation Editor|Site Settings|Site Backup|
