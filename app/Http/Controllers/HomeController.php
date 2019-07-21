<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Common;
use Illuminate\Validation\Rule;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewMember()
    {
        $data = DB::table('users')
            ->where('admin_type', '0')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json(["result"=>$data->toArray()],200);
    }

    public function insertMember(Request $request)
    {
        $book_number = Input::get('book_number');
        $name = Input::get('name');
        $email = Input::get('email');
        $address = Input::get('address');
        $postcode = Input::get('postalcode');
        $telephone = Input::get('telephone');
        $fname = Input::get('fname');
        $gender = Input::get('gender');
        $dob = Input::get('dob');
        $head_relation = Input::get('head_relation');
        $relation = Input::get('relation');

        $rules = array(
            'book_number' => 'required|max:50|unique:users,book_number',
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email',
            'dob' => 'sometimes|required|max:255',
           );
        $messages = array(
            'book_number.required' => '<p>Please enter book number.</p>',
            'book_number.unique' =>'<p>Book number already exits.</p>' ,
            'name.required' => '<p>Please enter  name.</p>',
            'email.required' => '<p>Please enter email.</p>',
            'email.unique' =>'<p>Email already exits.</p>' ,
            'dob.required' => '<p>Please enter DOB.</p>',
            //'head_relation.etc' => '<p>You can add one Spouse.</p>',
        );
        $input = Input::all();
        $validator = Validator::make($input, $rules, $messages);
        if(!empty($head_relation) && !empty($relation)){
            if(!$this->checkSpouse($head_relation,$relation))
                $validator->after(function ($validator) {
                    $validator->errors()->add('head_relation', 'You can add only one Spouse.');
                });
        }
        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors'  => $validator->errors()->all(),
            ], 400);
        }else{

            $data=array(
                'book_number'=>$book_number,
                'name'    =>  $name,
                'email'    =>  $email,
                'relation'=>$head_relation,
                'address'=>$address,
                'postcode'=>$postcode,
                'telephone'=>$telephone,
                'created_at'=>Carbon::now(),

            );
            $last_id = Common::insert_data($data,"users");
            $relation_array=array();
            if($relation){
                for($i=0; $i<count($relation);$i++){
                    if($fname[$i]!=''){
                        $relation_array[]=array('name'=>$fname[$i],
                            'dob'=>$dob[$i],
                            'gender'=>$gender[$i],
                            'relation'=>$relation[$i],
                            'user_id'=>$last_id);
                    }
                }
            }
            DB::table('user_relation')->insert($relation_array);
            return response()->json(['success' => true,'message'=>'Your data has been save successfully.','user_id'=>$last_id], 200);
        }

    }
    public function updateMember(Request $request)
    {
        $name = Input::get('name');
        $email = Input::get('email');
        $address = Input::get('address');
        $postcode = Input::get('postalcode');
        $telephone = Input::get('telephone');
        $fname = Input::get('fname');
        $user_id = Input::get('user_id');
        $book_number = Input::get('book_number');
        $dob = Input::get('dob');
        $head_relation = Input::get('head_relation');
        $relation = Input::get('relation');
        $gender = Input::get('gender');
        $rules = array(
            'book_number' => 'required|max:50|unique:users,book_number,'.$user_id,
            'name' => 'required|max:255',
            'dob' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email,'.$user_id,
        );
        $messages = array(
            'book_number.required' => '<p>Please enter Book number.</p>',
            'book_number.unique' =>'<p>Book number already exits.</p>' ,
            'name.required' => '<p>Please enter  name</p>',
            'email.required' => '<p>Please enter email</p>',
            'email.unique' =>'<p>Email already exits.</p>' ,


        );
        $input = Input::all();

        $validator = Validator::make($input, $rules, $messages);
        if(!empty($head_relation) && !empty($relation)){
            if(!$this->checkSpouse($head_relation,$relation))
            $validator->after(function ($validator) {
                $validator->errors()->add('head_relation', 'You can add one Spouse');
            });
        }
        if ($validator->fails()) {

            return response()->json([
                'success' => 'false',
                'errors'  => $validator->errors()->all(),
            ], 400);
        }else{

             $data=array(
                'book_number'=>$book_number,
                'name'=>$name,
                'email'=>$email,
                'relation'=>$head_relation,
                'address'=>$address,
                'postcode'=>$postcode,
                'telephone'=>$telephone,
                'created_at'=>Carbon::now(),

            );
            $result = Common::update_data($user_id,$data,"users");
            DB::table('user_relation')->where('user_id', $user_id)->delete();
            $relation_array=array();

            for($i=0; $i<count($relation);$i++){

                if($fname[$i]!=''){
                    $relation_array[]=array('name'=>$fname[$i],
                        'relation'=>$relation[$i],
                        'dob'=>$dob[$i],
                        'gender'=>$gender[$i],
                        'relation'=>$relation[$i],
                        'user_id'=>$user_id);
                }
            }
            DB::table('user_relation')->insert($relation_array);

            return response()->json(['success' => true,'message'=>'Your data has been update successfully.','user_id'=>$user_id], 200);
        }

    }
    public  function  checkSpouse($head_relation,$relation){
        if(in_array($head_relation,$relation)){
            return false;
        }
        $indexes_wife = array_keys($relation, 'wife'); //array(0, 1)
      if(count($indexes_wife)==2){
          return false;
      }
        $indexes_husband = array_keys($relation, 'husband'); //array(0, 1)
        if(count($indexes_husband)==2){
            return false;
        }
        return true;

    }
    public function editMember()
    {
        $id = Input::get('id');
        $result = DB::table('users')
            ->where('id', $id)
            ->first();
        $result_user_relaiton = DB::table('user_relation')
            ->where('user_id', $id)
            ->get();
        return response()->json(["member_relation"=>$result,"user_relation"=>$result_user_relaiton],200);
    }
    public function updateFileStatus(){
        $user_id = Input::get('user_id');
        $status = Input::get('status');
        $update_file=array("status"=>$status);
        $result=DB::table('users')->where('id',$user_id)->update($update_file);
        if($result){
            return redirect('view_member')->with('message', 'updated!');
        }else{
            return redirect('view_member')->with('message', 'error!');
        }
    }
    public function createNewFile(Request $request)
    {
        $user_id = Input::get('user_id');
        $status = Input::get('status');
        $result=DB::table('user_relation')->where('id', $user_id)->first();
            $data=array(
                'book_number'=>rand(1,1000000),
                'name'    =>  $result->name,
                'created_at'=>Carbon::now(),
            );
        $users_array=array('status'=>0);
        DB::table('user_relation')->where('id',$user_id)->update($users_array);
        $last_id = Common::insert_data($data,"users");
        return response()->json(['success' => true,'message'=>'Your data has been save successfully.','id'=>$user_id], 200);

    }

    /**
     * get all member against id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailsMember(Request $request)
    {
        $id=$request->input('id');
        $result = DB::table('users')
            ->where('id', $id)
            ->first();
        $result_user_relaiton = DB::table('user_relation')
            ->where('user_id', $id)
            ->get();
        return response()->json(["member_relation"=>$result,"user_relation"=>$result_user_relaiton],200);
    }
    public function updatePayment(){
        $id = Input::get('id');
        $payment_status = Input::get('payment_status')==0?1:0;
        $update_status=array("payment_status"=>$payment_status);
        $result=DB::table('users')->where('id',$id)->update($update_status);
        return response()->json(['success' => true,'message'=>'Your data has been update successfully.'], 200);
    }
}
