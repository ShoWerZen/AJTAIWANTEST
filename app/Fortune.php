<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Fortune extends Model
{
    protected $primaryKey = 'id';
    protected $table = "fortune";
    protected $fillable = [
        "astro_id", 
        "dailyDate",
        "overallStar",
        "loveStar",
        "careerStar",
        "wealthStar",
        "overallText",
        "loveText",
        "careerText",
        "wealthText"
    ];
    public $timestamps = true;

    public static function createValidate(array $data)
    {
        $validator = Validator::make($data, [
            'astro_id' => ['required', 'integer'],
            'dailyDate' => ['required', 'date'],
            'overallStar' => ['required', 'integer'],
            'loveStar' => ['required', 'integer'],
            'careerStar' => ['required', 'integer'],
            'wealthStar' => ['required', 'integer'],
            'overallText' => ['required', 'string'],
            'loveText' => ['required', 'string'],
            'careerText' => ['required', 'string'],
            'wealthText' => ['required', 'string']
        ]);

        if($validator->fails())
            throw new Exception(implode(",", $validator->errors()->all()));
    }
}

