@extends('admin.layouts.app')
@section('title','Products')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between py-4">
            <p class="page-title">Products</p>
            <a class="btn btn-sm btn-success" href="{{route('product.create')}}">Add New</a>
        </div>
        <div class="card rounded-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm dataTable">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Sub Category</th>
                            <th scope="col">Parent Category</th>
                            <th scope="col">Season</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function (){
            var t = $('.dataTable').DataTable({
                processing: true,
                serverSide: true,
                order:[[0,'desc']],
                ajax: "{{route('getProducts')}}",
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'customer' },
                    { data: 'sub_category' },
                    { data: 'parent_category' },
                    { data: 'season' },
                    { data: null}
                ],
                columnDefs: [
                    {
                        render: function ( data, type, row,meta ) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        searchable:false,
                        orderable:true,
                        targets: 0
                    },
                    {
                        render: function (data,type,row,meta) {
                            var edit ='{{ route("product.edit", ":id") }}';
                            edit = edit.replace(':id', data.id);
                            var del ='{{ route("product.destroy", ":id") }}';
                            del = del.replace(':id', data.id);

                            return '<div class="d-flex">' +
                                @can('product-edit')
                                    '<a href="'+edit+'" class="btn btn-sm btn-warning mx-2"><i class="fa fa-edit"></i></a>'+
                                @endcan
                                    @can('product-delete')
                                    '<form action="'+del+'" method="POST">'+
                                '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                                '<input type="hidden" name="_method" value="delete" />'+
                                '<button type="submit" class="btn btn-sm btn-danger mx-2" onclick="return confirm(`Are you sure?`)"><i class="fa fa-trash"></i></button>'+
                                '</form>'+
                                @endcan
                                    '</div>';
                        },
                        searchable:false,
                        orderable:false,
                        targets: -1
                    }
                ]
            });
        });
    </script>
@endpush
