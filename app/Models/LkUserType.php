<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LkUserType extends Model
{
    use HasFactory;

    public const ADMIN = "01";
    public const CUSTOMER = "02";
}
