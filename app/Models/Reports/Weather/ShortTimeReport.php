<?php

namespace App\Models\Reports\Weather;

use Illuminate\Database\Eloquent\Model;

class ShortTimeReport extends Model
{
    protected $table = 'weather_short_time_reports';
    protected $primaryKey = 'interval';
    protected $fillable = ['interval','temperature','dew_point','pressure','humidity','rain_rate','gust_speed','wind_speed','wind_dir','sky_temperature','sqm','sky_brightness','cloud_cover'];
    public $timestamps=false;
    protected $casts = [
        'interval' => 'datetime',
    ];
}
