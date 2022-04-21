<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Purpose
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Purpose[] $shoes
 * @property-read int|null $shoes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Purpose newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purpose newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purpose query()
 * @mixin \Eloquent
 */
class Purpose extends Model
{
    use HasFactory;

    protected $table = 'purposes';

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
        return $this->belongsToMany(Purpose::class,'shoes_purpose','purpose_id','shoes_id');
    }


}
