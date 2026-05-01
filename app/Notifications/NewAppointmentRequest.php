<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAppointmentRequest extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    // 👇 لازم database
    public function via($notifiable)
    {
        return ['database'];
    }

    // 👇 البيانات اللي باش تتخزن
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Nouveau rendez-vous demandé',
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->appointment->patient_id,
            'appointment_time' => $this->appointment->appointment_time,
        ];
    }
}
