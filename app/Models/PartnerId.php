<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerId extends Model
{
    use HasFactory;

    protected $table = 'partner_ids';

    protected $guarded = ['id'];
}
