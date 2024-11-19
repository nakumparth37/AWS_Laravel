<div class="d-flex flex-column flex-shrink-0 p-3 bg-light sticky-top fixed-container" style="width: 280px;">
    <p class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none fs-5">
        Seller Dashboard
    </p>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li>
            <a href="#productSubmenu" data-bs-toggle="collapse" class="nav-link dropdown-toggle">
                <i class="fas fa-box-open"></i>
                Products
            </a>
            <ul class="collapse list-unstyled" id="productSubmenu">
                <li>
                    <a href="{{ route('seller_product.showForm') }}" class="nav-link">Add Product</a>
                </li>
                <li>
                    <a href="{{ route('seller_Products') }}" class="nav-link">Manage Products</a>
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
                    <a href="#" class="nav-link">Add Order</a>
                </li>
                <li>
                    <a href="#" class="nav-link">Manage Order</a>
                </li>
            </ul>
        </li>
        <!-- More menu items -->
    </ul>
</div>
