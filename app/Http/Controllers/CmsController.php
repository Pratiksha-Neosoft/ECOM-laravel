<?php

namespace App\Http\Controllers;

use App\Models\Cms;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function addCms(Request $request){
    	if($request->isMethod('post')){
            $validated=$request->validate([
                'title'=>'required',
                'body'=>'required',
                'image'=>'mimes:jpg,png,jpeg,gif'
            ]);
    		$data = $request->all();    		

    		$Cms = new Cms;
			$Cms->title = $data['title'];
			$Cms->body = $data['body'];


			// Upload Image
            if($request->hasfile('image'))
            {  
                    $f=$request->file('image');
                   $name = rand().time().'.'.$f->extension();
                   $f->move(public_path('images/frontend_images/Cms/'), $name);  
                   $Cms->image = $name; 
            }

			$Cms->save();
			return redirect('admin/view-cms')->with('flash_message_success', 'Cms has been added successfully');
    	}
    	
    	return view('admin.Cms.add_cms');
    }

    public function editCms(Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();
            $validated=$request->validate([
                'title'=>'required',
                'image'=>'mimes:jpg,png,jpeg,gif'
            ]);

            // Upload Image
            if($request->hasFile('image')){
                $f=$request->file('image');
                $name = rand().time().'.'.$f->extension();
                $f->move(public_path('images/frontend_images/Cms/'),
                 $name);  
            }else if(!empty($data['current_image'])){
                $name = $data['current_image'];
            }else{
                $name = '';
            }

            $xyz=Cms::where('id',$id)->update(['title'=>$data['title'],'body'=>$data['body'],'image'=>$name]);
            return redirect('admin/view-cms')->with('flash_message_success','Cms has been edited Successfully');

        }
        $CmsDetails = Cms::where('id',$id)->first();
        return view('admin.Cms.update_cms')->with(compact('CmsDetails'));
    }

    public function viewCms(){
        $content = Cms::get();
        return view('admin.Cms.view_cms')->with(compact('content'));
    }

    public function deleteCms($id = null){
        Cms::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Cms has been deleted successfully');
    }

    //front end
    public function Cmss(){
        $data=Cms::all();
        return response()->json(['Cms'=>$data]);
    }
}
