@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.MainCategories') }} <small>{{ trans('labels.ListingAllMainCategories') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.Main_customer_group') }}</li>
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
            <h3 class="box-title">{{ trans('labels.ListingAllMainCategories') }} </h3>
            <div class="box-tools pull-right">
            	<a href="{{ URL::to('admin/add_customer_group') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.add_new_customer_group') }}</a>
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
                  <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                          <th>{{ trans('labels.ID') }}</th>
                          <th>{{ trans('labels.Title') }}</th>
                          <th>{{ trans('labels.profit') }}</th>
                          <th>{{ trans('labels.tax') }}</th>
                          <th>{{ trans('labels.payment') }}</th>
                          <th>{{ trans('labels.Action') }}</th>
                      </tr>
                      </thead>
                      <tbody>
                      @if(count($customer_groups)>0)
                          @foreach ($customer_groups as $key=>$customer_group)
                              <tr>
                                  <td>{{ $customer_group->customers_group_id }}</td>
                                  @foreach($customer_group_description as $name)
                                      @if($name->customers_group_id==$customer_group->customers_group_id)
                                          <td>{{ $name->customers_group_title }}</td>
                                      @endif
                                  @endforeach
                                  <td>{{$customer_group->profit_customer_group}}</td>
                                  <td>{{$customer_group->tax_customer_group}}</td>
                                  <td>{{$customer_group->payment_customer_group}} </td>
                                  <td> <ul class="nav table-nav">
                                          <li class="dropdown">
                                              <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                  {{ trans('labels.Action') }} <span class="caret"></span>
                                              </a>
                                              <ul class="dropdown-menu">
                                                  <li role="presentation"><a role="menuitem" tabindex="-1" href="customer_group/{{ $customer_group->customers_group_id}}">{{ trans('labels.EditCustomers') }}</a></li>
                                                  <li role="presentation" class="divider"></li>
                                                  <li role="presentation"><a data-toggle="tooltip" data-placement="bottom" href= "delete_customer_group/{{ $customer_group->customers_group_id}}" title="{{ trans('labels.Delete') }}" id="deleteCustomerFrom" customers_id="{{ $customer_group->customers_group_id}}">{{ trans('labels.Delete') }}</a></li>
                                              </ul>
                                          </li>
                                      </ul></td>
                              </tr>
                          @endforeach
                      @else
                          <tr>
                              <td colspan="6">{{ trans('labels.NoRecordFound') }}</td>
                          </tr>
                      @endif
                      </tbody>
                  </table>
                <div class="col-xs-12 text-right">
                	{{$customer_groups->links('vendor.pagination.default')}}
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