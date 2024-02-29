<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
       {{-- <li class="nav-item menu-open">
            <a href="{{ url('/') }}" class="nav-link ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ url('/companies') }}" class="nav-link {{ request()->is('companies') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Companies
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/warehouses') }}" class="nav-link {{ request()->is('warehouses') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Warehouses
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/sectors') }}" class="nav-link {{ request()->is('sectors') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Sectors
                </p>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{ url('/categories') }}" class="nav-link {{ request()->is('categories') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Categories
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/units') }}" class="nav-link {{ request()->is('units') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Units
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{url('/products')}}" class="nav-link {{ (request()->is('products')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Products
                </p>
            </a>
        </li> 
        <li class="nav-item">
            <a href="{{ url('/roles') }}" class="nav-link {{ request()->is('roles') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Roles
                </p>
            </a>
        </li>
        

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                    Processes
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
               
                <li class="nav-item">
                    <a href="{{ url('/store') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Housing Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/store_withdrawals') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exchange Products</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Products Inventory</p>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                    Import Data
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('/import_data/categories') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Import Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/import_data/products') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Import Products</p>
                    </a>
                </li>
            </ul>
        </li>


    </ul>

</nav>
@push('scripts')
@endpush
