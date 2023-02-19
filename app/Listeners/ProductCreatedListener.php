<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductCreatedNotification;


class ProductCreatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductCreated $event): void
    {
        $product = $event->product;
        $user = $product->user;

        //commenting this code as there is no email provider registered for now
     //   Mail::to($user->email)->send(new ProductCreatedNotification($product));
    }
}
