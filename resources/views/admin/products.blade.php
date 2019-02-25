@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.Products') }} <small>{{ trans('labels.ListingAllProducts') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active"> {{ trans('labels.Products') }}</li>
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
            <h3 class="box-title">{{ trans('labels.ListingAllProducts') }} </h3>
            <div class="box-tools pull-right" style="z-index:10000;">
            	<a href="{{ URL::to('admin/addproduct') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNewProducts') }}</a>
              
              <button class="btn btn-block btn-primary" type="button"  data-toggle="modal" data-target="#dftw" >{{ trans('labels.deduct_from_the_warehouse') }}</button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          	
            <div class="row">
              <div class="col-xs-12">
				  @if (count($errors) > 0)
					  @if($errors->any())
						<div class="alert alert-success alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  {{$errors->first()}}
						</div>
					  @endif
				  @endif
              </div>
            </div>
            
            <div class="row">
            	<div class="col-xs-12">
                    <form class="form-inline form-validate" enctype="multipart/form-data">
                      <div class="form-group">
                      	<h5 style="font-weight: bold; padding:0px 5px; ">{{ trans('labels.FilterByCategory/Products') }}:</h5>
                      </div>
                      <div class="form-group" style="min-width: 220px">
                        <select class="form-control" name="categories_id" style="width: 100%">
                        	<option value="">{{ trans('labels.SelectCategory') }}</option>
                            @foreach ($results['subCategories'] as  $key=>$subCategories)
                            	<option value="{{ $subCategories->id }}"
                                	@if(isset($_REQUEST['categories_id']) and !empty($_REQUEST['categories_id']))
                                    	@if( $subCategories->id == $_REQUEST['categories_id'])
                                        	selected
                                        @endif
                                    @endif
                                >{{ $subCategories->name }}</option>
                            @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <input type="text" name="product" class="form-control" id="exampleInputPassword3"
                            @if(isset($_REQUEST['product']) and !empty($_REQUEST['product']))
                                value="{{ $_REQUEST['product'] }}"            
                            @endif
                         placeholder="Products">
                      </div>
                      <button type="submit" class="btn btn-success">{{ trans('labels.Search') }}</button>
                      <a href="{{ URL::to('admin/products')}}" class="btn btn-danger">{{ trans('labels.ClearSearch') }}</a>
                    </form>
                </div><br><br><br>

             </div>
            
            <div class="row">
              <div class="col-xs-12">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>{{ trans('labels.ID') }}</th>
                      <th width="170">{{ trans('labels.Image') }}</th>
                      <th>{{ trans('labels.ProductDescription') }}</th>
                      <th>{{ trans('labels.AddedLastModifiedDate') }}</th>
                      <th></th>
                    </tr>
                  </thead>
                   <tbody>
                   @if(count($results['products'])>0)
                    @foreach ($results['products'] as  $key=>$product)
                    	<tr>
                            <td>{{ $product->products_id }}</td>
                            <td><a data-toggle="modal" data-target="#myModal_{{$product->products_id }}" ><img data-zoom="{{asset('').'/'.$product->products_image}}" src="{{asset('').'/'.$product->products_image}}" alt="" width="170px" height="200px"></a></td>
                            <div id="myModal_{{$product->products_id }}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">{{ trans('labels.Image') }}</h4>
                                        </div>
                                        <div class="modal-body">

                                            <img src="{{asset('').'/'.$product->products_image}}" alt="" width=" 550px" height="500px">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('labels.Close')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <td width="45%">
                            	<strong>{{ $product->products_name }} @if(!empty($product->products_model)) ( {{ $product->products_model }} ) @endif</strong><br>
                                
                                <strong>{{ trans('labels.Product Type') }}:</strong>
                                	@if($product->products_type==0)
                                    	{{ trans('labels.Simple') }}
                                    @elseif($product->products_type==1)
                                    	{{ trans('labels.Variable') }}
                                    @elseif($product->products_type==2)
                                    	{{ trans('labels.External') }}
                                    @endif
                                <br>
                                @if(!empty($product->manufacturers_name))
                                <strong>{{ trans('labels.Manufacturer') }}:</strong> {{ $product->manufacturers_name }}<br>
                                @endif
                                <strong>{{ trans('labels.Price') }}: </strong>     {{ $results['currency'][19]->value }}{{ $product->products_price }}<br>
                                <strong>{{ trans('labels.Weight') }}: </strong>  {{ $product->products_weight }}{{ $product->products_weight_unit }}<br>
                                <strong>{{ trans('labels.Viewed') }}: </strong>  {{ $product->products_viewed }}<br>
                                @if(!empty($product->specials_id))
								<strong class="badge bg-light-blue">{{ trans('labels.Special Product') }}</strong><br>
                              	<strong>{{ trans('labels.SpecialPrice') }}: </strong>  {{ $product->specials_products_price }}<br>
                              	  @if(!empty($product->specials_id)>0)
                              	  <strong>{{ trans('labels.ExpiryDate') }}: </strong>  
                                  @if($product->expires_date > time())
                                  	 {{ date('d/m/Y', $product->expires_date) }}
                                   @else
                                   	<strong class="badge bg-red">{{ trans('labels.Expired') }}</strong>
                                   
                                    @endif
                                  <br>
                              	  @endif
                                @endif
                            </td>
                            <td>
                             	<strong>{{ trans('labels.AddedDate') }}: </strong> {{ $product->products_date_added }}<br>
                           		<strong>{{ trans('labels.ModifiedDate') }}: </strong>{{ $product->products_last_modified }}
                            </td>
                           
                            <td>
                            <ul class="nav table-nav">
                              <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                  {{ trans('labels.Action') }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="editproduct/{{ $product->products_id }}">{{ trans('labels.EditProduct') }}</a></li>
                                    @if($product->products_type==1)
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="addproductattribute/{{ $product->products_id }}">{{ trans('labels.ProductAttributes') }}</a></li>
                                    @endif
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="addinventory/{{ $product->products_id }}">{{ trans('labels.addinventory') }}</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="addproductimages/{{ $product->products_id }}">{{ trans('labels.ProductImages') }}</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" id="deleteProductId" products_id="{{ $product->products_id }}">{{ trans('labels.DeleteProduct') }}</a></li>
                                </ul>
                              </li>
                            </ul>
                            </td>
                        </tr>
                     @endforeach
                   @else
                   		<tr>
                            <td colspan="5">{{ trans('labels.NoRecordFound') }}</td>
                       </tr>
                   @endif 
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	{{$results['products']->links('vendor.pagination.default')}}
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
    
    <!-- deleteProductModal -->
	<div class="modal fade" id="deleteproductmodal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="deleteProductModalLabel">{{ trans('labels.DeleteProduct') }}</h4>
		  </div>
		  {!! Form::open(array('url' =>'admin/deleteproduct', 'name'=>'deleteProduct', 'id'=>'deleteProduct', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
				  {!! Form::hidden('action',  'delete', array('class'=>'form-control')) !!}
				  {!! Form::hidden('products_id',  '', array('class'=>'form-control', 'id'=>'products_id')) !!}
		  <div class="modal-body">						
			  <p>{{ trans('labels.DeleteThisProductDiloge') }}?</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
			<button type="submit" class="btn btn-primary" id="deleteProduct">{{ trans('labels.DeleteProduct') }}</button>
		  </div>
		  {!! Form::close() !!}
		</div>
	  </div>
	</div>
    <!-- /.row --> 
    
    <!-- Main row --> 
    
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>

<!-- Modal -->
<div id="dftw" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{trans('labels.deduct_from_the_warehouse')}}</h4>
      </div>
      <div class="modal-body">
        
      <div class="form-group">
          <div class="col-sm-2">
            <button class="btn btn-primary" id="searchbarcode">جستجو</button>
          </div>
          <div class="col-sm-8">
            <input type="email" class="form-control" id="dftwinput" placeholder="وارد کردن شناسه">
          </div>
          <label class="control-label col-sm-2">{{trans('labels.ID')}}</label>
      </div>
      <div class="form-group ">
        <div class="col-sm-12">
          <div class="text-center" id="msgbar"></div>
          <div  id="con-content"></div>
        </div> 
      </div>
      <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
  var lastrefid = 0;
  document.getElementById('searchbarcode').addEventListener('click' , function(){
    lastrefid =  document.getElementById('dftwinput').value;
    searchbarcode(lastrefid);
  });
 function searchbarcode(lastrefid){
        $('#con-content').empty();
        $('#msgbar').text("");
        $.ajax({
          url: '{{URL::to("admin/sub_inventory")}}',
          type: "POST",
          data: {ref_id:lastrefid},
          dataType: "json",
          success: function(res){ 
            var template = `<br><br><table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                <th>ویژگی</th>
                                <th>مقدار</th>
                                <th>نام محصول</th>
                                <th>تعداد محصول</th>
                                <th >کم کردن</th>
                              </tr>
                          </thead>`;
            for(var i=0;i<res.length;i++){
                 template += `<tr>
                                  <td>${res[i].options_name}</td>
                                  <td>${res[i].options_values_name}</td>
                                  <td>${res[i].products_name}</td>
                                  <td>${res[i].stock}</td>
                                  <th onclick="reqreduce()"><i class="fa fa-2x fa-minus-circle"></i></th>
                                </tr>  
                `;
            }
            template += `</table>`;
            $('#con-content').html(template);      
          },
          error: function (res, error) {
              $('#msgbar').text(res.statusText);
          } ,    
        });   
}

  function reqreduce(){
    $('#msgbar').text("");
    $.ajax({
          url: '{{URL::to("admin/sub_stock")}}',
          type: "POST",
          data: {
                 ref_id:lastrefid , 
                 sub_number:1 
                },
          dataType: "json",
          success: function(res){ 
            searchbarcode(lastrefid);
          },
          error: function (res, error) {
            $('#msgbar').text(res.responseJSON.msg);  
          } ,    
        });   

  }
  
</script>
@endsection 