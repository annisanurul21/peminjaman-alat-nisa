<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('tools', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Relasi ke tabel categories
        $table->string('code')->unique(); // Kode alat (misal: ALT-001)
        $table->string('name');
        $table->text('description')->nullable();
        $table->integer('stock')->default(0);
        $table->string('image')->nullable(); // Untuk simpan nama file foto
        $table->enum('status', ['available', 'unavailable'])->default('available');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
