<?php

namespace App\Models;

use Database\Seeders\PurposeSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Shoes
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Purpose[] $purposes
 * @property-read int|null $purposes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Weather[] $weathers
 * @property-read int|null $weathers_count
 * @method static \Illuminate\Database\Eloquent\Builder|Shoes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shoes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shoes query()
 * @mixin \Eloquent
 */
class Shoes extends Model
{
    use HasFactory;

    protected $table = 'shoes';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable=[
        'id',
        'name',
        'temp_from',
        'temp_to',
        'photo_path',
    ];

    protected $hidden=[
        "created_at",
        "updated_at",
//        'pivot',
        "weathers",
        "purposes"

    ];

    protected $appends = ['weathers_ids','purposes_ids'];

    public function purposes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Purpose::class,'shoes_purpose','shoes_id','purpose_id');
    }
    public function weathers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Weather::class,'shoes_weather','shoes_id','weather_id');
    }

    public function getWeathersIdsAttribute()
    {
        return $this->weathers->pluck('id');
    }

    public function getPurposesIdsAttribute()
    {
        return $this->purposes->pluck('id');
    }






}
