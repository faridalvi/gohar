@extends('admin.layouts.app')
@section('title','Edit')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between py-4">
            <p class="page-title">Edit</p>
            <a class="btn btn-sm btn-warning" href="{{route('customer.index')}}">View All</a>
        </div>
        <div class="card rounded-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('customer.update',$customer->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control rounded-0" name="name" value="{{(isset($customer->name))?$customer->name:old('name')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" class="form-control rounded-0" name="email" value="{{(isset($customer->email))?$customer->email:old('email')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile *</label>
                                    <input type="text" class="form-control rounded-0" name="mobile" value="{{(isset($customer->mobile))?$customer->mobile:old('mobile')}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Address *</label>
                                    <input type="text" class="form-control rounded-0" name="address" value="{{(isset($customer->address))?$customer->address:old('address')}}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input type="submit" class="btn btn-sm btn-success" value="Update">
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
