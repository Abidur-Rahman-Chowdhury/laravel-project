<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SchoolModel extends Model
{
    use HasFactory;
    protected $db;

    public function __construct()
    {
        $this->db = DB::connection(); // Access the default database connection
       
    }
    public function getSuperAdminUsers($data)
    {
      
        $query = DB::table('users')
            ->select('users.*','client.client_name')
            ->join('client', 'client.id', '=', 'users.client_id');
          
        // if (isset($data['user_id']) && !empty($data['user_id'])) {
        //     $query->where('su.id', $data['user_id']);
        // }
        // if (isset($data['client_id']) && !empty($data['client_id'])) {
        //     $query->where('su.client_id', $data['client_id']);
        // }
       
        // if (isset($data['user_group']) && !empty($data['user_group'])) {
        //     $query->where('su.user_group', $data['user_group']);
        // }
        // if (isset($data['is_active'])  && $data['is_active'] != '') {
        //     $query->where('su.is_active', (int) $data['is_active']);
        // }
        // if ((isset($data['from']) && !empty($data['from'])) && isset($data['to']) && !empty($data['to'])) {
        //     $from = date('Y-m-d H:i:s', strtotime($data['from']));
        //     $to = date('Y-m-d 23:59:59', strtotime($data['to']));
        //     $query->where('su.created_at >=', $from);
        //     $query->where('su.created_at <=', $to);
        // }
        return $query->get()->toArray();
    }
}
