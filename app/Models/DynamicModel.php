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
        dd($this->db);
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
}
