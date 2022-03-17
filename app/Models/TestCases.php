<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCases extends Model
{
    use HasFactory;
    public $table = 'test_cases';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    //protected $appends = ['parent_name'];

    protected $fillable = [
        'section_id'
        ,'testcase_summary'
        ,'description'
        ,'filename'
        ,'status'
    ];
}


