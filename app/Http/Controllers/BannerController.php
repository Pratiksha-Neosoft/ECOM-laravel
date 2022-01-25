<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function addBanner(Request $request){
    	if($request->isMethod('post')){
            $validated=$request->validate([
                'title'=>'required',
                'image'=>'required|mimes:jpg,png,jpeg,gif'
            ]);
    		$data = $request->all();
    		

    		$banner = new Banner;
			$banner->title = $data['title'];
			$banner->description = $data['description'];

            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }

			// Upload Image
            if($request->hasfile('image'))
            {  
                    $f=$request->file('image');
                   $name = rand().time().'.'.$f->extension();
                   $f->move(public_path('images/frontend_images/banners/'), $name);  
                   $banner->image = $name; 
            }

            $banner->status = $status;
			$banner->save();
			return redirect('admin/view-banners')->with('flash_message_success', 'Banner has been added successfully');
    	}
    	
    	return view('admin.banners.add_banner');
    }

    public function editBanner(Request $request, $id=null){
        if($request->isMethod('post')){
            $validated=$request->validate([
                'title'=>'required',
                'image'=>'required|mimes:jpg,png,jpeg,gif'
            ]);
            $data = $request->all();
            if(empty($data['status'])){
                $status='0';
            }else{
                $status='1';
            }

            if(empty($data['title'])){
                $data['title'] = '';
            }

            if(empty($data['description'])){
                $data['description'] = '';
            }

            // Upload Image
            if($request->hasFile('image')){
                $f=$request->file('image');
                $name = rand().time().'.'.$f->extension();
                $f->move(public_path('images/frontend_images/banners/'),
                 $name);  
            }else if(!empty($data['current_image'])){
                $name = $data['current_image'];
            }else{
                $name = '';
            }


            Banner::where('id',$id)->update(['status'=>$status,'title'=>$data['title'],'description'=>$data['description'],'image'=>$name]);
            return redirect('admin/view-banners')->with('flash_message_success','Banner has been edited Successfully');

        }
        $bannerDetails = Banner::where('id',$id)->first();
        return view('admin.banners.update_banner')->with(compact('bannerDetails'));
    }

    public function viewBanners(){
        $banners = Banner::get();
        return view('admin.banners.view_banners')->with(compact('banners'));
    }

    public function deleteBanner($id = null){
        Banner::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Banner has been deleted successfully');
    }

    //front end
    public function banners(){
        $data=Banner::where('status',1)->get();
        return response()->json(['banner'=>$data]);
    }
}
