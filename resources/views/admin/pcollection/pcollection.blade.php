@extends('admin.layout')
@section('content')

<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.collections') }} <small>{{ trans('labels.ListingAllCollection') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active"> {{ trans('labels.collections') }}</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content"> 
    <div class="row">
    <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.ListingAllCollection') }} </h3>
            <div class="box-tools pull-right">
            	<a href="{{ URL::to('admin/pcollectionAdd') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNewCollection') }}</a>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">       
    
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
                   @if(false)
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
                            <td colspan="5" class="text-center">{{ trans('labels.NoRecordFound') }}</td>
                       </tr>
                   @endif 
                  </tbody>
                </table>
                <div class="col-xs-12 text-right">
                	
                </div>
              </div>
              
            </div>
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
    </div>
    </section>
  </div>  

@endsection