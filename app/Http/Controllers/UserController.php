<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Mail\registerMailToUser;
use App\Mail\MailToAddUser;
use Illuminate\Support\Facades\Mail;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function index(Request $req){
        if($req->session()->has('LOGIN')){
            return redirect('admin/dashboard');
        }else{
        return view('admin.login');
        }
    }
    public function auth(Request $req){
        $validated=$req->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validated){
        $email=$req->email;
        $pass=$req->password;
        $result=User::where(['email'=>$email,'role_id'=>'1'])->first();
        if($result){
            if(Hash::check($pass, $result->password)){
                $req->session()->put('LOGIN',true);
                $req->session()->put('ID',$result->id);
                return redirect('admin/dashboard');
            }else{
                $req->session()->flash('error',"Please enter correct password!");
                return redirect('admin');
            }
        }
        else{
            $req->session()->flash('error','Please enter valid login details');
            return redirect('admin');
        }
        }
    }
    public function viewuser(){
        $users = DB::table('users')
        ->join('roles', 'users.role_id', '=', 'roles.role_id')
        ->select('users.*', 'roles.role_name as role')
        ->get();
        return view('admin.dashboard',compact('users'));
    }
    public function dashboard(){
        $usercnt=User::count();
        $ordercnt=OrderProduct::count();
        $productcnt=Product::count();
        return view('admin.index',["usercnt"=>$usercnt,"ordercnt"=>$ordercnt,"productcnt"=>$productcnt]);
    }
    public function adduser(){
        $roles=Role::all()->sortByDesc('role_id');
        return view('admin.adduser',compact("roles"));
    }
    public function postadduser(Request $req){
        $validated=$req->validate([
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8|max:12|confirmed',
            'password_confirmation'=>'required',
            'status'=>'required',
            'role'=>'required'
        ],[
            'fname.required'=>'The first name field is required.',
            'lname.required'=>'The last name field is required.',
            'password.regex'=>'Password Must be alphanumeric and between 8 to 12 characters.',
        ]);
        if($validated){
            $user=new User();
            $user->firstname=$req->fname;
            $user->lastname=$req->lname;
            $user->email=$req->email;
            $user->password=Hash::make($req->password);
            $user->status=$req->status;
            $user->role_id=$req->role;
            if($user->save()){
                Mail::to($req->email)->send(new MailToAddUser($req->all()));
                return redirect("admin/user/view");
            }

        }
    }
    public function updateuser($id){
        $user=User::find($id);
        $roles=Role::all();
        return view('admin.updateuser',compact(['user','roles']));
    }
    public function postupdateuser(Request $req){
        $validated=$req->validate([
            'fname'=>'required',
            'lname'=>'required',
            'email'=>'required|email',
            'status'=>'required',
            'role'=>'required'
        ],[
            'fname.required'=>'The first name field is required.',
            'lname.required'=>'The last name field is required.',
        ]);
        if($validated){
            $user=User::find($req->id);
            $user->firstname=$req->fname;
            $user->lastname=$req->lname;
            if($user->email!=$req->email){
                $emailval=$req->validate([
                    'email'=>'unique:users,email'
                ]);
                if($emailval){
                    $user->email=$req->email;
                }
            }
            $user->status=$req->status;
            $user->role_id=$req->role;
            if($user->save()){
                return redirect("admin/user/view");
            }

        }

    }
    public function deleteUser($id){
        $user=User::find($id);
        if($user->delete())
        return redirect('/admin/user/view');

    }
    //front end
    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        if(!$token=Auth::attempt($validator->validated())){
            return response()->json(['error'=>'unauthorized'],401);
        }
        return $this->createNewToken($token);
    }
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8|max:12|regex:/^[a-zA-Z]+[0-9]+$/|confirmed',
            'password_confirmation'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        $user=new User();
        $user->firstname=$request->first_name;
        $user->lastname=$request->last_name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        if($user->save()){
            return response()->json(['msg'=>'success']);
        }else{
            return response()->json(['err'=>'error']);
        }

    }
    public function createNewToken($token){
        return response()->json([
            'error'=>0,
            'access_token'=>$token,
            'token_type'=>'bearer',
            'email'=>auth()->user()->email,
            'expires_in'=>auth()->factory()->getTTL()*60
        ]);
    }
    public function refresh(){
        return $this->createNewToken(auth()->refresh());
    }
    public function logout(){
        auth()->logout();
        return response()->json(['msg','Logout successfully']);
    }
    public function exportCsv(Request $request)
    {
   $fileName = 'users.csv';
   $tasks = User::join('roles','roles.role_id','=','users.role_id')->get(['users.*','roles.role_name as role']);

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id', 'firstName', 'LastName', 'email', 'role');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                $row['Id']  = $task->id;
                $row['FirstName']    = $task->firstname;
                $row['LastName']    = $task->lastname;
                $row['email']  = $task->email;
                $row['role']  = $task->role;
                

                fputcsv($file, array($row['Id'], $row['FirstName'], $row['LastName'], $row['email'], $row['role']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function report(){
        return view('admin.report');
    }
}