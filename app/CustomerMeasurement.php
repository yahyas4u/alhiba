<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerMeasurement extends Model
{
    protected $fillable =[
        "customer_id","measure_1", "measure_2", "measure_3", "measure_4",
        "measure_5", "measure_6", "measure_7", "measure_8","measure_9",
        "measure_notes"
    ];
}
