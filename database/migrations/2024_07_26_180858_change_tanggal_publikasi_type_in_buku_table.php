<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeTanggalPublikasiTypeInBukuTable extends Migration
{
    public function up()
    {
        // Menggunakan perintah SQL mentah untuk mengubah tipe data kolom dengan klausa USING
        DB::statement('ALTER TABLE buku ALTER COLUMN tanggal_publikasi TYPE date USING tanggal_publikasi::date');
    }

    public function down()
    {
        // Mengembalikan tipe data kolom ke string jika di-rollback
        DB::statement('ALTER TABLE buku ALTER COLUMN tanggal_publikasi TYPE date USING tanggal_publikasi::date');
    }
}
