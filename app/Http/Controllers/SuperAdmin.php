<?php

namespace App\Http\Controllers;

use App\Models\DynamicModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdmin extends Controller
{
   protected $dModel;
   public function __construct(){
      $this->dModel = new DynamicModel();
  }
   public function index() {
     
      $user = $this->dModel->dynamicCheckExist(['client_id' => 1], 'users');
      foreach ($user as $key => $value) {
       dd($value);
      }
    return view('layout/super-admin/super-admin-home');
   }
}
