<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiResponseLog extends Model
{
    use HasFactory;

    protected $fillable = ['request_id', 'status_code', 'response_body'];
}
