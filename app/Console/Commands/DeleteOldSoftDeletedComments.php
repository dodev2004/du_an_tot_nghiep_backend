<?php

namespace App\Console\Commands;

use App\Models\ProductComment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteOldSoftDeletedComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comments:delete-old-soft-deleted-comments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Xóa cứng các bình luận đã bị xóa mềm';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Tính toán thời gian 30 ngày trước
        $dateThreshold = now()->subDays(1);
        
        Log::info('Date threshold: ' . $dateThreshold);
        // Lấy tất cả bình luận đã xóa mềm và đã qua 30 ngày
        $deletedComments = ProductComment::onlyTrashed()->where('deleted_at', '<=', $dateThreshold)->get();
        
        if ($deletedComments->isEmpty()) {
            Log::info('No comments to delete.');
        }

        foreach ($deletedComments as $comment) {
            $comment->forceDelete(); // Xóa cứng bình luận
            Log::info('Deleted comment with ID: ' . $comment->id);
        }

        $this->info('Đã xóa cứng tất cả bình luận đã xóa mềm quá 30 ngày.');
    }
}
