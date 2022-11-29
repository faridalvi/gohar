@extends('admin.layouts.app')
@section('title','Add New')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between py-4">
            <p class="page-title">Add New</p>
            <a class="btn btn-sm btn-warning" href="{{route('region.index')}}">View All</a>
        </div>
        <div class="card rounded-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('region.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control rounded-0" name="name" value="{{old('name')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Code *</label>
                                    <input type="text" class="form-control rounded-0" name="code" value="{{old('code')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country *</label>
                                    <select name="country_id" id="" class="form-control rounded-0">
                                        <option value="">Please Select</option>
                                        @if(count($countries) > 0)
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        @endif
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

@endpush
