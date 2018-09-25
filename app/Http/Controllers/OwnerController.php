<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  App\Http\Resources\OwnerResource; 
use App\Mail\DemoMail;
use App\Owner; 
use App\Bussines; 
class OwnerController extends Controller
{
    public function login(Request $request){
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            // 'email' => 'required_without:name',
            'password' => 'required',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $name_email = $request->name;// may be  username or email 
        $password = $request->password ; 
        $token    = $request->token ;
        $str = explode(".", $name_email);
        // check if email or user name 
        if(in_array("com", $str)){
            // select by email 
            $owner  = DB::table('owners')->where( 'email', $name_email)->where('password',$password)->first();             
        }else {
            //select by name  
            $owner = DB::table('owners')->where( 'name', $name_email)->where('password',$password)->first() ; 
        }

       
        //check if owner have account  and check for token 
        // update token if user open app from different device 
        if($owner && $owner->token != $token){
            Owner::where( 'name', $owner->name)->where('password',$password)
            ->update($request->only(['token']));
        }

        // get data with  the new token if updated  
        $owner= Owner::where( 'name', $owner->name)->where('password',$password)->first();
        // if $owner_name == nul: the user loged in with email
        // if $owner_email == null : the user loged with name 
        if($owner!=null){
            return new OwnerResource($owner); 
        }
        else{
            return response()->json(['flag'=>'0','errors'=>'user not found']);
        }
    }
    
    // public function login(Request $request){
    //     $validator = \Validator::make($request->all(), [
    //         'name' => 'required',
    //         // 'email' => 'required_without:name',
    //         'password' => 'required',
    //         'token' => 'required',
    //     ]);
        
    //     if ($validator->fails()) {
    //         return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
    //     }
    //     $name_email = $request->name;// may be  username or email 
    //     $password = $request->password ; 
    //     $token    = $request->token ;
    //     //select by name  
    //     if($o = DB::table('owners')->where( 'name', $name_email)->where('password',$password)->first()){
    //         $owner = $o ; 
    //     }
    //     // select by email 
    //     if($o = DB::table('owners')->where( 'email', $name_email)->where('password',$password)->first()){
    //         $owner = $o ;   
    //     }
    //     // update token if user open app from different device 
    //    if($owner && $owner->token != $token){
    //         Owner::where( 'name', $name)->where('password',$password)
    //         ->update($request->only(['token']));
    //    }
    //    // get data with  the new token if updated  
    //     $owner_name= Owner::where( 'name', $name_email)->where('password',$password)->first();
    //     $owner_email= Owner::where( 'email', $name_email)->where('password',$password)->first();
    //     // if $owner_name == nul: the user loged in with email
    //     // if $owner_email == null : the user loged with name 
    //     if($owner_name!=null){
    //         return new OwnerResource($owner_name); 
    //     }elseif($owner_email!=null){
    //         return new OwnerResource($owner_email); 
    //     }
    //     else{
    //         return response()->json(['flag'=>'0','errors'=>'user not found']);
    //     }
    // }
    
    public function send_mail_test (){
        return view('emails.send_mail_test');
    }
    public function send_mail(Request $request){
        // \Mail::to($request->email)->send(new DemoMail($request->email) ); 
        $email = $request->email;
        // dd($email) ;
        $owner= DB::table('owners')->where('email',$email)->first();  
        if($owner== null){
            return response()->json( [ 'flag'=>'0','errors' =>'owner not found' ]);
        }
        try{
            \Mail::to($email)->send(new DemoMail($request->email) );
            return response()->json( [ 'flag'=>'1'] , 201 );
        }catch(Exception $e){
            // report($e); 
            return response()->json( [ 'flag'=>'0'] );
        } 
        
        return ' we sent mail rest password ' ; 
    }
    public function reset_pass(Request $request){
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $pass = DB::table('owners')->where('email',$request->email)->update(['password'=>$request->password]);
        if($pass){ 
          return 'reset success' ;   
        }else {
            return "error reset" ; 
        }
    }
    
    public function signup (Request $request){
        
        $validator = \Validator::make($request->all(), [
            'name' => 'required|unique:owners',
            'password' => 'required',
            'email' => 'required|email|unique:owners',
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        if($owner = Owner::create($request->all())){
            // return new OwnerResource(Owner::where('name',$request->name)->where('password',$request->password)->first()); 
            return new OwnerResource($owner); 
        }else {
            return response()->json( [ 'flag'=>'0','errors'=>'can not create request'] , 400 );

        }
    }
    public function login_test (){
        return view('owner.login_test'); 
    }
    public function signup_test (){
        return view('owner.signup'); 
    }
}
