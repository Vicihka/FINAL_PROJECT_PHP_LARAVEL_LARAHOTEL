<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('room_types', function (Blueprint $table) {
            $table->foreignId('room_category_id')->nullable()->after('name')->constrained('room_categories')->nullOnDelete();
        });

        $categories = DB::table('room_types')
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category');

        foreach ($categories as $name) {
            $categoryId = DB::table('room_categories')->insertGetId([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('room_types')
                ->where('category', $name)
                ->update(['room_category_id' => $categoryId]);
        }
    }

    public function down(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            $table->dropConstrainedForeignId('room_category_id');
        });

        Schema::dropIfExists('room_categories');
    }
};
