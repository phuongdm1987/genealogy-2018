<?php
declare(strict_types=1);

namespace Genealogy\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Genealogy\Entities\Biographical
 *
 * @property int $id
 * @property int $person_id
 * @property string|null $birth_place
 * @property string|null $company
 * @property string|null $career
 * @property string|null $school
 * @property string|null $subject
 * @property string|null $degree
 * @property string|null $hobbies
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Biographical whereBirthPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Biographical whereCareer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Biographical whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Biographical whereDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Biographical whereHobbies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Biographical whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Biographical wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Biographical whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Biographical whereSubject($value)
 * @mixin \Eloquent
 * @property-read \Genealogy\Entities\Person $person
 */
class Biographical extends Model
{
    protected $table = 'biographical';

    public $timestamps = false;

    protected $fillable = ['person_id', 'birth_place', 'company', 'career', 'school', 'subject', 'degree', 'hobbies'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
