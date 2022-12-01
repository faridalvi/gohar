@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
    <div class="container-fluid">
        <div class="py-4">
            <p class="page-title">Dashboard</p>
        </div>
        <div class="card rounded-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                            <div class="row mb-4">
                                <div class="col">
                                    <select name="main_category" class="form-control rounded-0" id="main-category">
                                        <option value="">Main Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col ms-2">
                                    <select name="sub_category" class="form-control rounded-0" id="sub-category">
                                    </select>
                                </div>
                                <div class="col ms-2">
                                    <select name="customer" class="form-control rounded-0" id="customerId">
                                        <option value="">Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col ms-2">
                                    <select name="season" class="form-control rounded-0" id="seasonId">
                                        <option value="">Season</option>
                                        @foreach($seasons as $season)
                                            <option value="{{$season->id}}">{{$season->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col ms-2">
                                    <select name="region" class="form-control rounded-0" id="regionId">
                                        <option value="">Region</option>
                                        @foreach($regions as $region)
                                            <option value="{{$region->id}}">{{$region->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col ms-2">
                                    <select name="yarn" class="form-control rounded-0" id="yarnId">
                                        <option value="">Yarn Type</option>
                                        @foreach($yarns as $yarn)
                                            <option value="{{$yarn->id}}">{{$yarn->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4" id="productData"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $( function() {
            $( "#datepicker" ).datepicker();
            var hash = {};
            hash['main'] = hash['sub'] = hash['customerId']= hash['seasonId'] =hash['regionId'] =hash['yarnId']= "";

            $('#sub-category').html('<option value="">Sub Select</option>');
            $(document).ready(function (){
                //Select Sub Category
                $('#main-category').on('change', function () {
                    var idMainCategory = this.value;
                    hash['main'] = idMainCategory
                    hash['sub'] = ''
                    getFilters(hash)
                    $.ajax({
                        url: "{{route('fetchCategories')}}",
                        type: "POST",
                        data: {
                            main_category_id: idMainCategory,
                            _token: '{{csrf_token()}}'
                        },
                        dataType: 'json',
                        success: function (result) {
                            $('#sub-category').html('<option value="">Sub Category</option>');
                            $.each(result.categories, function (key, value) {
                                $("#sub-category").append('<option value="' + value.id + '" >' + value.name + '</option>');
                            });
                        }
                    });
                });
                //Get Customer
                $('#customerId').on('change', function () {
                    hash['customerId'] = this.value;
                    getFilters(hash)
                });
                $('#sub-category').on('change', function () {
                    hash['sub'] = this.value
                    getFilters(hash)
                });
                //Get Season
                $('#seasonId').on('change', function () {
                    hash['seasonId'] = this.value;
                    getFilters(hash)
                });
                //Get Region
                $('#regionId').on('change', function () {
                    hash['regionId'] = this.value;
                    getFilters(hash)
                });
                //Get Yarn
                $('#yarnId').on('change', function () {
                    hash['yarnId'] = this.value;
                    getFilters(hash)
                });
                //Filters
                $.ajax({
                    url: "{{route('getDashboardProducts')}}",
                    type: "GET",
                    dataType: 'json',
                    success: function (result) {
                        var productData = '';
                        $.each(result.products, function (key, value) {
                            var image ='{{ asset('product/')}}'+'/'+ value.image;
                            productData+='<div class="col-md-2 product-image mb-2">';
                            productData+='<img src="' + image + '" alt="'+value.name+'" class="img-thumbnail">';
                            productData+='</div>';
                        });
                        $("#productData").append(productData);
                    }
                });
                function getFilters(data){
                    $("#productData").html('')
                    $.ajax({
                        url: "{{route('getDashboardProducts')}}",
                        type: "GET",
                        data: data,
                        dataType: 'json',
                        success: function (result) {
                            $("#productData").html('')
                            var productData = '';
                           if (result.products.length > 0) {
                               $.each(result.products, function (key, value) {
                                   var image = '{{ asset('product/')}}' + '/' + value.image;
                                   productData += '<div class="col-md-2 product-image mb-2">';
                                   productData += '<img src="' + image + '" alt="' + value.name + '" class="img-thumbnail">';
                                   productData += '</div>';
                               });
                           }
                           else{
                               productData += '<div class="col-md-12 mb-2"><h1>No Data Found</h1></div>';
                           }
                            $("#productData").append(productData);
                        }
                    });
                }

            })

        } );
    </script>
@endpush
