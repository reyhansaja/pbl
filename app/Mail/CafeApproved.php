<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Cafe;

class CafeApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $cafe;

    public function __construct(Cafe $cafe)
    {
        $this->cafe = $cafe;
    }

    public function build()
    {
        return $this->subject('Cafe Anda telah disetujui — ' . $this->cafe->name)
                    ->view('emails.cafe_approved')
                    ->with(['cafe' => $this->cafe]);
    }
}
