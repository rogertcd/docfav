<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'birth_date',
        'gender',
    ];

    protected $guarded = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the name.
     * Set the name
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => ucwords($value),
        );
    }

    /**
     * Get the last name.
     * Set the last name
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => ucwords($value),
        );
    }

    /**
     * Get the password.
     * Set the password
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value),
        );
    }

    /**
     * Get the birth date.
     * Set the birth date
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function birthDate(): Attribute
    {
//        dd(config('app.app_date_format'));
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format(config('app.app_date_format')),
            set: fn ($value) => Carbon::createFromFormat(config('app.db_date_format'), $value, 'America/La_Paz')->toDateString(),
        );
    }

    /**
     * Get the gender.
     * Set the gender
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function gender(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value == 'F' ? 'Femenino' : 'Masculino',
            set: fn ($value) => strtoupper($value),
        );
    }
}
