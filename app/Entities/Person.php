<?php
declare(strict_types=1);

namespace Genealogy\Entities;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class Person
 *
 * @package Genealogy\Entities
 * @mixin \Eloquent
 * @property string|null $avatar
 * @property \Carbon\Carbon|null $birth_of_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $death_of_date
 * @property int|null $father_id
 * @property string|null $first_name
 * @property int $id
 * @property int $is_living
 * @property string|null $last_name
 * @property string|null $middle_name
 * @property int|null $mother_id
 * @property int $sex
 * @property \Carbon\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \Genealogy\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereBirthOfDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereDeathOfDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereFatherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereIsLiving($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereMotherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereUserId($value)
 * @property-read \Genealogy\Entities\Contact $contact
 * @property-read \Genealogy\Entities\Biographical $biographical
 * @property-read \Kalnoy\Nestedset\Collection|\Genealogy\Entities\Person[] $children
 * @property-read \Genealogy\Entities\Person $parent
 * @property mixed $parent_id
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person d()
 * @property int $_lft
 * @property int $_rgt
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Person whereRgt($value)
 */
class Person extends Model
{
    use NodeTrait;

    const SEX = ['Female', 'Male', 'Other'];

    protected $table = 'persons';

    protected $dates = ['birth_of_date', 'death_of_date'];

    protected $fillable = ['user_id', 'parent_id', '_lft', '_rgt', 'first_name', 'middle_name', 'last_name', 'avatar', 'sex', 'birth_of_date', 'is_living', 'death_of_date'];

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        if (!$this->avatar) {
            return '';
        }

        return '/storage/images/' . $this->avatar;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        $fullName = $this->first_name;
        $fullName .= $this->middle_name ? ' ' . $this->middle_name : '';
        $fullName .= $this->last_name ? ' ' . $this->last_name : '';

        return $fullName;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getBirthOfDate($format = 'Y-m-d'): string
    {
        return $this->birth_of_date ? $this->birth_of_date->format($format) : '';
    }

    /**
     * @param string $format
     * @return string
     */
    public function getBirthOfTime($format = 'H:i'): string
    {
        return $this->getBirthOfDate($format);
    }

    /**
     * @param string $format
     * @return string
     */
    public function getDeathOfDate($format = 'Y-m-d'): string
    {
        return $this->death_of_date ? $this->death_of_date->format($format) : '';
    }

    /**
     * @param string $format
     * @return string
     */
    public function getDeathOfTime($format = 'H:i'): string
    {
        return $this->getDeathOfDate($format);
    }

    /**
     * @return bool
     */
    public function isDead(): bool
    {
        return !$this->is_living;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contact(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Contact::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function biographical(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Biographical::class);
    }
}
