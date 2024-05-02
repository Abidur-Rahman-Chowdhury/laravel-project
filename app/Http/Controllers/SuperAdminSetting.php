<?php

namespace App\Http\Controllers;

use App\Models\DynamicModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminSetting extends Controller
{
    protected $dModel;
    public function __construct(){
       $this->dModel = new DynamicModel();
   }
    public function superAdminAddUser()
    {
      
        // $userGroup = session()->get('user_group');
        // $userData = session()->get($userGroup);
        // if (empty($userGroup)) {
        //     return redirect()->to(rtrim(BASE_URL, '/') . '/login');
        // }
        // if (!in_array($userGroup, [Constants::USER_GROUP[0]])) {
        //     return redirect()->to(rtrim(BASE_URL, '/') . '/login');
        // }
        // [$this->data['fmsg'], $this->data['status']] = $this->dModel->methodStartSession();

        // if ($this->request->getPost()) {
        //     $pData = $this->request->getPost();
        //     if ($pData['password'] !== $pData['repass']) {
        //         return redirect()->to($this->dModel->falseReturn('/super-admin/add-user', 'password dont match !!!'));
        //     }
        //     $validatePassword = $this->dModel->validatePassword($pData['password']);
        //     if ($validatePassword === false) {
        //         return redirect()->to($this->dModel->falseReturn('/super-admin/add-user', 'Password has to be at least 8 characters, speacial character, number and string!!!'));
        //     }
        //     $password = password_hash($pData['password'], PASSWORD_BCRYPT);
        //     $email = $this->dModel->validateEmailOrPhone($pData['email']);
        //     $phone = $this->dModel->validateEmailOrPhone($pData['phone']);
        //     if (empty($email) || empty($phone)) {
        //         return redirect()->to($this->dModel->falseReturn('/super-admin/add-user', 'Invalid email or phone !!!'));
        //     }
        //     $checkExistSuperAdmin = $this->dModel->dynamicCheckExist(['client_id' => Constants::DEACTIVE, 'email' => $email['content']], Constants::TABLE_USERS);
        //     $checkExistMerchant = $this->dModel->dynamicCheckExist(['client_id' => Constants::ACTIVE, 'email' => $email['content']], Constants::TABLE_USERS);
        //     if ($checkExistSuperAdmin ||   $checkExistMerchant) {
        //         return redirect()->to($this->dModel->falseReturn('/super-admin/add-user', 'user already exist !!!'));
        //     }
        //     $rules = [
        //         "user_group"  => 'required',
        //         "name"      => 'required',
        //         "last_name"      => 'required',
        //         "password"   => 'required',
        //         "email"  => 'required',
        //         "phone"  => 'required',
        //         "start_date" => 'required',
        //     ];
        //     if (!$this->validate($rules)) {
        //         session()->setFlashdata('form_error', $this->validator->getErrors());
        //         return redirect()->to(rtrim(BASE_URL, '/') . '/super-admin/add-user');
        //     }
        //     if ($pData['password'] !== $pData['repass']) {
        //         return redirect()->to($this->dModel->falseReturn('/super-admin/add-user', 'password dont match !!!'));
        //     }
        //     $softUsersData =  [
        //         'client_id' => $pData['client_id'] ?? 0,
        //         'name' => $pData['name'],
        //         'last_name' => $pData['last_name'],
        //         'email' => $email['content'],
        //         'phone' => $phone['content'],
        //         'present_address' => $pData['present_address'],
        //         'password' =>  $password,
        //         'b_date' =>  $pData['b_date'],
        //         'start_date' =>  $pData['start_date'],
        //         'end_date' =>  $pData['end_date'],
        //         'user_group' =>  $pData['user_group'],
        //         'op_id' => $userData['op_id'] ?? 0,
        //     ];
        //     $insertData = $this->dModel->dynamicInsertReturnId($softUsersData, Constants::TABLE_USERS);
        //     if (!$insertData) {
        //         return redirect()->to($this->dModel->falseReturn('/super-admin/add-user', 'Could not insert user data'));
        //     }
        //     return redirect()->to($this->dModel->successReturn('/super-admin/add-user', 'Users data added successfully!!!', true));
        // }
        // $this->data['formUrl'] = BASE_URL . 'super-admin/add-user';
        return view('layout/super-admin/add-user');
    }
    public function registerUser(Request $request) {
        $request->validate([
           'name' => 'required',
           'last_name' => 'required',
           'email' => 'required',
           'phone' => 'required',
           'password' => 'required',
           'repass' => 'required',
           'start_date' => 'required',
        ]);
        $userData = session()->get('userData');
        $checkExist = $this->dModel->dynamicCheckExistSingleRow(['client_id' => $userData['client_id'], 'email' => $request->email], 'users');
        $email = $this->dModel->validateEmailOrPhone($request->email);
        $phone = $this->dModel->validateEmailOrPhone($request->phone);
        if (empty($email) || empty($phone)) {
            return back()->with('error', 'Invalid email or phone !!!');
        }
        $password = $this->dModel->validatePassword($request->password);
        if($password === false) {
            return back()->with('error','Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number and one special character');
        }
        if($checkExist) {
                return back()->with('error', 'Email already exist');
        }
        $userData = [
            "user_group" => $request->user_group,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'present_address' => $request->present_address,
            'password' => Hash::make($request->password),
            'b_date' => $request->b_date,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'state' => $request->state ?? null,
            'post_code' => $request->post_code ?? null,
            'salt' => $request->post_code ?? null,
            'op_id' => $userData['op_id'] ?? null,
            'client_id' => $userData['client_id'] ?? null,
        ];
        $iId =  $this->dModel->dynamicInsertReturnId($userData, 'users');
        if(!$iId) {
            return back()->with('fail', 'Could not insert user data');
        }
        return back()->with('success', 'Users data added successfully!!!');
    }
}
