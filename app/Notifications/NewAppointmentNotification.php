<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAppointmentNotification extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => '📅 New appointment request',
            'patient_id' => $this->appointment->patient_id,
            'date' => $this->appointment->date,
            'time' => $this->appointment->start_time,
        ];
    }
}
