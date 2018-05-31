<?php
declare(strict_types=1);

namespace Genealogy\Entities;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 *
 * @package Genealogy\Entities
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\User whereUsername($value)
 * @mixin \Eloquent
 * @property-read \Genealogy\Entities\Person $person
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param string $username
     * @return User
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function findByUsername(string $username): self
    {
        return static::where('username', $username)->firstOrFail();
    }

    /**
     * @return HasOne
     */
    public function person(): HasOne
    {
        return $this->hasOne(Person::class);
    }
}
