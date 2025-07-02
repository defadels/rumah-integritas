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
        Schema::table('form_hasil_periksa', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            $table->boolean('is_reply')->default(false)->after('parent_id');
            $table->integer('reply_level')->default(0)->after('is_reply');
            $table->text('reply_message')->nullable()->after('file_attach');
            
            // Foreign key constraint
            $table->foreign('parent_id')->references('id')->on('form_hasil_periksa')->onDelete('cascade');
            
            // Index for better performance
            $table->index(['parent_id', 'is_reply']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_hasil_periksa', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropIndex(['parent_id', 'is_reply']);
            $table->dropColumn(['parent_id', 'is_reply', 'reply_level', 'reply_message']);
        });
    }
};
