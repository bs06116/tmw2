<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;


class Common extends Model
{
    public static function insert_data($data_array,$table_name)
    {
        return DB::table($table_name)->insertGetId($data_array);
       // return DB::table($table_name)->insert($data_array);
    }
    public static function all_data($table_name)
    {

        return DB::table($table_name)->get()->where('del_bit', '0');
    }

    public static function all_data_meal($table_name)
    {

        return DB::table($table_name)->get();
    }

     public static function select_all_data($table_name)
    {

        return DB::table($table_name)->get();
    }
    public static function delete_data($id,$table_name)
    {
        $data=array('del_bit'=> 1);
        return DB::table($table_name)->where('id', $id)->update($data);

    }
    public static function single_data($id,$table_name)
    {

        return DB::table($table_name)->where('id', $id)->where('del_bit', 0)->first();

    }
    public static function single_data_without_del($id,$table_name)
    {

        return DB::table($table_name)->where('id', $id)->first();

    }


 public static function single_record($id,$table_name)
    {

        return DB::table($table_name)->where('id', $id)->first();

    }

    public static function update_data($id,$data_array,$table_name)
    {
        return DB::table($table_name)->where('id', $id)->update($data_array);
    }

    public static function page_details($slug,$table)
    {
         return DB::table($table)->where('slug', $slug)->where('del_bit', 0)->first();
    }

    public static function single_data_by_field($field_name,$val,$table_name)
    {
        return DB::table($table_name)->where($field_name, $val)->first();
    }
    public static function data_by_with($where,$table)
    {
         return DB::table($table)->where($where)->first();
    }



     public static function select_data_with_pagination($table_name)
    {

        return DB::table($table_name)->paginate(25);
    }

}
