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
    public function test(Owner $owner){
        // return $owner->bussines();
        // dd($bussines->owner()); 
        dd($owner->get_bussines(1)); 
    }
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
            //  update owner object  with  the new token if updated
            $owner->token = $token; 
        }


        // $owner= Owner::where( 'name', $owner->name)->where('password',$password)->first();
        
        // if $owner_name == nul: the user loged in with email
        // if $owner_email == null : the user loged with name 
        if($owner!=null){
            // dd($owner);
            return new OwnerResource($owner); 
        }
        else{
            return response()->json(['flag'=>'0','errors'=>'user not found']);
        }
    }
  
    
    public function send_mail_test (){
        return view('emails.send_mail_test');
    }
    public function send_mail(Request $request){
        $email = $request->email;
        $owner= DB::table('owners')->where('email',$email)->first();  
        
        if($owner== null){
            return response()->json( [ 'flag'=>'0','errors' =>'owner not found' ]);
        }
        try{
            Owner::find($owner->id)->update(['updated_at'=>date_create(now())]);
            \Mail::to($email)->send(new DemoMail($request->email) );
            return response()->json( [ 'flag'=>'1'] , 201 );
        }catch(Exception $e){
            throw new Exception("Error Processing Request", 1);
        } 
    }
    // return the rest page to enter new pass 
    public function reset_page(Request $request){
        $email = $request->email; 
        return view('owner.reset',compact('email')); 
    }
    // update  password in db
    public function reset_pass(Request $request){
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6',
        ]);
        $email =  $request->email;
        if($validator->fails()) {
            \Session::flash('status', 'Enter Password More Than 6 or Equal Letters !'); 
            return response()
            ->view('owner.reset', compact('email'));
        }
           
            // dd('in reste pass func');
        $updated_at = Owner::where('email',$request->email)->first(['updated_at']);
        $start  =$updated_at->updated_at ;
        $end 	= date_create(now()); // Current time and date
        $diff  	=  date_diff( $start, $end );
        if($diff->d >= 1 || $diff->h > 2 ){
            \Session::flash('status', 'you are reseting after 2 hours please  reset form application again!'); 
            return response()
            ->view('owner.reset', compact('email'));
        }            
        $reset = DB::table('owners')->where('email',$request->email)->update(['password'=>$request->password]);
        if($reset){ 
            \Session::flash('status', 'success!'); 
            return response()
            ->view('owner.reset', compact('email'));
        }else {
            \Session::flash('status', 'failed!'); 
            return response()
            ->view('owner.reset', compact('email'));
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
