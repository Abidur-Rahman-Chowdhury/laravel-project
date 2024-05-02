<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DynamicModel extends Model
{
    use HasFactory;
    protected $db;

    public function __construct()
    {
        $this->db = DB::connection(); // Access the default database connection
       
    }
    public function dynamicInsert(array $data, string $table)
    {
        return DB::table($table)->insert($data);
    }

    public function selectAllData(string $table, string $orderById, string $ascDesc)
    {
        return DB::table($table)
            ->where('is_active', 1)
            ->orderBy($orderById, $ascDesc)
            ->get()
            ->toArray();
    }

    public function dynamicUpdate(array $where, string $table, array $data)
    {
        return DB::table($table)
            ->where($where)
            ->update($data);
    }

    // Other methods...

    public function generateInvoice($length = 16)
    {
        return 'KLH' . Str::upper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length));
    }

    // public function imageUpload($file, $folderPath = 'test-img/', $targetWidth = 200, $targetHeight = 200, $thumbnail = false)
    // {
    //     $extension = $file->getClientOriginalExtension();
    //     $fileNewName = "cnf-" . time() . '.' . $extension;
    //     $image = \Image::make($file);
    //     $image->resize($targetWidth, $targetHeight, function ($constraint) {
    //         $constraint->aspectRatio();
    //     });
    //     $image->save(public_path($folderPath . $fileNewName));
    //     return $fileNewName;
    // }
    public function dynamicCheckExist(array $where, string $table)
    {
      
       $query = $this->db->table($table);
       $query->where($where);
       return $query->select()->get()->toArray();
    }

    public function dynamicCheckExistSingleRow(array $where, string $table)
    {
        $result = DB::table($table)->where($where)->first();
        return $result ? (array) $result : null;
    }
    public function dynamicInsertReturnId(array $data, string $table)
    {
        return DB::table($table)->insertGetId($data);
    }
    public static function validateEmailOrPhone($content): ?array
    {
        if (filter_var($content, FILTER_VALIDATE_EMAIL)) {
            return [
                'type' => 'email',
                'content' => $content
            ];
        }

        if (preg_match("/(^(\+8801|8801|01|1))[1|3-9]{1}(\d){8}$/", $content)) {

            $phone = self::formatPhone($content);
            return [
                'type' => 'phone',
                'content' => $phone
            ];
        }

        return [];
    }
    public static function formatPhone($phone)
    {
        return "880" . substr($phone, -10);
    }
    function validatePassword($password)
    {
        $hasSpecialChar = preg_match('/[!@#$%^&*()_+\-=\[\]{}|;:\'",.<>\/?]/', $password);
        $hasNumber = preg_match('/[0-9]/', $password);
        $hasString = preg_match('/[a-zA-Z]/', $password);
        $isMinLength = strlen($password) >= 8;
        if ($hasSpecialChar && $hasNumber && $hasString && $isMinLength) {
            return true;
        } else {
            return false;
        }
    }
    public function falseReturn($route, $message, $rollback = false)
    {
        if ($rollback) {
            $this->db->transRollback();
        }
        $ssData = ['sfmsg' => $message, 'sstatus' => 'red'];
        session()->set($ssData);
        return rtrim(base_url(), '/') . $route;
    }

    public function successReturn($route, $message, $commit = false)
    {
        if ($commit) {
            $this->db->transCommit();
        }
        $ssData = ['sfmsg' => $message, 'sstatus' => 'green'];
        session()->set($ssData);
        return rtrim(base_url(), '/') . $route;
    }
}
