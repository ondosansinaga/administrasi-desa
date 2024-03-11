<?php

namespace App\Events;

use App\Models\DataWarga;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WargaUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public DataWarga $warga;

    public function __construct(DataWarga $warga)
    {
        $this->warga = $warga;
    }
}