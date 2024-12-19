<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->integer('gt_don_hang_toi_thieu')->nullable();
            $table->integer('gia_tri_giam_toi_da')->nullable()->after('gt_don_hang_toi_thieu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn('gt_don_hang_toi_thieu');
            $table->dropColumn('gia_tri_giam_toi_da');
        });
    }
}