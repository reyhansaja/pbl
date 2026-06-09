<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Cafe;

class CafeDeleted extends Mailable
{
    use Queueable, SerializesModels;

    public $cafeName;

    public function __construct(string $cafeName)
    {
        $this->cafeName = $cafeName;
    }

    public function build()
    {
        return $this->subject('Cafe Anda telah dihapus — ' . $this->cafeName)
                    ->view('emails.cafe_deleted')
                    ->with(['cafeName' => $this->cafeName]);
    }
}
