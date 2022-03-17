<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    public $table = 'sections';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    //protected $appends = ['parent_name'];

    protected $fillable = [
        'section_name'
        ,'parent_id'
    ];

    protected $appends = ['parent_name'];

    public function children()
    {
        return $this->hasMany('App\Models\Sections', 'parent_id', 'id')->select(array('id', 'section_name as name', 'parent_id'))->orderBy('id', 'asc')->with('children');
    }

    public function getParentNameAttribute()
    { 
        return Sections::where('id', $this->parent_id)->pluck('section_name')->first();
    }
}