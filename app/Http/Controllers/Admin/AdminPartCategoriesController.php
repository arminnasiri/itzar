<?php
/*
Project Name: IonicEcommerce
Project URI: http://ionicecommerce.com
Author: VectorCoder Team
Author URI: http://vectorcoder.com/

*/
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


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


class AdminPartCategoriesController extends Controller
{
	public function allCategories($language_id){
		$part_categories = DB::table('part_categories')
		->leftJoin('part_categories_description','part_categories_description.part_categories_id', '=', 'part_categories.part_categories_id')
		->select('part_categories.part_categories_id as id', 'part_categories.part_categories_image as image',  'part_categories.date_added as date_added', 'part_categories.last_modified as last_modified', 'part_categories_description.part_categories_name as name', 'part_categories.part_categories_slug as slug')
		->where('part_categories_description.language_id','=', $language_id )->where('parent_id', '0')->get();
		
		$results = array();
		$index = 0;
		foreach($part_categories  as $category){
			array_push($results,$category);
			
			$subCategories = DB::table('part_categories')
			->leftJoin('part_categories_description','part_categories_description.part_categories_id', '=', 'part_categories.part_categories_id')
			->select('part_categories.part_categories_id as sub_id', 'part_categories.part_categories_image as sub_image',  'part_categories.date_added as sub_date_added', 'part_categories.last_modified as sub_last_modified', 'part_categories_description.part_categories_name as sub_name', 'part_categories.part_categories_slug as sub_slug')
			->where('part_categories_description.language_id','=', $language_id )->where('parent_id', $category->id)->get();
			$results[$index]->sub_part_categories = $subCategories;
			$index++;
		}	
		return($results);		
	}
	
	public function getCategories($language_id){
		
		$listingCategories = DB::table('part_categories')
		->leftJoin('part_categories_description','part_categories_description.part_categories_id', '=', 'part_categories.part_categories_id')
		->select('part_categories.part_categories_id as id', 'part_categories.part_categories_image as image',  'part_categories.date_added as date_added', 'part_categories.last_modified as last_modified', 'part_categories_description.part_categories_name as name', 'part_categories.part_categories_slug as slug')
		->where('part_categories_description.language_id','=', $language_id )->where('part_parent_id', '0')->get();
		return($listingCategories) ;
	}
	
	public function getSubCategories($language_id){
		
		$language_id     =   $language_id;		
		$listingCategories = DB::table('part_categories')
		->leftJoin('part_categories_description','part_categories_description.part_categories_id', '=', 'part_categories.part_categories_id')
		->select('part_categories.part_categories_id as id', 'part_categories.part_categories_image as image',  'part_categories.date_added as date_added', 'part_categories.last_modified as last_modified', 'part_categories_description.part_categories_name as name', 'part_categories.part_categories_slug as slug')
		->where('part_categories_description.language_id','=', $language_id )->where('part_parent_id','>', '0')->get();
		return($listingCategories);
	}
	
	public function categories(){
		if(session('categories_view')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$title = array('pageTitle' => Lang::get("labels.MainCategories"));
		
		$part_categories = DB::table('part_categories')
		->leftJoin('part_categories_description','part_categories_description.part_categories_id', '=', 'part_categories.part_categories_id')
		->select('part_categories.part_categories_id as id', 'part_categories.part_categories_image as image',  'part_categories.part_categories_icon as icon',  'part_categories.date_added as date_added', 'part_categories.last_modified as last_modified', 'part_categories_description.part_categories_name as name', 'part_categories_description.language_id')
		->where('part_parent_id', '0')->where('part_categories_description.language_id', '1')->paginate(10);
		
		return view("admin.part_category.categories",$title)->with('part_categories', $part_categories);
		}
	}
	
	//add category
	public function addcategory(Request $request){
		$title = array('pageTitle' => Lang::get("labels.AddCategories"));
		
		$result = array();
		$result['message'] = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		return view("admin.part_category.addcategory",$title)->with('result', $result);
	}
	
	//addNewCategory	
	public function addnewcategory(Request $request){
		if(session('categories_create')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$title = array('pageTitle' => Lang::get("labels.AddCategories"));
		
		$result = array();
		$date_added	= date('y-m-d h:i:s');
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();		
		$extensions = $myVar->imageType();		
		
		if($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/category_images/', $fileName);
			$uploadImage = 'resources/assets/images/category_images/'.$fileName; 
		}	else{
			$uploadImage = '';
		}	
		
		if($request->hasFile('newIcon') and in_array($request->newIcon->extension(), $extensions)){
			$icon = $request->newIcon;
			$iconName = time().'.'.$icon->getClientOriginalName();
			$icon->move('resources/assets/images/category_icons/', $iconName);
			$uploadIcon = 'resources/assets/images/category_icons/'.$iconName; 
		}	else{
			$uploadIcon = '';
		}	
		
		$part_categories_id = DB::table('part_categories')->insertGetId([
					'part_categories_image'   =>   $uploadImage,
					'date_added'		 =>   $date_added,
					'part_parent_id'		 	 =>   '0',
					'part_categories_icon'	 =>	  $uploadIcon
					]);
					
		$slug_flag = false;
		//multiple lanugauge with record 
		foreach($languages as $languages_data){
			$categoryName= 'categoryName_'.$languages_data->languages_id;

			//slug
			if($slug_flag==false){
				$slug_flag=true;
				
				$slug = $request->$categoryName;
				$old_slug = $request->$categoryName;
				
				$slug_count = 0;
				do{
					if($slug_count==0){
						$currentSlug = $myVar->slugify($slug);
					}else{
						$currentSlug = $myVar->slugify($old_slug.'-'.$slug_count);
					}
					$slug = $currentSlug;
					//$checkSlug = DB::table('part_categories')->where('part_categories_slug',$currentSlug)->where('part_categories_id','!=',$request->id)->get();
					$checkSlug = DB::table('part_categories')->where('part_categories_slug',$currentSlug)->get();
					$slug_count++;
				}
				while(count($checkSlug)>0);
				DB::table('part_categories')->where('part_categories_id',$part_categories_id)->update([
					'part_categories_slug'	 =>   $slug
					]);
			}
				
			DB::table('part_categories_description')->insert([
					'part_categories_name'   =>   $request->$categoryName,
					'part_categories_id'     =>   $part_categories_id,
					'language_id'       =>   $languages_data->languages_id
				]);
		}		
				
		$message = Lang::get("labels.CategoriesAddedMessage");
				
		return redirect()->back()->withErrors([$message]);
		}
	}
	
	//editCategory
	public function editcategory(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.EditMainCategories"));
		$result = array();		
		$result['message'] = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		$editCategory = DB::table('part_categories')
		->select('part_categories.part_categories_id as id', 'part_categories.part_categories_image as image', 'part_categories.part_categories_icon as icon',  'part_categories.date_added as date_added', 'part_categories.last_modified as last_modified', 'part_categories.part_categories_slug as slug')
		
		->where('part_categories.part_categories_id', $request->id)->get();
		
		$description_data = array();		
		foreach($result['languages'] as $languages_data){
			
			$description = DB::table('part_categories_description')->where([
					['language_id', '=', $languages_data->languages_id],
					['part_categories_id', '=', $request->id],
				])->get();
				
			if(count($description)>0){								
				$description_data[$languages_data->languages_id]['name'] = $description[0]->part_categories_name;
				$description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
				$description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;										
			}else{
				$description_data[$languages_data->languages_id]['name'] = '';
				$description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
				$description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;	
			}
		}
		$result['description'] = $description_data;	
		$result['editCategory'] = $editCategory;		
		
		return view("admin.part_category.editcategory", $title)->with('result', $result);
	}
	
	//updateCategory
	public function updatecategory(Request $request){		
		if(session('part_categories_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$title = array('pageTitle' => Lang::get("labels.EditMainCategories"));
		$last_modified 	=   date('y-m-d h:i:s');
		$part_categories_id = $request->id;
		$result = array();					
		
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
				$checkSlug = DB::table('part_categories')->where('part_categories_slug',$currentSlug)->where('part_categories_id','!=',$request->id)->get();
				$slug_count++;
			}
			
			while(count($checkSlug)>0);		
			
		}else{
			$slug = $request->slug;
		}
		
		if($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/category_images/', $fileName);
			$uploadImage = 'resources/assets/images/category_images/'.$fileName; 
		}else{
			$uploadImage = $request->oldImage;
		}
		
		if($request->hasFile('newIcon') and in_array($request->newIcon->extension(), $extensions)){
			$icon = $request->newIcon;
			$iconName = time().'.'.$icon->getClientOriginalName();
			$icon->move('resources/assets/images/category_icons/', $iconName);
			$uploadIcon = 'resources/assets/images/category_icons/'.$iconName; 
		}	else{
			$uploadIcon = $request->oldIcon;
		}
		
		
		DB::table('part_categories')->where('part_categories_id', $request->id)->update([
			'part_categories_image'   =>   $uploadImage,
			'last_modified'   	 =>   $last_modified,
			'part_categories_icon'    =>   $uploadIcon,
			'part_categories_slug'	 =>   $slug
			]);
		
		foreach($languages as $languages_data){
			$part_categories_name = 'category_name_'.$languages_data->languages_id;
			
			$checkExist = DB::table('part_categories_description')->where('part_categories_id','=',$part_categories_id)->where('language_id','=',$languages_data->languages_id)->get();			
			if(count($checkExist)>0){
				DB::table('part_categories_description')->where('part_categories_id','=',$part_categories_id)->where('language_id','=',$languages_data->languages_id)->update([
					'part_categories_name'  	    		 =>   $request->$part_categories_name,
					]);
			}else{
				DB::table('part_categories_description')->insert([
					'part_categories_name'  	     =>   $request->$part_categories_name,
					'language_id'			 =>   $languages_data->languages_id,
					'part_categories_id'			 =>   $part_categories_id,
					]);
			}
		}
		
		$message = Lang::get("labels.CategoriesUpdateMessage");
		return redirect()->back()->withErrors([$message]);
		}
	}
	
	
	//delete category
	public function deletecategory(Request $request){
		if(session('categories_delete')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
		
		DB::table('part_categories')->where('part_categories_id', $request->id)->delete();
		DB::table('part_categories_description')->where('part_categories_id', $request->id)->delete();
		
		$listingCategories = DB::table('part_categories')
		->leftJoin('part_categories_description','part_categories_description.part_categories_id', '=', 'part_categories.part_categories_id')
		->select('part_categories.part_categories_id as id', 'part_categories.part_categories_image as image',  'part_categories.date_added as date_added', 'part_categories.last_modified as last_modified', 'part_categories_description.part_categories_name as name')
		->where('part_parent_id', '0')->get();
		
		$message = Lang::get("labels.CategoriesDeleteMessage");
				
		return redirect()->back()->withErrors([$message]);
		}
	}
	
	
	
	//sub part_categories
	public function subcategories(){
		if(session('categories_view')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$title = array('pageTitle' => Lang::get("labels.SubCategories"));
		
		$listingSubCategories = DB::table('part_categories as subCategories')
		->leftJoin('part_categories_description as subCategoryDesc','subCategoryDesc.part_categories_id', '=', 'subCategories.part_categories_id')
		
		->leftJoin('part_categories as mainCategory','mainCategory.part_categories_id', '=', 'subCategories.part_categories_id')
		->leftJoin('part_categories_description as mainCategoryDesc','mainCategoryDesc.part_categories_id', '=', 'mainCategory.part_parent_id')
		
		->select(
			'subCategories.part_categories_id as subId',
			'subCategories.part_categories_image as image',
			'subCategories.part_categories_icon as icon',
			'subCategories.date_added as date_added',
			'subCategories.last_modified as last_modified',
			'subCategoryDesc.part_categories_name as subCategoryName',
			'mainCategoryDesc.part_categories_name as mainCategoryName',
			'subCategoryDesc.language_id'
			)
		->where('subCategories.part_parent_id', '>', '0')->where('subCategoryDesc.language_id', '1')->where('mainCategoryDesc.language_id', '1')->orderBy('subId','ASC')->paginate(20);
		
		return view("admin.part_category.subcategories",$title)->with('listingSubCategories', $listingSubCategories);
		}
	}
	
	//addsubcategory
	public function addsubcategory(Request $request){		
		$title = array('pageTitle' => Lang::get("labels.AddSubCategories"));
		$result = array();
		$result['message'] = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		$part_categories = DB::table('part_categories')
		->leftJoin('part_categories_description','part_categories_description.part_categories_id', '=', 'part_categories.part_categories_id')
		->select('part_categories.part_categories_id as mainId', 'part_categories_description.part_categories_name as mainName')
		->where('part_parent_id', '0')->where('language_id','=', 1)->get();
		$result['part_categories'] = $part_categories;
		
		return view("admin.part_category.addsubcategory",$title)->with('result', $result);
	}
	
	
	//addNewsubcategory
	public function addnewsubcategory(Request $request){
		if(session('categories_create')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$title = array('pageTitle' => Lang::get("labels.AddSubCategories"));
		$date_added	= date('y-m-d h:i:s');
		$result = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();		
		$extensions = $myVar->imageType();
		
		$categoryName = $request->categoryName;
		$parent_id = $request->parent_id;
		
		if($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/category_images/', $fileName);
			$uploadImage = 'resources/assets/images/category_images/'.$fileName; 
		}else{
			$uploadImage = '';
		}
		
		if($request->hasFile('newIcon') and in_array($request->newIcon->extension(), $extensions)){
			$icon = $request->newIcon;
			$iconName = time().'.'.$icon->getClientOriginalName();
			$icon->move('resources/assets/images/category_icons/', $iconName);
			$uploadIcon = 'resources/assets/images/category_icons/'.$iconName; 
		}	else{
			$uploadIcon = '';
		}		
		
		$part_categories_id = DB::table('part_categories')->insertGetId([
					'part_categories_image'   =>   $uploadImage,
					'date_added'		 =>   $date_added,
					'part_parent_id'		 	 =>   $parent_id,
					'part_categories_icon'	 =>	  $uploadIcon
					]);
		
		$slug_flag = false;			
		//multiple lanugauge with record 
		foreach($languages as $languages_data){
			$categoryName= 'categoryName_'.$languages_data->languages_id;
			
			//slug
			if($slug_flag==false){
				$slug_flag=true;
				
				$slug = $request->$categoryName;
				$old_slug = $request->$categoryName;
				$slug_count = 0;
				do{
					if($slug_count==0){
						$currentSlug = $myVar->slugify($old_slug);
					}else{
						$currentSlug = $myVar->slugify($old_slug.'-'.$slug_count);
					}
					$slug = $currentSlug;
					$checkSlug = DB::table('part_categories')->where('part_categories_slug',$currentSlug)->get();
					$slug_count++;
				}
				while(count($checkSlug)>0);
				DB::table('part_categories')->where('part_categories_id',$part_categories_id)->update([
					'part_categories_slug'	 =>   $slug
					]);
			}			
				
			DB::table('part_categories_description')->insert([
					'part_categories_name'   =>   $request->$categoryName,
					'part_categories_id'     =>   $part_categories_id,
					'language_id'       =>   $languages_data->languages_id
				]);
		}	
		
				
		$part_categories = DB::table('part_categories')
		->leftJoin('part_categories_description','part_categories_description.part_categories_id', '=', 'part_categories.part_categories_id')
		->select('part_categories.part_categories_id as mainId', 'part_categories_description.part_categories_name as mainName')
		->where('part_parent_id', '0')->get();
		
		$result['part_categories'] = $part_categories;
		
		$message = Lang::get("labels.AddSubCategoryMessage");
				
		return redirect()->back()->withErrors([$message]);
		}
	}
	
	
	
	public function editsubcategory(Request $request){
		
		$title = array('pageTitle' => Lang::get("labels.EditSubCategories"));
		$result = array();
		$result['message'] = array();
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$result['languages'] = $myVar->getLanguages();
		
		$editSubCategory = DB::table('part_categories')
		->select('part_categories.part_categories_id as id', 'part_categories.part_categories_image as image', 'part_categories.part_categories_icon as icon',  'part_categories.date_added as date_added', 'part_categories.last_modified as last_modified', 'part_categories.part_categories_slug as slug', 'part_categories.part_parent_id as parent_id')
		->where('part_categories.part_categories_id', $request->id)->get();
		
		$description_data = array();		
		foreach($result['languages'] as $languages_data){
			
			$description = DB::table('part_categories_description')->where([
					['language_id', '=', $languages_data->languages_id],
					['part_categories_id', '=', $request->id],
				])->get();
				
			if(count($description)>0){								
				$description_data[$languages_data->languages_id]['name'] = $description[0]->part_categories_name;
				$description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
				$description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;										
			}else{
				$description_data[$languages_data->languages_id]['name'] = '';
				$description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
				$description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;	
			}
		}
		
		$result['description'] = $description_data;
		
		$part_categories = DB::table('part_categories')
		->leftJoin('part_categories_description','part_categories_description.part_categories_id', '=', 'part_categories.part_categories_id')
		->select('part_categories.part_categories_id as mainId', 'part_categories_description.part_categories_name as mainName')
		->where('part_parent_id', '0')->where('language_id','=', 1)->get();
		
		$result['editSubCategory'] = $editSubCategory;
		$result['part_categories'] = $part_categories;
		
		return view("admin.part_category.editsubcategory",$title)->with('result', $result);
	}
	
	
	//updatesubcategory
	public function updatesubcategory(Request $request){
		if(session('categories_update')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		$title = array('pageTitle' => Lang::get("labels.EditSubCategories"));
		$result = array();
		$result['message'] = Lang::get("labels.Sub category has been updated successfully");
		$last_modified 	=   date('y-m-d h:i:s');
		$parent_id = $request->parent_id;
		$part_categories_id = $request->id;
		
		//get function from other controller
		$myVar = new AdminSiteSettingController();
		$languages = $myVar->getLanguages();		
		$extensions = $myVar->imageType();
				
		//check slug
		if($request->old_slug!=$request->slug){
			
			$slug = $request->slug;
			$slug_count = 0;
			do{
				if($slug_count==0){
					$currentSlug = $myVar->slugify($request->slug);
				}else{
					$currentSlug = $myVar->slugify($request->slug.'-'.$slug_count);
				}
				$slug = $currentSlug;
				$checkSlug = DB::table('part_categories')->where('part_categories_slug',$currentSlug)->where('part_categories_id','!=',$request->id)->get();
				$slug_count++;
			}
			
			while(count($checkSlug)>0);		
			
		}else{
			$slug = $request->slug;
		}
		
		
		if($request->hasFile('newImage') and in_array($request->newImage->extension(), $extensions)){
			$image = $request->newImage;
			$fileName = time().'.'.$image->getClientOriginalName();
			$image->move('resources/assets/images/category_images/', $fileName);
			$uploadImage = 'resources/assets/images/category_images/'.$fileName; 
		}else{
			$uploadImage = $request->oldImage;
		}
		
		if($request->hasFile('newIcon') and in_array($request->newIcon->extension(), $extensions)){
			$icon = $request->newIcon;
			$iconName = time().'.'.$icon->getClientOriginalName();
			$icon->move('resources/assets/images/category_icons/', $iconName);
			$uploadIcon = 'resources/assets/images/category_icons/'.$iconName; 
		}	else{
			$uploadIcon = $request->oldIcon;
		}
		
		DB::table('part_categories')->where('part_categories_id', $request->id)->update(
		[
			'part_categories_image'   =>   $uploadImage,
			'part_categories_icon'    =>   $uploadIcon,
			'last_modified'  	 =>   $last_modified,
			'part_parent_id' 		 =>   $parent_id,
			'part_categories_slug'    =>   $slug,
		]);
		
		foreach($languages as $languages_data){
			$part_categories_name = 'category_name_'.$languages_data->languages_id;
			
			$checkExist = DB::table('part_categories_description')->where('part_categories_id','=',$part_categories_id)->where('language_id','=',$languages_data->languages_id)->get();			
			if(count($checkExist)>0){
				DB::table('part_categories_description')->where('part_categories_id','=',$part_categories_id)->where('language_id','=',$languages_data->languages_id)->update([
					'part_categories_name'  	    		 =>   $request->$part_categories_name,
					]);
			}else{
				DB::table('part_categories_description')->insert([
					'part_categories_name'  	     =>   $request->$part_categories_name,
					'language_id'			 =>   $languages_data->languages_id,
					'part_categories_id'			 =>   $part_categories_id,
					]);
			}
		}
		
		$message = Lang::get("labels.SubCategorieUpdateMessage");
		return redirect()->back()->withErrors([$message]);
		}
		
	}
	
	//delete sub category
	public function deletesubcategory(Request $request){
		if(session('part_categories_delete')==0){
			print Lang::get("labels.You do not have to access this route");
		}else{
			
		DB::table('part_categories')->where('part_categories_id', $request->id)->delete();
		DB::table('part_categories_description')->where('part_categories_id', $request->id)->delete();
		
		$message = Lang::get("labels.SubCategorieDeleteMessage");
		return redirect()->back()->withErrors([$message]);
		}
	}
	
	public function getajaxpart_categories(Request $request){
		$language_id 	 = '1';
		
		if(empty($request->category_id)){
			$category_id	= '0';
		}else{
			$category_id	=   $request->category_id;
		}
		
		$getCategories = DB::table('part_categories')
		->leftJoin('part_categories_description','part_categories_description.part_categories_id', '=', 'part_categories.part_categories_id')
		->select('part_categories.part_categories_id as id', 'part_categories.part_categories_image as image',  'part_categories.date_added as date_added', 'part_categories.last_modified as last_modified', 'part_categories_description.part_categories_name as name')
		->where('part_parent_id', $category_id)->where('part_categories_description.language_id', $language_id)->get();
		return($getCategories) ;
	}

    public function getpartCategories($language_id)
    {
    }
}
