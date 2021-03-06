<?php

namespace App;

use App\Branch;
use App\Meeting;
use App\Facility;
use App\SportField;
use App\Transformers\CourtTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Court extends Model
{
    use SoftDeletes;

    public $transformer = CourtTransformer::class;

    protected $table    = 'courts';

    protected $fillable = ['name', 'status', 'sport_field_id', 'avatar'];

    protected $dates    = ['deleted_at'];

    protected $hidden   = ['pivot', 'created_at', 'updated_at', 'deleted_at', 'sport_field_id'];

    public function sportField()
    {
    	return $this->belongsTo(SportField::class);
    }

    public function branches()
    {
    	return $this->belongsToMany(Branch::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
