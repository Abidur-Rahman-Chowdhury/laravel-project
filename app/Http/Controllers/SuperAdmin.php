<?php

namespace App\Http\Controllers;

use App\Models\DynamicModel;
use App\Models\SchoolModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdmin extends Controller
{
   protected $dModel;
   protected $schoolModel;
   protected $data;
   public function __construct()
   {
      $this->dModel = new DynamicModel();
      $this->schoolModel = new SchoolModel();
   }
   public function index()
   {
      $userData = session()->get('userData');
      $user = $this->dModel->dynamicCheckExist(['client_id' =>  $userData['client_id']], 'users');
      $this->data['users'] = ['1','2','3','4','5','6','7','8'];
      $this->data['client'] = $user;
      
      return view('layout/super-admin/super-admin-home', $this->data);
   }
   public function superAdminShowUsers()
   {
      $userData = session()->get('userData');
      //  $this->data['data'] = $this->dModel->dynamicCheckExist(['client_id' =>  $userData['client_id']], 'users');
       $this->data['data'] = $this->schoolModel->getSuperAdminUsers($userData['client_id']);
       dd( $this->data['data']);
      //  dd( $this->data['data']);
       return view('layout/super-admin/show-users', $this->data);
   }
}
