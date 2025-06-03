<?php

namespace App\Mail;

use App\Models\Order;
use App\Traits\HasDepartmentEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels, HasDepartmentEmail;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $emailConfig = $this->getDepartmentEmail('order');
        
        return new Envelope(
            from: $emailConfig['address'],
            subject: '[Hana Eyewear] Đơn hàng mới #' . $this->order->order_number,
            replyTo: [$this->order->user->email],
            tags: ['order', 'order-placed'],
            metadata: [
                'order_id' => $this->order->id,
                'customer_name' => $this->order->user->name,
                'customer_email' => $this->order->user->email
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.placed',
            with: [
                'customerName' => $this->order->user->name,
                'customerEmail' => $this->order->user->email,
                'orderNumber' => $this->order->order_number,
                'orderTotal' => $this->order->total,
                'orderDate' => $this->order->created_at->format('d/m/Y H:i'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
