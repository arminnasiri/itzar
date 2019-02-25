<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class Admin_Group_Customer extends Controller
{
    public function all_customer_group(){
            $customer_group = DB::table('customer_group')->pluck('slug_title_customer_group');
            return($customer_group);
    }
    public function customer_groups(){
        //if(session('customer_group_view')==0){
        //    print Lang::get("labels.You do not have to access this route");
        // }else{

        $title = array('pageTitle' => Lang::get("labels.Main_customer_group"));
        $customer_group_description=DB::table('customer_group_description')->get();
        $customer_groups = DB::table('customer_group')->paginate(10);
        return view("admin.customer_group.customer_group",$title)->with(['customer_groups'=> $customer_groups,'customer_group_description'=>$customer_group_description]);
        // }
    }
    public function add_customer_groups(){
        //if(session('customer_group_view')==0){
        //    print Lang::get("labels.You do not have to access this route");
        // }else{
        $result = array();
        $result['message'] = array();
        //get function from other controller
        $myVar = new AdminSiteSettingController();
        $result['languages'] = $myVar->getLanguages();
        $title = array('pageTitle' => Lang::get("labels.Main_customer_group"));
        return view("admin.customer_group.add_customer_group",$title)->with('result', $result);
        // }
    }
    public function story_customer_group(Request $request){
        if(session('categories_create')==0){
            print Lang::get("labels.You do not have to access this route");
        }else{
            $date_added	= date('y-m-d h:i:s');
            //get function from other controller
            $myVar = new AdminSiteSettingController();
            $languages = $myVar->getLanguages();
            if($request->input('is_teammate')=="on")
            {
                $is_teammate=1;
            }
            else{
                $is_teammate=0;
            }
            $group_id = DB::table('customer_group')->insertGetId([
                'profit_customer_group'		 =>   $request->input('customer_group_profit'),
                'tax_customer_group'		 	 => $request->input('customer_group_tax'),
                'payment_customer_group'	 =>	  $request->input('payment'),
                'is_teammate'	 =>	  $is_teammate
            ]);

            $slug_flag = false;
            //multiple lanugauge with record
            foreach($languages as $languages_data){
                $group_title= 'customer_group_title_'.$languages_data->languages_id;

                //slug
                if($slug_flag==false){
                    $slug_flag=true;

                    $slug = $request->$group_title;
                    $old_slug = $request->$group_title;
                    $slug_count = 0;
                    do{
                        if($slug_count==0){
                            $currentSlug = $myVar->slugify($slug);
                        }else{
                            $currentSlug = $myVar->slugify($old_slug.'-'.$slug_count);
                        }
                        $slug = $currentSlug;
                        //$checkSlug = DB::table('categories')->where('categories_slug',$currentSlug)->where('categories_id','!=',$request->id)->get();
                        $checkSlug = DB::table('customer_group')->where('slug_title_customer_group',$currentSlug)->get();
                        $slug_count++;
                    }
                    while(count($checkSlug)>0);
                    DB::table('customer_group')->where('customers_group_id',$group_id)->update([
                        'slug_title_customer_group'	 =>   $slug
                    ]);
                }
                DB::table('customer_group_description')->insert([
                    'customers_group_title'   =>   $request->$group_title,
                    'customers_group_id'     =>   $group_id,
                    'language_id'       =>   $languages_data->languages_id
                ]);
            }

            $message = Lang::get("labels.GroupAddedMessage");
            return redirect()->back()->withErrors([$message]);
        }
    }
    public function edit_customer_group($id){
        if(session('categories_create')==0){
            print Lang::get("labels.You do not have to access this route");
        }
        $result = array();
        $result['message'] = array();
        //get function from other controller
        $myVar = new AdminSiteSettingController();
        $result['languages'] = $myVar->getLanguages();
        $customer_group = DB::table('customer_group')->where('customers_group_id',$id)->get();
        $customer_group_description=DB::table('customer_group_description')->where('customers_group_id',$id)->get();
        $title = array('pageTitle' => Lang::get("labels.Main_customer_group"));
        return view('admin.customer_group.edit_customer_group',$title,compact('customer_group','result','customer_group_description'));
    }
    public function update_customer_group(Request $request){
        if(session('categories_create')==0){
            print Lang::get("labels.You do not have to access this route");
        }
        $date_added	= date('y-m-d h:i:s');
        //get function from other controller
        $myVar = new AdminSiteSettingController();
        $languages = $myVar->getLanguages();
        if($request->input('is_teammate')=="on")
        {
            $is_teammate=1;
        }
        else{
            $is_teammate=0;
        }
                if ($request->input('is_teammate') == "on") {
                    $is_teammate = 1;
                }
                else
                    {
                    $is_teammate = 0;
                }
        $slug_flag = false;
        //multiple lanugauge with record
        foreach($languages as $languages_data){
            $group_title= 'customer_group_title_'.$languages_data->languages_id;

            //slug
            if($slug_flag==false){
                $slug_flag=true;

                $slug = $request->$group_title;
                $old_slug = $request->$group_title;
                $slug_count = 0;
                do{
                    if($slug_count==0){
                        $currentSlug = $myVar->slugify($slug);
                    }else{
                        $currentSlug = $myVar->slugify($old_slug.'-'.$slug_count);
                    }
                    $slug = $currentSlug;
                    //$checkSlug = DB::table('categories')->where('categories_slug',$currentSlug)->where('categories_id','!=',$request->id)->get();
                    $checkSlug = DB::table('customer_group')->where('slug_title_customer_group',$currentSlug)->get();
                    $slug_count++;
                }
                while(count($checkSlug)>0);
            }
            DB::table('customer_group_description')->where('customers_group_id', $request->input('id'))->update(['customers_group_title'   =>   $request->$group_title]);
        }

                DB::table('customer_group')->where('customers_group_id', $request->input('id'))->update([
                    'profit_customer_group' => $request->input('customer_group_profit'),
                    'tax_customer_group' => $request->input('customer_group_tax'),
                    'payment_customer_group' => $request->input('payment'),
                    'slug_title_customer_group' =>$slug,
                    'is_teammate' => $is_teammate]);
        $message = Lang::get("labels.Group");
        return redirect()->back()->withErrors([$message]);

        }

    public function delete_customer_group($id)
    {
        DB::table('customer_group')->where('customers_group_id', $id)->delete();
        $message = Lang::get("labels.Group_delete");
        return redirect()->back()->withErrors([$message]);
    }
    }
