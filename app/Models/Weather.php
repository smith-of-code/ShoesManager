<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Weather
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Purpose[] $shoes
 * @property-read int|null $shoes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Weather newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Weather newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Weather query()
 * @mixin \Eloquent
 */
class Weather extends Model
{
    use HasFactory;

    protected $table = 'weathers';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable=[
        'name',
    ];

    protected $hidden=[
        "created_at",
        "updated_at",
        'pivot'
    ];


    public function shoes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Purpose::class,'shoes_weather','weather_id','shoes_id');
    }
}
