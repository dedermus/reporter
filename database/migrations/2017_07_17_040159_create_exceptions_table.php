<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateLaravelReporterTables.
 *
 * CREATE TABLE `laravel_exceptions` (
 * `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 * `type` varchar(190) COLLATE utf8_unicode_ci NOT NULL,
 * `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
 * `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 * `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 * `line` int(10) unsigned NOT NULL,
 * `trace` text COLLATE utf8_unicode_ci NOT NULL,
 * `method` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
 * `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 * `query` text COLLATE utf8_unicode_ci NOT NULL,
 * `body` text COLLATE utf8_unicode_ci NOT NULL,
 * `cookies` text COLLATE utf8_unicode_ci NOT NULL,
 * `headers` text COLLATE utf8_unicode_ci NOT NULL,
 * `ip` varchar(255) COLLATE utf8_unicode_ci,
 * `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
 * `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
 * PRIMARY KEY (`id`),
 * KEY `laravel_issues_name_index` (`name`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 */
class CreateExceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $table = config('admin.extensions.reporter.table', 'laravel_exceptions');

        // Проверка на существование таблицы перед созданием
        if (!Schema::hasTable($table)) {
            Schema::connection($connection)->create($table, function (Blueprint $table) {
                $table->comment('журнал исключений');
                $table->id()->comment('инкремент ID');
                $table->string('type', 255)->comment('тип');
                $table->string('code')->comment('код');
                $table->string('message', 255)->comment('сообщение исключения/конфликта');
                $table->string('file', 255)->comment('файл, где произошло исключение/конфликт');
                $table->integer('line')->comment('строка исключения в файле');
                $table->text('trace')->comment('трассировка');
                $table->string('method')->comment('метод');
                $table->string('path', 255)->comment('путь');
                $table->text('query')->comment('запрос');
                $table->text('body')->comment('тело');
                $table->text('cookies')->comment('куки');
                $table->text('headers')->comment('заголовки');
                $table->ipAddress('ip')->comment('IP адрес');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $table = config('admin.extensions.reporter.table', 'laravel_exceptions');

        Schema::connection($connection)->dropIfExists($table);
    }
}
