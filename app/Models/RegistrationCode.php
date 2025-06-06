<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class RegistrationCode extends Model
{
    /** @use HasFactory<\Database\Factories\RegistrationCodeFactory> */
    use HasFactory, HasUuids, Notifiable;
}
