@extends('admin.layout')
@section('content')
    <style>
        .container {
            width: 100%;
            height: auto;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;

        }

        .element {
            width: 60%;
            background-color: rgba(0, 0, 0, 0.11);
            border: 1px solid #e2e2e2;
            border-radius: 5px;
            padding: 15px;
            box-sizing: border-box;
            display: flex;
            direction: rtl;
            justify-content: space-evenly;
            margin-bottom: 10px;
        }

        .item {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;

        }

        .se {
            width: 50%;
            outline: none;
            border: none;
            padding: 5px;
            margin: 0 0.5em;
        }

        .item__sp1, .item__sp2 {
            margin: 0 0.3em;
            font-size: 1.2em;
        }

        .item__sp1 {
            color: #90cc79;
        }

        .item__sp2 {
            color: #cc0b17;
        }

    </style>
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.AddProduct') }} <small>{{ trans('labels.AddProduct') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/products')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.ListingAllProducts') }}</a></li>
      <li class="active">{{ trans('labels.AddProduct') }}</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content"> 
    <!-- Info boxes --> 
    
    <!-- /.row -->

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.AddNewProduct') }} </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
                    <div class="box box-info">
                        <!-- form start -->                        
                         <div class="box-body">
                          @if( count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">{{ trans('labels.Error') }}:</span>
                                    {{ $error }}
                                </div>
                             @endforeach
                          @endif
                        
                            {!! Form::open(array('url' =>'admin/addnewproduct', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}             
                            	<div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Product Type') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control field-validate prodcust-type" name="products_type" onChange="prodcust_type();">
                                          <option value="">{{ trans('labels.Choose Type') }}</option> 
                                          <option value="0">{{ trans('labels.Simple') }}</option>
                                          <option value="1">{{ trans('labels.Variable') }}</option>
                                          <option value="2">{{ trans('labels.External') }}</option>
                                      </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.Product Type Text') }}.</span>
                                  </div>
                                </div>
                                
                                <hr>                                           
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Category') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                  @if(!empty(session('categories_id')))
										@php
                                        $cat_array = explode(',', session('categories_id'));                                        
                                        @endphp
                                        <ul class="list-group list-group-root well">    
                                          @foreach ($result['categories'] as $categories)   
                                          @if(in_array($categories->id,$cat_array))                                 
                                          <li href="#" class="list-group-item"><label style="width:100%"><input id="categories_<?=$categories->id?>" type="checkbox" class=" required_one categories" name="categories[]" value="{{ $categories->id }}" > {{ $categories->name }}</label></li>
                                          @endif
                                              @if(!empty($categories->sub_categories))
                                              <ul class="list-group">
                                                    	<li class="list-group-item" >
                                                    @foreach ($categories->sub_categories as $sub_category)
                                                    @if(in_array($sub_category->sub_id,$cat_array))  
                                                    <label><input type="checkbox" name="categories[]" class="required_one sub_categories sub_categories_<?=$categories->id?>" parents_id = '<?=$categories->id?>' value="{{ $sub_category->sub_id }}"> {{ $sub_category->sub_name }}</label> @endif @endforeach</li>
                                                    
                                              </ul>
                                              @endif
                                          @endforeach                                          
                                        </ul>                                           
                                  @else
                                   <ul class="list-group list-group-root well">    
                                      @foreach ($result['categories'] as $categories)                                    
                                      <li href="#" class="list-group-item"><label style="width:100%"><input id="categories_<?=$categories->id?>" type="checkbox" class=" required_one categories" name="categories[]" value="{{ $categories->id }}" > {{ $categories->name }}</label></li>
                                          @if(!empty($categories->sub_categories))
                                          <ul class="list-group">
                                                    <li class="list-group-item" >
                                                @foreach ($categories->sub_categories as $sub_category)<label><input type="checkbox" name="categories[]" class="required_one sub_categories sub_categories_<?=$categories->id?>" parents_id = '<?=$categories->id?>' value="{{ $sub_category->sub_id }}"> {{ $sub_category->sub_name }}</label>@endforeach</li>
                                                
                                          </ul>
                                          @endif
                                      @endforeach                                          
                                    </ul>   
                                  @endif
                                                                               
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.ChooseCatgoryText') }}.</span>
                                      <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                  </div>
                                </div>
                                                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Manufacturers') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="select2" name="manufacturers_id">
                                          <option value="">{{ trans('labels.ChooseManufacturers') }}</option>
                                          @if(!empty(session('manufacturers_id')))
                                              @php
                                                  $cat_array = explode(',', session('manufacturers_id'));
                                              @endphp
                                              @foreach ($result['manufacturer'] as $manufacturer)
                                                  @if(in_array($manufacturer->id,$cat_array))
                                                     <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                                  @endif
                                              @endforeach
                                              @else
                                                 @foreach ($result['manufacturer'] as $manufacturer)
                                                  <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                                  @endforeach
                                          @endif
                                      </select><span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.ChooseManufacturerText') }}.</span>
                                  </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashSale') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                       <select class="form-control" onChange="showFlash()" name="isFlash" id="isFlash">
                                          <option value="no">{{ trans('labels.No') }}</option>
                                          <option value="yes">{{ trans('labels.Yes') }}</option>
                                      </select>
                                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                  {{ trans('labels.FlashSaleText') }}</span>
                                  </div>
                                </div>
                                
                                <div class="flash-container" style="display: none;">
                                    <div class="form-group">
                                      <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashSalePrice') }}</label>
                                      <div class="col-sm-10 col-md-4">
                                        <input  class="form-control" type="text" name="flash_sale_products_price" id="flash_sale_products_price" value="">
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                        {{ trans('labels.FlashSalePriceText') }}</span>
                                        <span class="help-block hidden">{{ trans('labels.FlashSalePriceText') }}</span>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group">                                    
                                      <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashSaleDate') }}</label>
                                      <div class="col-sm-10 col-md-2">
                                        <input  class="form-control datepicker" readonly type="text" name="flash_start_date" id="flash_start_date" readonly value="">     
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.FlashSaleDateText') }}</span>                               
                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                      </div>
                                      <div class="col-sm-10 col-md-2 bootstrap-timepicker">
                                        <input type="text" class="form-control timepicker" name="flash_start_time" readonly id="flash_start_time" value="" >
                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group">                                    
                                      <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.FlashExpireDate') }}</label>
                                      <div class="col-sm-10 col-md-2">
                                        <input  class="form-control datepicker" readonly type="text" readonly name="flash_expires_date" id="flash_expires_date" value="">     
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      	{{ trans('labels.FlashExpireDateText') }}</span>                               
                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                      </div>
                                      <div class="col-sm-10 col-md-2 bootstrap-timepicker">
                                        <input type="text" class="form-control timepicker" readonly name="flash_end_time" id="flash_end_time" value="" >
                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group">
                                      <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                      <div class="col-sm-10 col-md-4">
                                          <select class="form-control" name="flash_status">
                                              <option value="1">{{ trans('labels.Active') }}</option>
                                              <option value="0">{{ trans('labels.Inactive') }}</option>
                                          </select>
                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                          {{ trans('labels.ActiveFlashSaleProductText') }}</span>									  
                                      </div>
                                    </div>
                                </div>
                                
                                <hr>
                                <div class="form-group special-link">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Special') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                       <select class="form-control" onChange="showSpecial()" name="isSpecial" id="isSpecial">
                                          <option value="no">{{ trans('labels.No') }}</option>
                                          <option value="yes">{{ trans('labels.Yes') }}</option>
                                      </select>
                                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                  {{ trans('labels.SpecialProductText') }}.</span>
                                  </div>
                                </div>
                                
                                <div class="special-container" style="display: none;">
                                    <div class="form-group">
                                      <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.SpecialPrice') }}</label>
                                      <div class="col-sm-10 col-md-4">
                                        <input  class="form-control" type="text" name="specials_new_products_price" id="special-price" value="">
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                        {{ trans('labels.SpecialPriceTxt') }}.</span>
                                        <span class="help-block hidden">{{ trans('labels.SpecialPriceNote') }}.</span>
                                      </div>
                                    </div>
                                    <div class="form-group">                                    
                                      <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ExpiryDate') }}</label>                                      <div class="col-sm-10 col-md-4">
                                        <input  class="form-control datepicker" readonly readonly type="text" name="expires_date" id="expiry-date" value="">
                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                        {{ trans('labels.SpecialExpiryDateTxt') }}
                                        </span>
                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                      <div class="col-sm-10 col-md-4">
                                          <select class="form-control" name="status">
                                              <option value="1">{{ trans('labels.Active') }}</option>
                                              <option value="0">{{ trans('labels.Inactive') }}</option>
                                          </select>
                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                          {{ trans('labels.ActiveSpecialProductText') }}.</span>									  
                                      </div>
                                    </div>
                                </div>
                                
                                <hr>
                                
                              @foreach($result['languages'] as $languages)
                                
                                <div class="form-group">
                                      <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductName') }} ({{ $languages->name }})</label>
                                      <div class="col-sm-10 col-md-4">
                                            <input type="text" name="products_name_<?=$languages->languages_id?>" class="form-control field-validate">
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                           {{ trans('labels.EnterProductNameIn') }} {{ $languages->name }} </span>
                                      <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                      </div>
                                </div>
                                
                                <div class="form-group external_link" style="display: none">
                                      <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.External URL') }} ({{ $languages->name }})</label>
                                      <div class="col-sm-10 col-md-4">
                                            <input type="text" name="products_url_<?=$languages->languages_id?>" class="form-control products_url">
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                           {{ trans('labels.External URL Text') }} {{ $languages->name }} </span>
                                      <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                      </div>
                                </div>
                                                                
                                <div class="form-group">
                                	<label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Description') }} ({{ $languages->name }})</label>
                                    <div class="col-sm-10 col-md-8">
                                    	<textarea id="editor<?=$languages->languages_id?>" name="products_description_<?=$languages->languages_id?>"class="form-control" rows="5"></textarea>
                                    	<span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                       {{ trans('labels.EnterProductDetailIn') }} {{ $languages->name }}</span>
                                      </div>
                                </div>
                                                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.left banner') }} ({{ $languages->name }})</label>
                                  <div class="col-sm-10 col-md-4">
                                  	<input type="file" name="products_left_banner_<?=$languages->languages_id?>" id="products_left_banner_<?=$languages->languages_id?>">
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.banner text') }}</span>
                                  </div>
                                </div>                                                                
                                                               
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.banner start date') }} ({{ $languages->name }})</label>
                                  <div class="col-sm-10 col-md-4">
                                    <input class="form-control datepicker" readonly type="text" name="products_left_banner_start_date_<?=$languages->languages_id?>" id="products_left_banner_start_date_<?=$languages->languages_id?>">
                                    
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.banner start date text') }}</span>
                                  </div>
                                </div>
                                                               
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.banner expire date') }} ({{ $languages->name }})</label>
                                  <div class="col-sm-10 col-md-4">
                                    <input class="form-control datepicker" readonly type="text" name="products_left_banner_expire_date_<?=$languages->languages_id?>" id="products_left_banner_expire_date_<?=$languages->languages_id?>">
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.banner expire date text') }}</span>
                                  </div>
                                </div>
                                                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.right banner') }} ({{ $languages->name }})</label>
                                  <div class="col-sm-10 col-md-4">
                                  	<input type="file" name="products_right_banner_<?=$languages->languages_id?>" id="products_right_banner_<?=$languages->languages_id?>">
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.banner text') }}</span>
                                  </div>
                                </div>
                                                               
                                                               
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.banner start date') }} ({{ $languages->name }})</label>
                                  <div class="col-sm-10 col-md-4">
                                    <input class="form-control datepicker" readonly type="text" name="products_right_banner_start_date_<?=$languages->languages_id?>" id="products_right_banner_start_date_<?=$languages->languages_id?>">
                                    
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.banner start date text') }}</span>
                                  </div>
                                </div>
                                                               
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.banner expire date') }} ({{ $languages->name }})</label>
                                  <div class="col-sm-10 col-md-4">
                                    <input class="form-control datepicker" readonly type="text" name="products_right_banner_expire_date_<?=$languages->languages_id?>" id="products_right_banner_expire_date_<?=$languages->languages_id?>">
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.banner expire date text') }}</span>
                                  </div>
                                </div>
                                
                              @endforeach
                                                                
                                <div class="form-group" id="tax-class">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.TaxClass') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control field-validate" name="tax_class_id">
                                        <option selected>{{ trans('labels.SelectTaxClass') }}</option>
                                         @foreach ($result['taxClass'] as $taxClass)
                                          <option value="{{ $taxClass->tax_class_id }}">{{ $taxClass->tax_class_title }}</option>
                                         @endforeach
                                      </select>                                      
                                     <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                     {{ trans('labels.ChooseTaxClassForProductText') }}
                                     </span>
                                      <span class="help-block hidden">{{ trans('labels.SelectProductTaxClass') }}</span>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsPrice') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('products_price',  '', array('class'=>'form-control number-validate', 'id'=>'products_price')) !!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.ProductPriceText') }}
                                    </span>                                  
                                    <span class="help-block hidden">{{ trans('labels.ProductPriceText') }}</span>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Min Order Limit') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('products_min_order',  '1', array('class'=>'form-control', 'id'=>'products_min_order')) !!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.Min Order Limit Text') }}
                                    </span>                                  
                                    <span class="help-block hidden">{{ trans('labels.Min Order Limit Text') }}</span>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Max Order Limit') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('products_max_stock',  '0', array('class'=>'form-control', 'id'=>'products_max_stock')) !!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.Max Order Limit Text') }}
                                    </span>                                  
                                    <span class="help-block hidden">{{ trans('labels.Max Order Limit Text') }}</span>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsWeight') }}</label>
                                  <div class="col-sm-10 col-md-2">
                                    {!! Form::text('products_weight',  '', array('class'=>'form-control number-validate', 'id'=>'products_weight')) !!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.RequiredTextForWeight') }}
                                    </span>
                                  </div>
                                  <div class="col-sm-10 col-md-2" style="padding-left: 0;">
                                      <select class="form-control" name="products_weight_unit">
                                      	@if(count($result['units'])>0)
                                              @foreach($result['units'] as $unit)
                                              <option value="{{$unit->unit_name}}">{{$unit->unit_name}}</option>
                                              @endforeach
                                        @endif
                                      </select>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.ProductsModel') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::text('products_model',  '', array('class'=>'form-control', 'id'=>'products_model')) !!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.ProductsModelText') }}
                                    </span>
                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                  </div>
                                </div>
                                                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                    {!! Form::file('products_image', array('id'=>'products_image', 'class'=>'field-validate')) !!}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.UploadProductImageText') }}</span>
                                  </div>
                                </div>
                                                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.IsFeature') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="is_feature">
                                          <option value="0">{{ trans('labels.No') }}</option>
                                          <option value="1">{{ trans('labels.Yes') }}</option>                                       
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.IsFeatureProuctsText') }}</span>
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="products_status">
                                          <option value="1">{{ trans('labels.Active') }}</option>
                                          <option value="0">{{ trans('labels.Inactive') }}</option>                                       
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.SelectStatus') }}</span>
                                  </div>
                                </div>
                              <div class="form-group">
                                  <label for="customer_group_payment" class="col-sm-2 col-md-3 control-label">{{ trans('labels.product_supply') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <input type="radio" name="supply" id="1" value="1" required> {{ trans('labels.product_all_customer') }}<br>
                                      <input type="radio" name="supply" id="2" value="2" > {{ trans('labels.product_b2b') }}<br>
                                      <input type="radio" name="supply" id="3" value="3"> {{ trans('labels.product_b2c') }}<br>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.product_delivery time') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      {!! Form::text('products_delivery_time',  '0', array('class'=>'form-control', 'id'=>'products_min_order')) !!}
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.product_number') }}
                                    </span>
                                      <span class="help-block hidden">{{ trans('labels.product_number') }}</span>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.product_appro_weight') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      {!! Form::text('product_appro_weight',  '0', array('class'=>'form-control', 'id'=>'product_appro_weight')) !!}
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.product_number') }}
                                    </span>
                                      <span class="help-block hidden">{{ trans('labels.product_number') }}</span>
                                  </div>
                              </div>
                               <div class="form-group" hidden >
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.product_barcode') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      {!! Form::text('products_barcode',  '0', array('class'=>'form-control', 'id'=>'products_barcode')) !!}
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    {{ trans('labels.product_barcode') }}
                                    </span>
                                      <span class="help-block hidden">{{ trans('labels.product_barcode') }}</span>
                                  </div>
                              </div> 
                              <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.product_available') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="is_available">
                                          <option value="0">{{ trans('labels.No') }}</option>
                                          <option value="1">{{ trans('labels.Yes') }}</option>
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.product_available') }}</span>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.part_com') }} </label>
                              <div id="con" class="container">
                                  <div id="elm" class="element">
                                      <div class="item">
                                          {{ trans('labels.part_type') }}
                                          <select class="form-control " name="category[]" id="category_id_" onchange="getdata(this)" >
                                              <option value="0">{{ trans('labels.ChooseCategory') }}</option>
                                              @foreach ($result['partCategories'] as $categories)
                                                  <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                      <div class="item">
                                          {{ trans('labels.part_group') }}
                                          <select class="form-control " name="sub_category[]" id="sub_category_" onchange="get_part(this)">
                                              <option value="">{{ trans('labels.ChooseCategory') }}</option>
                                          </select>
                                      </div>
                                      <div class="item">
                                          {{ trans('labels.part_title') }}
                                          <select class="form-control " name="part[]" id="part_id_">
                                              <option value="">{{ trans('labels.ChooseCategory') }}</option>
                                          </select>
                                      </div>
                                      <div class="item">
                                          <span class="item__sp1" onclick="insert_row(this)"> <i class="fa fa-plus-circle"></i> </span>
                                          <span class="item__sp2" onclick="delete_row(this)"> <i class="fa fa-minus-circle"></i> </span>
                                      </div>
                                  </div>
                              </div>
                              </div>
                              <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.product_customer_call_by_type') }} </label>
                                  <div class="col-sm-10 col-md-4">
                                      <table class="table table-responsive">
                                          <thead>
                                          <tr>
                                              <td>{{ trans('labels.customer_group') }}</td>
                                              <td>{{ trans('labels.pay') }}</td>
                                              <td>{{ trans('labels.sub_make') }}</td>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          @foreach ($result['customer_group'] as $all_c_group)
                                          <tr>
                                              <input type="hidden" name="customers_group_id[]" id="customers_group_id_{{$all_c_group->customers_group_id}}" value="{{$all_c_group->customers_group_id}}">
                                              <td>{{$all_c_group->customers_group_title}}</td>
                                                  <td>
                                                              {!! Form::number("customer_pay[]", '0', array('class'=>'form-control', 'id'=>"customer_pay_$all_c_group->customers_group_id")) !!}

                                                  </td>
                                                  <td>
                                                              {!! Form::number("customer_pay_make[]",  '0', array('class'=>'form-control', 'id'=>"customer_pay_make_$all_c_group->customers_group_id")) !!}
                                                  </td>

                                          </tr>
                                          @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary pull-right"  id="normal-btn">{{ trans('labels.Add Atrributes') }} <i class="fa fa-angle-right 2x"></i></button>
                                <button type="submit" class="btn btn-primary pull-right"  id="external-btn" style="display: none">{{ trans('labels.addinventory') }} <i class="fa fa-angle-right 2x"></i></button>
                              </div>
                              <!-- /.box-footer -->
                            {!! Form::close() !!}
                        </div>
                  </div>
              </div>
            </div>
            
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
    
    <!-- Main row --> 
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
<script src="{!! asset('resources/views/admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
<script>
    var count = 1;

    function getdata(e) {
        var id = e.options[e.selectedIndex].value;
        $.post("{{asset('/admin/getsubpart/')}}",
            {
                id: id
            },
            function (data, status) {
                // alert("Data: " + data + "\nStatus: " + status);
                console.log(data);
                add_data(e , data);
            });
    }
    function get_part(e) {
        var id = e.options[e.selectedIndex].value;
        $.post("{{asset('/admin/getpart/')}}",
            {
                id: id
            },
            function (data, status) {
                // alert("Data: " + data + "\nStatus: " + status);
                console.log(data);
                var current_row = e.parentElement.parentElement;
                var current_row_select_two = current_row.getElementsByTagName("select")[2];
                current_row_select_two.innerHTML = "";
                for (let i = 0; i < data.length; i++) {
                    var option = document.createElement("option");
                      // option.text = "item_" + i;
                    // option.value = "item_" + i;
                    option.text = data[i]['part_title'];
                    option.value = data[i]['id'];
                    current_row_select_two.add(option);
                }
            });

    }
    function add_data(e , data) {
        // after that fetch and get data from server
        var current_row = e.parentElement.parentElement;
        var current_row_select_two = current_row.getElementsByTagName("select")[1];
        current_row_select_two.innerHTML = "";
        for (let i = 0; i < data.length; i++) {
            var option = document.createElement("option");
            // option.text = "item_" + i;
            // option.value = "item_" + i;
            option.text = data[i]['name'];
            option.value = data[i]['id'];
            current_row_select_two.add(option);
        }
    }

    function insert_row(e) {

        count++;

        var current_item = e.parentElement.parentElement;

        let index_current = 0;
        while ((current_item = current_item.previousSibling) != null)
            index_current++;


        var con = document.getElementById("con");
        var elm = document.getElementById("elm");
        var clone_elm = elm.cloneNode(true);

        clone_elm.getElementsByTagName("select")[0].id = "category_id_" + count;
        clone_elm.getElementsByTagName("select")[1].id = "sub_category_id_" + count;
        clone_elm.getElementsByTagName("select")[2].id = "part_id_" + count;
        clone_elm.getElementsByTagName("select")[1].innerHTML = "";
        clone_elm.getElementsByTagName("select")[2].innerHTML = "";
        con.insertBefore(clone_elm, con.childNodes[index_current + 1]);

        // con.appendChild(clone_elm);
    }

    function delete_row(e) {

        var con = document.getElementById("con");

        if (con.children.length > 1) {

            var current_item = e.parentElement.parentElement;

            let index_current = 0;
            while ((current_item = current_item.previousSibling) != null)
                index_current++;

            con.removeChild(con.childNodes[index_current]);
        }
    }

</script>
<script type="text/javascript">
		$(function () {
			//for multiple languages
			@foreach($result['languages'] as $languages)
				// Replace the <textarea id="editor1"> with a CKEditor
				// instance, using default configuration.
				CKEDITOR.replace('editor{{$languages->languages_id}}');
			@endforeach
			//bootstrap WYSIHTML5 - text editor
			$(".textarea").wysihtml5();
    });
</script>
@endsection 