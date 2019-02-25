<?php
/*
Project Name: IonicEcommerce
Project URI: http://ionicecommerce.com
Author: VectorCoder Team
Author URI: http://vectorcoder.com/

*/
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\App\CategoriesController;

use Validator;
use App;
use Lang;
use DB;
//for password encryption or hash protected
use Hash;
use App\Administrator;

//for authenitcate login data
use Auth;

//for requesting a value 
use Illuminate\Http\Request;
class AdminPartController extends Controller
{

    public function parts(Request $request){
        if(session('news_view')==0){
            print Lang::get("labels.You do not have to access this route");
        }else{
            $title = array('pageTitle' => Lang::get("labels.MainParts"));
            $parts = DB::table('part')->paginate(10);
            return view("admin.Part.parts",$title)->with('parts', $parts);
        }
    }

    public function getsubpartcategory(Request $request)
    {
        $language_id='1';
        $listingCategories = DB::table('part_categories')
            ->leftJoin('part_categories_description','part_categories_description.part_categories_id', '=', 'part_categories.part_categories_id')
            ->select('part_categories.part_categories_id as id', 'part_categories.part_categories_image as image',  'part_categories.date_added as date_added', 'part_categories.last_modified as last_modified', 'part_categories_description.part_categories_name as name', 'part_categories.part_categories_slug as slug')
            ->where('part_categories_description.language_id','=', $language_id )->where('part_parent_id', $request->id)->get();
        return($listingCategories) ;
    }
    public function getpart(Request $request)
    {
        $result=DB::table('part')->where('id_part_sub_category',$request->id)->get();
        return $result;
    }
    public function addpart(Request $request){
        if(session('news_view')==0){
            print Lang::get("labels.You do not have to access this route");
        }else{
            $title = array('pageTitle' => Lang::get("labels.Addpart"));
            $language_id      =   '1';

            $result = array();

            //get function from other controller
            $myVar = new AdminPartCategoriesController();
            $result['partCategories'] = $myVar->getCategories($language_id);

            //get function from other controller
            $myVar = new AdminSiteSettingController();
            $result['languages'] = $myVar->getLanguages();
            return view("admin.Part.addpart", $title)->with('result', $result);
        }
    }

    //addNewpart
    public function addnewpart(Request $request){
        if(session('news_create')==0){
            print Lang::get("labels.You do not have to access this route");
        }else{
            $title = array('pageTitle' => Lang::get("labels.Addpart"));
            $date_added	= date('Y-m-d h:i:s');

            //get function from other controller
            $myVar = new AdminSiteSettingController();
            $languages = $myVar->getLanguages();
            $extensions = $myVar->imageType();

            if($request->hasFile('part_image') and in_array($request->part_image->extension(), $extensions)){
                $image = $request->part_image;
                $fileName = time().'.'.$image->getClientOriginalName();
                $image->move('resources/assets/images/part_images/', $fileName);
                $uploadImage = 'resources/assets/images/part_images/'.$fileName;
            }else{
                $uploadImage = '';
            }
            $barcod='0';
            if(!is_null($request->barcode))
            {
                $barcod=$request->barcode;
            }

            DB::table('part')->insertGetId([
                'part_img'  			 =>   $uploadImage,
                'part_date_added'	 	 =>   $date_added,
                'part_title'		 	 =>   $request->part_title,
                'id_part_category'		 	 =>   $request->category_id,
                'id_part_sub_category'		 	 =>   $request->sub_category_id,
                'part_weight'		 	 =>   $request->part_weight,
                'part_fixed_price'		 	 =>   $request->part_fixed_price,
                'part_color'		 	 =>   $request->part_color,
                'part_pay_by'		 	 =>   $request->part_pay_by,
                'barcode'                  =>$barcod
            ]);


            $message = Lang::get("labels.parthasbeenaddedsuccessfully");
            return redirect()->back()->withErrors([$message]);
        }
    }

    //editnew
    public function editpart(Request $request)
    {
        if(session('news_view')==0){
            print Lang::get("labels.You do not have to access this route");
        }else{
            $title = array('pageTitle' => Lang::get("labels.Addpart"));
            $language_id      =   '1';

            $result = array();

            //get function from other controller
            $myVar = new AdminPartCategoriesController();
            $result['partCategories'] = $myVar->getCategories($language_id);
            $result['partsubCategories'] = $myVar->getSubCategories($language_id);
            //get function from other controller
            $myVar = new AdminSiteSettingController();
            $result['languages'] = $myVar->getLanguages();
            $result['part']= DB::table('part')->where('id', '=', $request->id)->get();
            }

        return view("admin.Part.editpart", $title)->with('result', $result);
    }

    //updatenew
    public function updatepart(Request $request){
        if(session('news_update')==0){
            print Lang::get("labels.You do not have to access this route");
        }else{
            $language_id      =   '1';
            $part_id      =   $request->id;
            $part_last_modified	= date('Y-m-d h:i:s');

            //get function from other controller
            $myVar = new AdminSiteSettingController();
            $languages = $myVar->getLanguages();
            $extensions = $myVar->imageType();

            //check slug
            if($request->old_slug!=$request->slug ){
                $slug = $request->slug;
                $slug_count = 0;
                do{
                    if($slug_count==0){
                        $currentSlug = $myVar->slugify($request->slug);
                    }else{
                        $currentSlug = $myVar->slugify($request->slug.'-'.$slug_count);
                    }
                    $slug = $currentSlug;
                    $checkSlug = DB::table('part')->where('part_slug',$currentSlug)->where('part_id','!=',$part_id)->get();
                    $slug_count++;
                }
                while(count($checkSlug)>0);

            }else{
                $slug = $request->slug;
            }

            if($request->hasFile('part_image') and in_array($request->part_image->extension(), $extensions)){
                $image = $request->part_image;
                $fileName = time().'.'.$image->getClientOriginalName();
                $image->move('resources/assets/images/part_images/', $fileName);
                $uploadImage = 'resources/assets/images/part_images/'.$fileName;
            }else{
                $a=DB::table('part')->where('id','=',$request->id)->get();
                $uploadImage = $a[0]->part_img;
            }
            $barcod='0';
            if(!is_null($request->barcode))
            {
                $barcod=$request->barcode;
            }

            DB::table('part')->where('id','=',$request->id)->update([
                'part_img'  			 =>   $uploadImage,
                'part_title'		 	 =>   $request->part_title,
                'id_part_category'		 	 =>   $request->category_id,
                'id_part_sub_category'		 	 =>   $request->sub_category_id,
                'part_weight'		 	 =>   $request->part_weight,
                'part_fixed_price'		 	 =>   $request->part_fixed_price,
                'part_color'		 	 =>   $request->part_color,
                'part_pay_by'		 	 =>   $request->part_pay_by,
                'barcode'                  =>$barcod
            ]);

            $message = Lang::get("labels.parthasbeenupdatedsuccessfully");
            return redirect()->back()->withErrors([$message]);
        }
    }

    //deletepart
    public function deletepart(Request $request){
        if(session('news_delete')==0){
            print Lang::get("labels.You do not have to access this route");
        }else{
            DB::table('part')->where('id', $request->id)->delete();
            return redirect()->back()->withErrors(['part has been deleted successfully!']);
        }
    }
}
