<?php

namespace App\Http\Controllers;

use App\Models\DynamicModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
class AuthController extends Controller
{
    protected $dModel;
    public function __construct(){
       $this->dModel = new DynamicModel();
   }

  public function login() {
    return view('layout/auth/login');
  }
  public function loginUser(Request $request){
    $clientId = 1;
    $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);
    $exist = $this->dModel->dynamicCheckExistSingleRow([ 'client_id' => $clientId, 'email' => $request->email], 'users');
    if($exist){
        if(Hash::check($request->password, $exist['password'])){
            $request->session()->put('userData',[
                'op_id' => $exist['id'],
                'email' => $exist['email'],
                'client_id' => $exist['client_id'],
                'user_group' => $exist['user_group'],
                'name' => $exist['name'],
                'last_name' => $exist['last_name'],

            ]);
            return redirect('super-admin');
        } else{
            return back()->with('fail', 'Invalid Password');
        }
    }
    return back()->with('fail', 'The email is not registerd');
  }
}
