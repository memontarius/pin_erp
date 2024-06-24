<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Notifications\NewProduct;
use Illuminate\Support\Facades\Notification;

class NewProductEmailNotification
{
    /**
     * Handle the event.
     */
    public function handle(ProductCreated $event): void
    {
        $destinationEmail = config('products.email');
        Notification::route('mail', $destinationEmail)->notify(new NewProduct($event->product));
    }
}
