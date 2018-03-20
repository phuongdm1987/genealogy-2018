<?php
declare(strict_types=1);

namespace Genealogy\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Contact
 *
 * @package Genealogy\Entities
 * @property int $id
 * @property int $person_id
 * @property string|null $email
 * @property string|null $mobile
 * @property string|null $skype
 * @property string|null $facebook_url
 * @property string|null $address
 * @property-read \Genealogy\Entities\Person $person
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Contact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Contact whereFacebookUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Contact whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Contact wherePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Genealogy\Entities\Contact whereSkype($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    protected $table = 'contacts';

    public $timestamps = false;

    protected $fillable = ['person_id', 'email', 'mobile', 'skype', 'facebook_url', 'address'];

    /**
     * @return BelongsTo
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
