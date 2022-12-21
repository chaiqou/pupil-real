<?php

namespace App\Http\Controllers\Parent\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderLunchController extends Controller
{
    public function index($student_id)
    {
        dump($student_id);
    }
}
