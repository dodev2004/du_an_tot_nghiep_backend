<?php

namespace App\Console\Commands;

use App\Models\ProductComment;
use Illuminate\Console\Command;

class DeleteOldSoftDeletedComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-soft-deleted-comments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Tính toán thời gian 30 ngày trước
        $dateThreshold = now()->subDays(30);

        // Lấy tất cả bình luận đã xóa mềm và đã qua 30 ngày
        $deletedComments = ProductComment::onlyTrashed()->where('deleted_at', '<=', $dateThreshold)->get();

        foreach ($deletedComments as $comment) {
            $comment->forceDelete(); // Xóa cứng bình luận
        }

        $this->info('Đã xóa cứng tất cả bình luận đã xóa mềm quá 30 ngày.');
    }
}
