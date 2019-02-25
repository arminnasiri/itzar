@extends('admin.layout')
@section('content')
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.MainParts') }} <small>{{ trans('labels.ListingAllParts') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li class="active">{{ trans('labels.MainParts') }}</li>
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
            <h3 class="box-title">{{ trans('labels.ListingAllMainParts') }} </h3>
            <div class="box-tools pull-right">
            	<a href="{{ URL::to('admin/addpart') }}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNewPart') }}</a>
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
                          <th>{{ trans('labels.part_title') }}</th>
                          <th>{{ trans('labels.part_type') }}</th>
                          <th>{{ trans('labels.part_group') }}</th>
                          <th>{{ trans('labels.part_image') }}</th>
                          <th>{{ trans('labels.part_fixed_price') }}</th>
                      </tr>
                      </thead>
                      <tbody>
                      @if(count($parts)>0)
                          @foreach ($parts as $key=>$part)
                              <tr>
                                  <td>{{ $part->id }}</td>
                                  <td>{{ $part->part_title }}</td>
                                  <td>{{$part->id_part_category}}</td>
                                  <td>{{$part->id_part_sub_category}}</td>
                                  <td><img src="{{asset('').'/'.$part->part_img}}" alt="" width=" 100px"></td>
                                  <td>{{$part->part_fixed_price}}</td>
                                  <td>
                                      <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Edit') }}" href="editpart/{{ $part->id }}" class="badge bg-light-blue"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                      <a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Delete') }}" href="deletepart/{{ $part->id }}" class="badge bg-red"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  </td>
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
                	{{$parts->links('vendor.pagination.default')}}
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