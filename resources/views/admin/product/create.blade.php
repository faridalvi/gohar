@extends('admin.layouts.app')
@section('title','Add New')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between py-4">
            <p class="page-title">Add New</p>
            <a class="btn btn-sm btn-warning" href="{{route('product.index')}}">View All</a>
        </div>
        <div class="card rounded-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Entry *</label>
                                    <input type="text" class="form-control rounded-0" name="entry" value="{{old('entry')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date *</label>
                                    <input type="text" class="form-control rounded-0" id="datepicker" name="date" value="{{old('date')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product Name *</label>
                                    <input type="text" class="form-control rounded-0" name="name" value="{{old('name')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sales Order # *</label>
                                    <input type="text" class="form-control rounded-0" name="sale_order" value="{{old('sale_order')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Main Category *</label>
                                    <select name="main_category" class="form-control rounded-0" id="main-category">
                                        <option value="">Please Select</option>
                                        @if(count($categories) > 0)
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}" @if(old('main_category') == $category->id) selected @endif>{{$category->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Main Category *</label>
                                    <select name="sub_category" class="form-control rounded-0" id="sub-category">
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Season *</label>
                                    <select name="season" class="form-control rounded-0">
                                        <option value="">Please Select</option>
                                        @if(count($seasons) > 0)
                                            @foreach($seasons as $season)
                                                <option value="{{$season->id}}" @if(old('season') == $season->id) selected @endif>{{$season->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Age Group *</label>
                                    <select name="age_group" class="form-control rounded-0">
                                        <option value="">Please Select</option>
                                        @if(count($ageGroups) > 0)
                                            @foreach($ageGroups as $ageGroup)
                                                <option value="{{$ageGroup->id}}" @if(old('age_group') == $ageGroup->id) selected @endif>{{$ageGroup->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country *</label>
                                    <select name="country" class="form-control rounded-0" id="countryId">
                                        <option value="">Please Select</option>
                                        @if(count($countries) > 0)
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" @if(old('country') == $country->id) selected @endif>{{$country->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Region *</label>
                                    <select name="region" class="form-control rounded-0" id="regionId">
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Customer *</label>
                                    <select name="customer" class="form-control rounded-0">
                                        <option value="">Please Select</option>
                                        @if(count($customers) > 0)
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}" @if(old('customer') == $customer->id) selected @endif>{{$customer->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Loom Type *</label>
                                    <select name="loom_type" class="form-control rounded-0">
                                        <option value="">Please Select</option>
                                        @if(count($looms) > 0)
                                            @foreach($looms as $loom)
                                                <option value="{{$loom->id}}" @if(old('loom_type') == $loom->id) selected @endif>{{$loom->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Greige Quality *</label>
                                    <input type="text" class="form-control rounded-0" name="greige_quality" value="{{old('greige_quality')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Composition *</label>
                                    <input type="text" class="form-control rounded-0" name="composition" value="{{old('composition')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Finish Fabric Quality *</label>
                                    <input type="text" class="form-control rounded-0" name="finish_fabric_quality" value="{{old('finish_fabric_quality')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">GSM *</label>
                                    <input type="text" class="form-control rounded-0" name="gsm" value="{{old('gsm')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Process *</label>
                                    <input type="text" class="form-control rounded-0" name="process" value="{{old('process')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Atribute Yarn *</label>
                                    <select name="atribute_yarn" class="form-control rounded-0">
                                        <option value="">Please Select</option>
                                        @if(count($yarns) > 0)
                                            @foreach($yarns as $yarn)
                                                <option value="{{$yarn->id}}" @if(old('atribute_yarn') == $yarn->id) selected @endif>{{$yarn->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Atribute Weaving *</label>
                                    <select name="atribute_weaving" class="form-control rounded-0">
                                        <option value="">Please Select</option>
                                        @if(count($weavings) > 0)
                                            @foreach($weavings as $weaving)
                                                <option value="{{$weaving->id}}" @if(old('atribute_weaving') == $weaving->id) selected @endif>{{$weaving->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Atribute Processing *</label>
                                    <select name="atribute_processing" class="form-control rounded-0">
                                        <option value="">Please Select</option>
                                        @if(count($processings) > 0)
                                            @foreach($processings as $processing)
                                                <option value="{{$processing->id}}" @if(old('atribute_processing') == $processing->id) selected @endif>{{$processing->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Atribute Stitching *</label>
                                    <select name="atribute_stitching" class="form-control rounded-0">
                                        <option value="">Please Select</option>
                                        @if(count($stitchings) > 0)
                                            @foreach($stitchings as $stitching)
                                                <option value="{{$stitching->id}}" @if(old('atribute_stitching') == $stitching->id) selected @endif>{{$stitching->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Fabric Type *</label>
                                    <select name="fabric_type" class="form-control rounded-0">
                                        <option value="">Please Select</option>
                                        @if(count($fabrics) > 0)
                                            @foreach($fabrics as $fabric)
                                                <option value="{{$fabric->id}}" @if(old('fabric_type') == $fabric->id) selected @endif>{{$fabric->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Description *</label>
                                    <input type="text" class="form-control rounded-0" name="description" value="{{old('description')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Image *</label>
                                    <input type="file" class="form-control rounded-0" name="image">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Gallery *</label>
                                    <input type="file" class="form-control rounded-0" name="gallery[]" multiple>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input type="submit" class="btn btn-sm btn-success" value="Add New">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                format: 'yy/mm/dd',
            });
            $('#sub-category').html('<option value="">Please Select</option>');
            $('#regionId').html('<option value="">Please Select</option>');
            $(document).ready(function (){
                //Select Sub Category
                $('#main-category').on('change focus', function () {
                    var idMainCategory = this.value;
                    $("#sub-category").html('');
                    $.ajax({
                        url: "{{route('fetchCategories')}}",
                        type: "POST",
                        data: {
                            main_category_id: idMainCategory,
                            _token: '{{csrf_token()}}'
                        },
                        dataType: 'json',
                        success: function (result) {
                            $('#sub-category').html('<option value="">Please Select</option>');
                            $.each(result.categories, function (key, value) {
                                $("#sub-category").append('<option value="' + value.id + '" >' + value.name + '</option>');
                            });
                        }
                    });
                });
                //Select Region
                $('#countryId').on('change focus', function () {
                    var idCountry = this.value;
                    $("#regionId").html('');
                    $.ajax({
                        url: "{{route('fetchRegions')}}",
                        type: "POST",
                        data: {
                            country_id: idCountry,
                            _token: '{{csrf_token()}}'
                        },
                        dataType: 'json',
                        success: function (result) {
                            $('#regionId').html('<option value="">Please Select</option>');
                            $.each(result.regions, function (key, value) {
                                $("#regionId").append('<option value="' + value.id + '" >' + value.name + '</option>');
                            });
                        }
                    });
                });
            })
        } );
    </script>
@endpush
