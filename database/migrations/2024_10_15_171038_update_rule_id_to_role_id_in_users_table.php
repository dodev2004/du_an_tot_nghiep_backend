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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id')->default(1)->after('rule_id');

            // Cập nhật dữ liệu từ rule_id sang role_id nếu cần
            // (Chú ý: Bạn có thể cần điều chỉnh logic này tùy thuộc vào cách dữ liệu của bạn được lưu)
            // $table->update(['role_id' => DB::raw('rule_id')]); // Uncomment nếu cần thiết

            // Xóa cột rule_id
            $table->dropColumn('rule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('rule_id')->default(1)->after('role_id');

            // Nếu bạn muốn khôi phục dữ liệu từ role_id sang rule_id,
            // bạn sẽ cần logic để làm điều đó ở đây. Lưu ý rằng
            // nếu bạn đã xóa dữ liệu trước đó thì sẽ không thể khôi phục.
            // $table->update(['rule_id' => DB::raw('role_id')]); // Uncomment nếu cần thiết

            // Xóa cột role_id
            $table->dropColumn('role_id');
        });
    }
};
