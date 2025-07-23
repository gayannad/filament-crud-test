<?php

namespace App\Jobs;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\User;
use App\Notifications\ProductProcessedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessProduct implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public Product $product;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('[Job:ProcessProduct] Started', [
                'product_id' => $this->product->id,
                'product_name' => $this->product->name,
                'current_status' => $this->product->status,
            ]);

            // Update product status
            $this->product->update([
                'status' => ProductStatus::Processed,
            ]);

            Log::info('[Job:ProcessProduct] Product status updated to Processed', [
                'product_id' => $this->product->id,
                'product_name' => $this->product->name,
            ]);

            // Send notification
            $user = User::first();
            if ($user) {
                $user->notify(new ProductProcessedNotification($this->product));

                Log::info('[Job:ProcessProduct] Notification sent to user', [
                    'user_id' => $user->id,
                    'product_id' => $this->product->id,
                ]);
            } else {
                Log::warning('[Job:ProcessProduct] No user found to notify', [
                    'product_id' => $this->product->id,
                ]);
            }

            Log::info('[Job:ProcessProduct] Completed successfully', [
                'product_id' => $this->product->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('[Job:ProcessProduct] Failed', [
                'product_id' => $this->product->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
