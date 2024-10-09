<!-- Navbar and Sidebar Container -->
<div class="navbar-sidebar-container">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn li-a" onclick="closeNav()">×</a>
        <a class="btn-side" href="{{ route('seller.dashboard') }}"><i class="bi bi-easel"></i> DASHBOARD</a>

        <button class="btn btn-side btn-toggle rounded collapsed" data-bs-toggle="collapse" data-bs-target="#product-collapse" aria-expanded="true">
            <i class="bi bi-side bi-box2"></i>
            PRODUCTS
        </button>
        <div class="collapse show ps-3" id="product-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                <li class="li-sub"><a href="{{ route('my.products.table') }}" class="li-a">Products Table</a></li>
                <li class="li-sub"><a href="{{ route('my.products') }}" class="li-a">My Products</a></li>
                <li class="li-sub"><a href="{{ route('product.categories') }}" class="li-a">Custom Categories</a></li>
            </ul>
        </div>

        <button class="btn btn-side btn-toggle rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="true">
            <i class="bi bi-side bi-card-list"></i>
            ORDERS
        </button>
        <div class="collapse show ps-3" id="orders-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                <li class="li-sub"><a href="{{ route('my.orders') }}" class="li-a">My Orders</a></li>
                <li class="li-sub"><a href="{{ route('seller.order.history') }}" class="li-a">Order History</a></li>
            </ul>
        </div>

        <button class="btn btn-side btn-toggle rounded collapsed" data-bs-toggle="collapse" data-bs-target="#shop-collapse">
            <i class="bi bi-shop"></i>
            SHOP
        </button>
        <div class="collapse show ps-3" id="shop-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                <li class="li-sub"><a href="{{ route('shop.view.mode') }}" class="li-a">View Mode</a></li>
                <li class="li-sub"><a href="{{ route('shop.update.details') }}" class="li-a">Shop Details</a></li>
                <!-- <li class="li-sub"><a href="" class="li-a">Payment Method</a></li> -->
            </ul>
        </div>

        <a class="btn-side" href="{{ route('verified') }}"><i class="bi bi-side bi-check2-square"></i> VERIFICATION</a>
    </div>

    @php
    use Carbon\Carbon;
    $userId = session()->get('loginId');
    $shop = App\Models\Shop::where('user_id', $userId)->first();
    $permits = App\Models\Permit::where('shop_id', $shop->id)->where('status', 'Approved')->first();

    // Check if the shop is new (within the last 50 minutes)
    $isNewShop = false;
    if ($shop && Carbon::parse($permits->updated_at)->gt(Carbon::now()->subMinutes(30))) {
    session()->put('isNewShop', true);
    $isNewShop = true;
    } else {
    session()->put('isNewShop', false);
    }
    @endphp

    <!-- First Ever Modal -->
    <div class="modal fade" id="firstModalEver" tabindex="-1" aria-labelledby="firstModalEver" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="firstModalEverLabel">Shop Update</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>
                        <strong>Shop temporarily closed.</strong>
                    </h4>
                    <div class="alert alert-primary">
                        <h4>
                            <strong>Welcome to our platform!</strong>
                        </h4>
                        Set up your shop and products to start receiving orders.
                        After you have set up your shop, you can open it by clicking at the Profile Button located at the
                        Top right of your screen.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Status Update -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="statusModalLabel">Shop Update</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload();"></button>
                </div>
                @if($shop->is_reopen)
                <div class="modal-body">
                    <h4>
                        <strong>Shop temporarily closed.</strong>
                    </h4>
                    <div class="alert alert-primary">
                        You can re-open it again anytime soon. Updating exsisting orders are disabled as well.
                        Shop will not be recieving orders for the mean time.
                    </div>
                </div>
                @else
                <div class="modal-body">
                    <h4>
                        <strong>Shop is now open.</strong>
                    </h4>
                    <div class="alert alert-primary">
                        Editing products, categories, and shop details are disabled while your shop is open.
                        You can now recieve orders.
                    </div>
                </div>
                @endif
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload();">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="hamburger" onclick="openNav()">☰</span>
            <a class="navbar-brand" href="{{ route('seller.dashboard') }}">Hungry Falcons</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="px-3 nav-item d-flex align-items-center">
                        <div class="text-white" id="userDropdown" data-bs-toggle="dropdown">
                            {{ $shop->shop_name }}
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle" style="font-size: 30px; color: white;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <!-- Switch for Open/Closed -->
                                    <form id="storeStatusForm" method="POST" action="{{ route('update.shop.status') }}">
                                        @csrf
                                        <div class="ms-2 form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="openClosedSwitch" data-bs-toggle="modal" data-bs-target="#statusModal" onchange="submitStoreStatus(this)" {{ $shop->is_reopen ? 'checked' : '' }}>
                                            <label class="form-check-label" for="openClosedSwitch" id="storeStatusLabel">Shop Status: {{ $shop->is_reopen ? 'Open' : 'Closed' }}</label>
                                            <input type="hidden" name="is_reopen" id="storeStatusHiddenInput" value="{{ $shop->is_reopen }}">
                                        </div>
                                    </form>
                                </li>
                                <hr>
                                <li><a class="dropdown-item" href="{{ route('seller.change.password') }}">Change Password</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.logout') }}" onclick="sessionStorage.removeItem('modalClosed');">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- Bootstrap Bundle with Popper.js -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- Sidebar scripts -->
<script>
    function toggleStoreStatus(checkbox) {
        const statusLabel = document.getElementById('storeStatusLabel');
        if (checkbox.checked) {
            statusLabel.textContent = 'Open';
            // Add any additional actions for the "Open" state
        } else {
            statusLabel.textContent = 'Closed';
            // Add any additional actions for the "Closed" state
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Status Modal: Display and Refresh on Close
        @if(session('status_updated'))
        var statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
        statusModal.show();

        // Listen for the hidden.bs.modal event (fired when modal is fully hidden)
        document.getElementById('statusModal').addEventListener('hidden.bs.modal', function() {
            console.log("Modal was closed, reloading the page...");
            location.reload(); // Reload the page when the modal is closed
        });
        @endif

        // First Modal for New Shop
        @if(session('isNewShop'))
        if (!sessionStorage.getItem('modalClosed')) {
            var firstModalEver = new bootstrap.Modal(document.getElementById('firstModalEver'));
            firstModalEver.show();

            // Listen for the hidden.bs.modal event (fired when modal is fully hidden)
            document.getElementById('firstModalEver').addEventListener('hidden.bs.modal', function() {
                sessionStorage.setItem('modalClosed', 'true'); // Set sessionStorage to prevent modal from reappearing
                console.log('First time modal closed.');
            });
        }
        @endif
    });

    function submitStoreStatus(checkbox) {
        // Update hidden input with current checkbox value
        document.getElementById('storeStatusHiddenInput').value = checkbox.checked ? 1 : 0;

        // Create a FormData object to send the form data
        let formData = new FormData(document.getElementById('storeStatusForm'));

        // Use fetch API to send the form data via AJAX
        fetch('{{ route('update.shop.status') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the label based on the current state
                    const statusLabel = document.getElementById('storeStatusLabel');
                    statusLabel.textContent = checkbox.checked ? 'Open' : 'Closed';

                    // Show the modal
                    var statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
                    statusModal.show();
                }
            })
            .catch(error => {
                console.error('Error updating store status:', error);
            });
    }

    function openNav() {
        document.getElementById("sidebar").style.width = "250px";
        document.querySelector(".content-area").style.marginLeft = "250px";
        document.querySelector(".hamburger").style.display = "none";
        document.querySelector(".navbar").style.marginLeft = "250px";
        document.querySelector(".navbar").style.width = "calc(100% - 250px)";
    }

    function closeNav() {
        document.getElementById("sidebar").style.width = "0";
        document.querySelector(".content-area").style.marginLeft = "0";
        document.querySelector(".hamburger").style.display = "inline";
        document.querySelector(".navbar").style.marginLeft = "0";
        document.querySelector(".navbar").style.width = "100%";
    }

    // Automatically close sidebar on small screens
    if (window.innerWidth <= 768) {
        closeNav();
    }

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            document.getElementById("sidebar").style.width = "250px";
            document.querySelector(".content-area").style.marginLeft = "250px";
            document.querySelector(".navbar").style.marginLeft = "250px";
            document.querySelector(".navbar").style.width = "calc(100% - 250px)";
            document.querySelector(".hamburger").style.display = "none";
        } else {
            closeNav();
        }
    });
</script>