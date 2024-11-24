<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public function patient()
    {
      return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
      return $this->belongsTo(User::class, 'doctor_id');
    }

    public function schedule()
    {
      return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
