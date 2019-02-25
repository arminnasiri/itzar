@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.priceboard') }} <small>{{ trans('labels.listpriceboard') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.priceboard') }}</li>
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
            <h3 class="box-title">{{ trans('labels.listpriceboard') }} </h3>
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
              {!! Form::open(array('url' =>'admin/price_board', 'method'=>'post', 'class' => 'form-horizontal form-validate')) !!}
              <div class="form-group">
                <label for="gold" class="col-sm-2 col-md-3 control-label">{{ trans('labels.gold') }}</label>
                <div class="col-sm-10 col-md-4">
                  <input type="text" name="gold" class="form-control field-validate" value="{{$all_price[0]->price}}">
                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.gold') }}</span>
                  <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                </div>
              </div>
              <div class="form-group">
                <label for="silver" class="col-sm-2 col-md-3 control-label">{{ trans('labels.silver') }}</label>
                <div class="col-sm-10 col-md-4">
                  <input type="text" name="silver" class="form-control field-validate" value="{{$all_price[1]->price}}">
                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.silver') }}</span>
                  <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                </div>
              </div>
              <div class="form-group">
                <label for="titanium" class="col-sm-2 col-md-3 control-label">{{ trans('labels.titanium') }}</label>
                <div class="col-sm-10 col-md-4">
                  <input type="text" name="titanium" class="form-control field-validate" value="{{$all_price[2]->price}}">
                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.titanium') }}</span>
                  <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                </div>
              </div>
              <div class="form-group">
                <label for="iron" class="col-sm-2 col-md-3 control-label">{{ trans('labels.iron') }}</label>
                <div class="col-sm-10 col-md-4">
                  <input type="text" name="iron" class="form-control field-validate" value="{{$all_price[3]->price}}">
                  <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.iron') }}</span>
                  <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                </div>
              </div>
              <div class="box-footer text-center">
                <button type="submit" class="btn btn-primary">{{ trans('labels.upatepriceboard') }} </button>
              </div>

              {!! Form::close() !!}
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