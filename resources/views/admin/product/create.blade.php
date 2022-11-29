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
                        <form action="{{route('product.store')}}" method="post">
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
                                    <label class="form-label">Main Category # *</label>
                                    <select name="main_category" class="form-control rounded-0" id="main-category">
                                        <option value="">Please Select</option>
                                        @if(count($categories) > 0)
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Main Category # *</label>
                                    <select name="main_category" class="form-control rounded-0" id="sub-category">
                                    </select>
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
            $( "#datepicker" ).datepicker();
            $('#sub-category').html('<option value="">Please Select</option>');
            //Select Sub Category
            $(document).ready(function (){
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
            })
        } );
    </script>
@endpush
