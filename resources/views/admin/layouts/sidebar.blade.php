<nav class="sidebar">
    <nav class="sidebar-menu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <div class="user-info">
                    <div class="image">
                        <img src="{{asset('admin/images/user.png')}}" width="48" height="48" alt="User">
                    </div>
                    <div class="info-container">
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}}</div>
                        <div class="email">{{Auth::user()->email}}</div>
                    </div>
                </div>
            </li>
            <li class="main-navigation">
                Main Navigation
            </li>
            @can('dashboard')
                <li class="nav-item mt-2 waves-effect">
                    <a class="nav-link" aria-current="page" href="{{route('dashboard')}}">
                        <span>Home</span>
                    </a>
                </li>
            @endcan
            @canany(['permission-group-list','permission-group-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="permission_group" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Permission Group
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="permission_group">
                        @can('permission-group-create')
                            <li><a class="dropdown-item" href="{{route('permission_group.create')}}">Add New</a></li>
                        @endcan
                        @can('permission-group-list')
                            <li><a class="dropdown-item" href="{{route('permission_group.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['permission-list','permission-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="permission" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Permission
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="permission">
                        @can('permission-create')
                            <li><a class="dropdown-item" href="{{route('permission.create')}}">Add New</a></li>
                        @endcan
                        @can('permission-list')
                            <li><a class="dropdown-item" href="{{route('permission.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['role-list','role-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="permission" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Role
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="permission">
                        @can('role-create')
                            <li><a class="dropdown-item" href="{{route('role.create')}}">Add New</a></li>
                        @endcan
                        @can('role-list')
                            <li><a class="dropdown-item" href="{{route('role.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['user-list','user-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="user" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Users
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="user">
                        @can('user-create')
                            <li><a class="dropdown-item" href="{{route('user.create')}}">Add New</a></li>
                        @endcan
                        @can('user-list')
                            <li><a class="dropdown-item" href="{{route('user.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['category-list','category-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="category" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Category
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="category">
                        @can('category-create')
                            <li><a class="dropdown-item" href="{{route('category.create')}}">Add New</a></li>
                        @endcan
                        @can('category-list')
                            <li><a class="dropdown-item" href="{{route('category.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['season-list','season-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="season" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Season
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="category">
                        @can('season-create')
                            <li><a class="dropdown-item" href="{{route('season.create')}}">Add New</a></li>
                        @endcan
                        @can('season-list')
                            <li><a class="dropdown-item" href="{{route('season.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['age-group-list','age-group-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="age-group" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Age Group
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="age-group">
                        @can('age-group-create')
                            <li><a class="dropdown-item" href="{{route('age-group.create')}}">Add New</a></li>
                        @endcan
                        @can('age-group-list')
                            <li><a class="dropdown-item" href="{{route('age-group.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['country-list','country-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="country" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Country
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="country">
                        @can('country-create')
                            <li><a class="dropdown-item" href="{{route('country.create')}}">Add New</a></li>
                        @endcan
                        @can('country-list')
                            <li><a class="dropdown-item" href="{{route('country.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['region-list','region-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="region" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Region
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="region">
                        @can('region-create')
                            <li><a class="dropdown-item" href="{{route('region.create')}}">Add New</a></li>
                        @endcan
                        @can('region-list')
                            <li><a class="dropdown-item" href="{{route('region.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['customer-list','customer-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="customer" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Customer
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="customer">
                        @can('customer-create')
                            <li><a class="dropdown-item" href="{{route('customer.create')}}">Add New</a></li>
                        @endcan
                        @can('customer-list')
                            <li><a class="dropdown-item" href="{{route('customer.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['loom-type-list','loom-type-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="loom-type" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Loom Type
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="loom-type">
                        @can('loom-type-create')
                            <li><a class="dropdown-item" href="{{route('loom-type.create')}}">Add New</a></li>
                        @endcan
                        @can('loom-type-list')
                            <li><a class="dropdown-item" href="{{route('loom-type.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['atribute-yarn-list','atribute-yarn-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="atribute-yarn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Attribute Yarn
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="atribute-yarn">
                        @can('atribute-yarn-create')
                            <li><a class="dropdown-item" href="{{route('atribute-yarn.create')}}">Add New</a></li>
                        @endcan
                        @can('atribute-yarn-list')
                            <li><a class="dropdown-item" href="{{route('atribute-yarn.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['atribute-weaving-list','atribute-weaving-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="atribute-weaving" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Attribute Weaving
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="atribute-weaving">
                        @can('atribute-weaving-create')
                            <li><a class="dropdown-item" href="{{route('atribute-weaving.create')}}">Add New</a></li>
                        @endcan
                        @can('atribute-weaving-list')
                            <li><a class="dropdown-item" href="{{route('atribute-weaving.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['atribute-processing-list','atribute-processing-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="atribute-processing" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Attribute Processing
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="atribute-processing">
                        @can('atribute-processing-create')
                            <li><a class="dropdown-item" href="{{route('atribute-processing.create')}}">Add New</a></li>
                        @endcan
                        @can('atribute-processing-list')
                            <li><a class="dropdown-item" href="{{route('atribute-processing.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['atribute-stitching-list','atribute-stitching-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="atribute-stitching" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Attribute Stitching
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="atribute-processing">
                        @can('atribute-stitching-create')
                            <li><a class="dropdown-item" href="{{route('atribute-stitching.create')}}">Add New</a></li>
                        @endcan
                        @can('atribute-stitching-list')
                            <li><a class="dropdown-item" href="{{route('atribute-stitching.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['fabric-type-list','fabric-type-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="fabric-type" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Fabric Type
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="fabric-type">
                        @can('fabric-type-create')
                            <li><a class="dropdown-item" href="{{route('fabric-type.create')}}">Add New</a></li>
                        @endcan
                        @can('fabric-type-list')
                            <li><a class="dropdown-item" href="{{route('fabric-type.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['product-list','product-create'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect" href="#" id="product" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>
                        Product
                    </span>
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="product">
                        @can('product-create')
                            <li><a class="dropdown-item" href="{{route('product.create')}}">Add New</a></li>
                        @endcan
                        @can('product-list')
                            <li><a class="dropdown-item" href="{{route('product.index')}}">View All</a></li>
                        @endcan
                    </ul>
                </li>
            @endcanany
        </ul>
    </nav>
</nav>
