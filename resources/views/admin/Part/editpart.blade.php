@extends('admin.layout')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> {{ trans('labels.AddParts') }} <small>{{ trans('labels.AddParts') }} ...</small> </h1>
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
                <li><a href="{{ URL::to('admin/parts')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.ListingAllMainParts') }}</a></li>
                <li class="active">{{ trans('labels.AddParts') }} </li>
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
                            <h3 class="box-title">{{ trans('labels.AddParts') }}  </h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box box-info">
                                        <!--<div class="box-header with-border">
                                          <h3 class="box-title">Edit part</h3>
                                        </div>-->
                                        <!-- /.box-header -->
                                        <!-- form start -->
                                        <div class="box-body">
                                            @if( count($errors) > 0)
                                                @foreach($errors->all() as $error)
                                                    <div class="alert alert-success" role="alert">
                                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                                        <span class="sr-only">{{ trans('labels.Error') }}:</span>
                                                        {{ $error }}
                                                    </div>
                                                @endforeach
                                            @endif

                                            {!! Form::open(array('url' =>'admin/updatepart', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                                <input type="hidden" name="id" value="{{$result['part'][0]->id}}">
                                            <div class="form-group">
                                                <label for="part_title" class="col-sm-2 col-md-3 control-label">{{ trans('labels.part_title') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="text" name="part_title" class="form-control field-validate" value="{{$result['part'][0]->part_title}}">
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.part_title') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Category') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control field-validate" name="category_id" id="category" onchange="getdata(this)" >
                                                        <option value="-1">{{ trans('labels.ChooseCategory') }}</option>
                                                        @foreach ($result['partCategories'] as $categories)
                                                            @if($categories->id==$result['part'][0]->id_part_category)
                                                                <option value="{{ $categories->id }}" selected>{{ $categories->name }}</option>
                                                                @else
                                                               <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ChooseCategory') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.SubCategories') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <select class="form-control field-validate" name="sub_category_id" id="sub_category">
                                                        @foreach ($result['partsubCategories'] as $categories)
                                                            @if($categories->id==$result['part'][0]->id_part_sub_category)
                                                                <option value="{{ $categories->id }}" selected>{{ $categories->slug }}</option>
                                                            @else
                                                                <option value="{{ $categories->id }}">{{ $categories->slug }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.ChooseSubCategory') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="part_weight" class="col-sm-2 col-md-3 control-label">{{ trans('labels.part_Weight') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="text" name="part_weight" class="form-control field-validate" value="{{$result['part'][0]->part_weight}}" id="weight">
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.part_Weight') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="part_fixed_price" class="col-sm-2 col-md-3 control-label">{{ trans('labels.part_fixed_price') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="text" name="part_fixed_price" class="form-control field-validate" value="{{$result['part'][0]->part_fixed_price}}" id="price">
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.part_fixed_price') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.part_color') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input id="chosen-value" name="part_color" value="{{$result['part'][0]->part_color}}" class=" form-control field-validate jscolor {valueElement:'chosen-value''}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::file('part_image', array('id'=>'part_image')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                      {{ trans('labels.UploadImageforpart') }}
                                                    </span>
                                                    <a data-toggle="modal" data-target="#myModal" > <img src="{{asset('').$result['part'][0]->part_img}}" alt="" width=" 100px"></a>
                                                    <div id="myModal" class="modal fade" role="dialog">
                                                        <div class="modal-dialog">

                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">{{ trans('labels.Image') }}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <img src="{{asset('').$result['part'][0]->part_img}}" alt="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('labels.Close')}}</button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group">
                                                <label for="customer_group_payment" class="col-sm-2 col-md-3 control-label">{{ trans('labels.payment') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    <input type="radio" name="part_pay_by" id="non_metallic" value="non_metallic" onclick="f1()"  {{$result['part'][0]->part_pay_by=="non_metallic" ? "checked" :"" }}> {{ trans('labels.non_metallic') }}<br>
                                                    <input type="radio" name="part_pay_by" id="gold" value="gold" onclick="f()" {{$result['part'][0]->part_pay_by=="gold" ? "checked" :"" }} > {{ trans('labels.gold') }}<br>
                                                    {{--<input type="radio" name="part_pay_by" id="silver" value="silver"{{$result['part'][0]->part_pay_by=="silver" ? "checked" :"" }}> {{ trans('labels.silver') }}<br>--}}
                                                    {{--<input type="radio" name="part_pay_by"  id="titanium" value="titanium"{{$result['part'][0]->part_pay_by=="titanium" ? "checked" :"" }}> {{ trans('labels.titanium') }}<br>--}}
                                                    {{--<input type="radio" name="part_pay_by" id="iron" value="iron"{{$result['part'][0]->part_pay_by=="iron" ? "checked" :"" }}> {{ trans('labels.iron') }}<br>--}}
                                                </div>
                                            </div>
                                                <div class="form-group" id="ifYes" style="{{$result['part'][0]->part_pay_by=="gold" ? "visibility:visible" :"visibility:hidden" }}">
                                                    <label for="part_barcode" class="col-sm-2 col-md-3 control-label" >{{ trans('labels.part_barcode') }}</label>
                                                    <div class="col-sm-10 col-md-4">
                                                        <input type="text" name="barcode"  id="barcode" value="{{$result['part'][0]->barcode}}">
                                                        <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.part_barcode') }}</span>
                                                        <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                    </div>
                                                </div>


                                            <!-- /.box-body -->
                                            <div class="box-footer text-center">
                                                <button type="submit" class="btn btn-primary">{{ trans('labels.Edit') }} </button>
                                                <a href="{{ URL::to('admin/part')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
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
    <script src="{!! asset('resources/views/admin/plugins/colorpicker/jscolor.js') !!}"></script>
    <script src="{!! asset('resources/views/admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
    <script>
        function f() {
            document.getElementById('ifYes').style.visibility = 'visible';
            document.getElementById('barcode').required="required";
            document.getElementById('weight').required="required";
            document.getElementById('price').required="";
        }
        function f1() {
            document.getElementById('weight').required="";
            document.getElementById('barcode').required="";
            document.getElementById('barcode').value="";
            document.getElementById('price').required="required";
            document.getElementById('ifYes').style.visibility = 'hidden';
        }
        function setTextColor(picker) {
            document.getElementById('chosen-value').style.backgroundColor = '#' + picker.toString()
        }
        var count = 1;

        function getdata(e) {
            // alert("OK");
            var e = document.getElementById("category");
            var id = e.options[e.selectedIndex].value;
            $.post("{{asset('/admin/getsubpart/')}}",
                {
                    id: id
                },
                function (data, status) {
                    // alert("Data: " + data + "\nStatus: " + status);
                    // console.log(data);
                    add_data(e , data);
                });
            var el = document.getElementById("weight");
            if(e.options[e.selectedIndex].value == 40){
                el.value =" ";
            }else{
                el.value ="";
            }
        }

        function add_data(e , data) {

            // after that fetch and get data from server
            // var current_row = e.parentElement.parentElement;
            // var current_row_select_two = current_row.getElementsByTagName("select")[1];
            // current_row_select_two.innerHTML = "";

            var elm = document.getElementById("sub_category") ;
            elm.innerHTML = '' ;

            for (let i = 0; i < data.length; i++) {
                var option = document.createElement("option");
                // option.text = "item_" + i;
                // option.value = "item_" + i;

                option.text = data[i]['part_categories_slug'];
                option.value = data[i]['part_categories_id'];
                elm.add(option);
            }

        }

    </script>
@endsection