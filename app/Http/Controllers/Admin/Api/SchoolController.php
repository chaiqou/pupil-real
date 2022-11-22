<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class SchoolController extends Controller
{
  public function index() {
              $schools = User::role('school')->get();
              $schoolsArray = [];
              foreach($schools as $school)
              {
                  array_push($schoolsArray, (object)[
                     'id' => $school->school_id,
                      'name' => 'Name: ' . ucfirst($school->first_name) . ', schoolID: #' . $school->school->id,
                  ]);
              }
              return response()->json($schoolsArray);
  }
}
