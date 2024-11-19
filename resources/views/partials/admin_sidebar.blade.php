<div class="d-flex flex-column flex-shrink-0 p-3 bg-light sticky-top fixed-container" style="width: 280px;">
    <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none fs-5">
        Admin Dashboard
    </p>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link " aria-current="page">
                <i class="fa-solid fa-user"></i>
                User
            </a>
        </li>
        <li>
            <a href="#productSubmenu" data-bs-toggle="collapse" class="nav-link dropdown-toggle">
                <i class="fas fa-box-open"></i>
                Products
            </a>
            <ul class="collapse list-unstyled" id="productSubmenu">
                <li>
                    <a href="{{ route('product.showForm') }}" class="nav-link">Add Product</a>
                </li>
                <li>
                    <a href="{{ route('products.index') }}" class="nav-link">Manage Products</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#orderSubmenu" data-bs-toggle="collapse" class="nav-link dropdown-toggle">
                <i class="fa-solid fa-cart-shopping"></i>
                Order
            </a>
            <ul class="collapse list-unstyled" id="orderSubmenu">
                <li>
                    <a href="{{ route('order.index' )}}" class="nav-link">Manage Order</a>
                </li>
            </ul>
        </li>
        <!-- More menu items -->
    </ul>
</div>
