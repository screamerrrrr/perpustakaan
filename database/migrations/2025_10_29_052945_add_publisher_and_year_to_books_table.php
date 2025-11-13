<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // HANYA Tambahkan kolom baru
            $table->string('publisher')->nullable()->after('author');
            $table->year('publication_year')->nullable()->after('publisher');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // HANYA Hapus kolom baru saat rollback
            $table->dropColumn('publisher');
            $table->dropColumn('publication_year');
        });
    }
};
