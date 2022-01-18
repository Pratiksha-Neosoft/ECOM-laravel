<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $req)
    {
        $data=new Contact();
        $data->name=$req->name;
        $data->email=$req->email;
        $data->subject=$req->subject;
        $data->message=$req->message;
        if($data->save())
        {   
            return response()->json(['msg'=>'We will Contact you soon!']);
        }
        return response()->json(['err'=>'error']);
    }
    public function viewEnquiries(){
        $enquiries = Contact::orderBy('id','Desc')->get();
        return view('admin.view_enquiries',compact('enquiries'));
    }
}
