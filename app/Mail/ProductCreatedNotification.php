<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Product;

class ProductCreatedNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $product;

    /**
     * Create a new message instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Product Created Notification',
        );
    }

    public function build(){
        return $this->view('emails.product-created')
                    ->with(['product' => $this->product])
                    ->subject('New Product Created');
    }

}
