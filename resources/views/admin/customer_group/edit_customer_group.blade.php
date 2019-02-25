@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.AddCategories') }} <small>{{ trans('labels.AddCategories') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/listingCategories')}}"><i class="fa fa-bars"></i> {{ trans('labels.ListAllCategories') }}</a></li>
      <li class="active">{{ trans('labels.AddCategories') }}</li>
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
            <h3 class="box-title">{{ trans('labels.AddCategories') }} </h3>
          </div>
          
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                        <!--<div class="box-header with-border">
                          <h3 class="box-title">Edit category</h3>
                        </div>-->
                        <!-- /.box-header -->
                        <br>                       
                        @if (count($errors) > 0)
							  @if($errors->any())
								<div class="alert alert-success alert-dismissible" role="alert">
								  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								  {{$errors->first()}}
								</div>
							  @endif
						@endif
                        
                        <!-- form start -->                        
                         <div class="box-body">
                         
                            {!! Form::open(array('url' =>'admin/update_customer_group', 'method'=>'post', 'class' => 'form-horizontal form-validate')) !!}

                             <div class="form-group">
                                 <label for="is_teammate" class="col-sm-2 col-md-3 control-label">{{ trans('labels.co_worker') }}</label>
                                 <div class="col-sm-10 col-md-4">
                                     <input type="checkbox" name="is_teammate"  {{$customer_group[0]->is_teammate ? 'checked': ''}}>
                                     <input type="hidden" name="id" value="{{$customer_group[0]->customers_group_id}}">
                                 </div>
                             </div>
                              @foreach($result['languages'] as $languages)
                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Title') }} ({{ $languages->name }})</label>
                                  <div class="col-sm-10 col-md-4">
                                    <input type="text" name="customer_group_title_{{$languages->languages_id}}" value="{{$customer_group_description[0]->customers_group_title}}" class="form-control field-validate">
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.Group_name') }} ({{ $languages->name }}).</span>
                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                  </div>
                                </div>
                               @endforeach
                             <div class="form-group">
                                 <label for="customer_group_profit" class="col-sm-2 col-md-3 control-label">{{ trans('labels.profit') }}</label>
                                 <div class="col-sm-10 col-md-4">
                                     <input type="text" name="customer_group_profit" value="{{$customer_group[0]->profit_customer_group}}" class="form-control field-validate">
                                     <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.profit') }}</span>
                                     <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label for="customer_group_tax" class="col-sm-2 col-md-3 control-label" onclick="">{{ trans('labels.tax') }}</label>
                                 <div class="col-sm-10 col-md-4">
                                     <input type="text" name="customer_group_tax" class="form-control field-validate" value="{{$customer_group[0]->tax_customer_group}}">
                                     <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.tax') }}</span>
                                     <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <label for="customer_group_payment" class="col-sm-2 col-md-3 control-label">{{ trans('labels.payment') }}</label>
                                 <div class="col-sm-10 col-md-4">
                                     <input type="radio" name="payment"  id="_all" value="all" {{$customer_group[0]->payment_customer_group=='all' ? 'checked': ''}}> {{ trans('labels.all') }}<br>
                                     <input type="radio" name="payment" id="_non" value="non"{{$customer_group[0]->payment_customer_group=='non' ? 'checked': ''}}> {{ trans('labels.non') }}<br>
                                     <input type="radio" name="payment" id="_non_metallic" value="non_metallic"{{$customer_group[0]->payment_customer_group=='non_metallic' ? 'checked': ''}}> {{ trans('labels.non_metallic') }}<br>
                                     <input type="radio" name="payment" id="_gold" value="gold"{{$customer_group[0]->payment_customer_group=='gold' ? 'checked': ''}}> {{ trans('labels.gold') }}<br>
                                     {{--<input type="radio" name="payment" id="_silver" value="silver"{{$customer_group[0]->payment_customer_group=='silver' ? 'checked': ''}}> {{ trans('labels.silver') }}<br>--}}
                                     {{--<input type="radio" name="payment"  id="_titanium" value="titanium"{{$customer_group[0]->payment_customer_group=='titanium' ? 'checked': ''}}> {{ trans('labels.titanium') }}<br>--}}
                                     {{--<input type="radio" name="payment" id="_iron" value="iron"{{$customer_group[0]->payment_customer_group=='iron' ? 'checked': ''}}> {{ trans('labels.iron') }}<br>--}}
                                 </div>
                             </div>
                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('labels.add_new_customer_group') }}</button>
                                <a href="{{ URL::to('admin/categories')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
@endsection 