<!--=============== HEADER ===============-->
<header class="header" id="header">
    <div class="header__container">
        <a href="{{ route('seller.dashboard') }}" class="header__logo">
            <!-- <i class="ri-cloud-fill"></i> -->
            <span>Hungry FalCONs</span>
        </a>

        <button class="header__toggle" id="header-toggle">
            <i class="ri-menu-line"></i>
        </button>
    </div>
</header>

<!--=============== MAIN ===============-->
<main class="main container" id="main">
    @yield('content')
    <!-- Toastr JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

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

    <!-- Script For notification -->
    <script>
        Pusher.logToConsole = true;

        let shopId = "{{ $shop->id }}";

        // Initialize Pusher
        var pusher = new Pusher('32acbce4969b2fe50044', {
            cluster: 'mt1'
        });

        // Subscribe to the channel
        var channel = pusher.subscribe('notification.' + shopId);

        // Array to store the order references that have already triggered notifications
        var notifiedOrders = [];

        // Bind to the event
        channel.bind('new-order.notification', function(order) {

            // Display Toastr notification with icons and inline content
            if (order && !notifiedOrders.includes(order.order.order_reference)) {
                // Add the order reference to the list of notified orders
                notifiedOrders.push(order.order.order_reference);

                // Customize the Toastr notification to match the appearance of the image
                toastr.info(
                    '<div>' +
                    'New order with reference <strong>' + order.order.order_reference + '</strong>' +
                    '</div>',
                    'New Order Arrived', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 0, // Set timeOut to 0 to make it persist until closed
                        extendedTimeOut: 0, // Ensure the notification stays open
                        positionClass: 'toast-top-right',
                        enableHtml: true,
                        toastClass: 'toast toast-info',
                        onclick: function() {
                            window.location.href = "{{ route('my.orders') }}"; // Redirect to the 'my.orders' route
                        }
                    }

                );
            } else {
                console.error('Invalid data received:', order);
            }
        });

        // Debugging line
        pusher.connection.bind('connected', function() {
            console.log('Pusher connected');
        });
    </script>

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
                        After you have set everything up, you can now open your shop by clicking the button above the logout.
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
</main>

<!--=============== SIDEBAR ===============-->
@php
$userId = session()->get('loginId');
$user = App\Models\UserProfile::where('id', $userId)->first();
$shopName = App\Models\Shop::where('user_id', $userId)->first()->shop_name;
$shop = App\Models\Shop::where('user_id', $userId)->first();
$userType = App\Models\UserType::where('id', $user->user_type_id)->first()->type_name;
$designatedCanteen = App\Models\Building::where('id', $user->seller_building_id)->first()->building_name;
@endphp
<nav class="sidebar" id="sidebar">
    <div class="sidebar__container">
        <div class="sidebar__user">
            <div class="sidebar__info">
                <h3>{{ $shopName }}</h3>
                <span>{{ $userType . ' (' . $designatedCanteen . ')' }}</span>
            </div>
        </div>

        <div class="sidebar__content">
            <div>
                <h3 class="sidebar__title">MAIN</h3>

                <div class="sidebar__list">
                    <a href="{{ route('seller.dashboard') }}" class="sidebar__link {{ Route::currentRouteName() == 'seller.dashboard' ? 'active-link' : '' }}">
                        <i class="ri-pie-chart-2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="sidebar__title">PRODUCTS</h3>

                <div class="sidebar__list">
                    <a href="{{ route('my.products') }}" class="sidebar__link {{ Route::currentRouteName() == 'my.products' ? 'active-link' : '' }}">
                        <i class="bi bi-side bi-box2"></i>
                        <span>My Products</span>
                    </a>

                    <a href="{{ route('product.categories') }}" class="sidebar__link {{ Route::currentRouteName() == 'product.categories' ? 'active-link' : '' }}">
                        <i class="ri-survey-line"></i>
                        <span>Custom Categories</span>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="sidebar__title">ORDERS</h3>

                <div class="sidebar__list">
                    <a href="{{ route('my.orders') }}" class="sidebar__link {{ Route::currentRouteName() == 'my.orders' ? 'active-link' : '' }}">
                        <i class="bi bi-side bi-card-list"></i>
                        <span>My Orders</span>
                    </a>

                    <a href="{{ route('seller.order.history') }}" class="sidebar__link {{ Route::currentRouteName() == 'seller.order.history' ? 'active-link' : '' }}">
                        <i class="bi bi-card-checklist"></i>
                        <span>Orders History</span>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="sidebar__title">SHOP</h3>

                <div class="sidebar__list">
                    <a href="{{ route('shop.update.details') }}" class="sidebar__link {{ Route::currentRouteName() == 'shop.update.details' ? 'active-link' : '' }}">
                        <i class="bi bi-shop"></i>
                        <span>Shop Details</span>
                    </a>

                    <a href="{{ route('shop.view.mode') }}" class="sidebar__link {{ Route::currentRouteName() == 'shop.view.mode' ? 'active-link' : '' }}">
                        <i class="bi bi-eye-fill"></i>
                        <span>View Mode</span>
                    </a>

                    <a href="{{ route('verified') }}" class="sidebar__link {{ Route::currentRouteName() == 'verified' ? 'active-link' : '' }}">
                        <i class="bi bi-patch-check-fill"></i>
                        <span>Verification</span>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="sidebar__title">ACCOUNT</h3>

                <div class="sidebar__list">
                    <a href="{{ route('seller.change.password') }}" class="sidebar__link {{ Route::currentRouteName() == 'seller.change.password' ? 'active-link' : '' }}">
                        <i class="bi bi-person-fill-gear"></i>
                        <span>Change Password</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar__actions">

            <!-- Switch for Open/Closed -->
            <div class="sidebar__link">
                <form class="" id="storeStatusForm" method="POST" action="{{ route('update.shop.status') }}">
                    @csrf
                    <div class="form-check form-switch ">
                        <input class="form-check-input" type="checkbox" id="openClosedSwitch" data-bs-toggle="modal" data-bs-target="#statusModal" onchange="submitStoreStatus(this)" {{ $shop->is_reopen ? 'checked' : '' }}>
                        <label class="form-check-label" for="openClosedSwitch" id="storeStatusLabel">Shop: {{ $shop->is_reopen ? 'Open' : 'Closed' }}</label>
                        <input type="hidden" name="is_reopen" id="storeStatusHiddenInput" value="{{ $shop->is_reopen }}">
                    </div>
                </form>
            </div>


            <a class="sidebar__link" href="{{ route('user.logout') }}">
                <i class="ri-logout-box-r-fill"></i>
                <span>Log Out</span>
            </a>
        </div>
    </div>
</nav>

<!--=============== MAIN JS ===============-->
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

    /*=============== SHOW SIDEBAR ===============*/
    const showSidebar = (toggleId, sidebarId, headerId, mainId) => {
        const toggle = document.getElementById(toggleId),
            sidebar = document.getElementById(sidebarId),
            header = document.getElementById(headerId),
            main = document.getElementById(mainId)

        if (toggle && sidebar && header && main) {
            toggle.addEventListener('click', () => {
                /* Show sidebar */
                sidebar.classList.toggle('show-sidebar')
                /* Add padding header */
                header.classList.toggle('left-pd')
                /* Add padding main */
                main.classList.toggle('left-pd')
            })
        }
    }
    showSidebar('header-toggle', 'sidebar', 'header', 'main')

    /*=============== LINK ACTIVE ===============*/
    const sidebarLink = document.querySelectorAll('.sidebar__list a')

    function linkColor() {
        sidebarLink.forEach(l => l.classList.remove('active-link'))
        this.classList.add('active-link')
    }

    sidebarLink.forEach(l => l.addEventListener('click', linkColor))
</script>

<style>
    /*=============== GOOGLE FONTS ===============*/
    @import url("https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200..1000&display=swap");

    /*=============== VARIABLES CSS ===============*/
    :root {
        --header-height: 3.5rem;

        /*========== Colors ==========*/
        /*Color mode HSL(hue, saturation, lightness)*/
        --first-color: hsl(228, 85%, 63%);
        --title-color: hsl(228, 18%, 16%);
        --text-color: hsl(228, 8%, 56%);
        --body-color: hsl(228, 100%, 99%);
        --shadow-color: hsla(228, 80%, 4%, .1);

        /*========== Font and typography ==========*/
        /*.5rem = 8px | 1rem = 16px ...*/
        --body-font: "Nunito Sans", system-ui;
        --normal-font-size: .938rem;
        --smaller-font-size: .75rem;
        --tiny-font-size: .75rem;

        /*========== Font weight ==========*/
        --font-regular: 400;
        --font-semi-bold: 600;

        /*========== z index ==========*/
        --z-tooltip: 10;
        --z-fixed: 100;
    }

    /*========== Responsive typography ==========*/
    @media screen and (min-width: 1150px) {
        :root {
            --normal-font-size: 1rem;
            --smaller-font-size: .813rem;
        }
    }

    /*=============== BASE ===============*/
    /* * {
        box-sizing: border-box;
        padding: 0;
        margin: 0;
    } */

    body {
        font-family: var(--body-font);
        font-size: var(--normal-font-size);
        background-color: var(--body-color);
        color: var(--text-color);
        transition: background-color .4s;
    }

    a {
        text-decoration: none;
    }

    img {
        display: block;
        max-width: 100%;
        height: auto;
    }

    /* button {
        all: unset;
    } */

    /*=============== REUSABLE CSS CLASSES ===============*/
    /* .container {
        margin-inline: 1.5rem;
    }

    .main {
        padding-top: 5rem;
    } */

    

    /*=============== HEADER ===============*/
    .header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: var(--z-fixed);
        margin: .75rem;
    }

    .header__container {
        width: 100%;
        height: var(--header-height);
        background-color: var(--body-color);
        box-shadow: 0 2px 24px var(--shadow-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-inline: 1.5rem;
        border-radius: 1rem;
        transition: background-color .4s;
    }

    .header__logo {
        display: inline-flex;
        align-items: center;
        column-gap: .25rem;
    }

    .header__logo i {
        font-size: 1.5rem;
        color: var(--first-color);
    }

    .header__logo span {
        color: var(--title-color);
        font-weight: var(--font-semi-bold);
    }

    .header__toggle {
        font-size: 1.5rem;
        color: var(--title-color);
        cursor: pointer;
    }

    /*=============== SIDEBAR ===============*/
    .sidebar {
        position: fixed;
        left: -120%;
        top: 0;
        bottom: 0;
        z-index: var(--z-fixed);
        width: 288px;
        background-color: var(--body-color);
        box-shadow: 2px 0 24px var(--shadow-color);
        padding-block: 1.5rem;
        margin: .75rem;
        border-radius: 1rem;
        transition: left .4s, background-color .4s, width .4s;
    }

    .sidebar__container,
    .sidebar__content {
        display: flex;
        flex-direction: column;
        row-gap: 3rem;
    }

    .sidebar__container {
        height: 100%;
        overflow: hidden;
    }

    .sidebar__user {
        display: grid;
        grid-template-columns: repeat(2, max-content);
        align-items: center;
        column-gap: 1rem;
        padding-left: 2rem;
    }

    .sidebar__img {
        position: relative;
        width: 50px;
        height: 50px;
        background-color: var(--first-color);
        border-radius: 50%;
        overflow: hidden;
        display: grid;
        justify-items: center;
    }

    .sidebar__img img {
        position: absolute;
        width: 36px;
        bottom: -1px;
    }

    .sidebar__info h3 {
        font-size: var(--normal-font-size);
        color: var(--title-color);
        transition: color .4s;
    }

    .sidebar__info span {
        font-size: var(--smaller-font-size);
    }

    .sidebar__content {
        overflow: hidden auto;
    }

    .sidebar__content::-webkit-scrollbar {
        width: .4rem;
        background-color: hsl(228, 8%, 85%);
    }

    .sidebar__content::-webkit-scrollbar-thumb {
        background-color: hsl(228, 8%, 75%);
    }

    .sidebar__title {
        width: max-content;
        font-size: var(--tiny-font-size);
        font-weight: var(--font-semi-bold);
        padding-left: 2rem;
        margin-bottom: 1.5rem;
    }

    .sidebar__list,
    .sidebar__actions {
        display: grid;
        row-gap: 1.5rem;
    }

    .sidebar__link {
        position: relative;
        display: grid;
        grid-template-columns: repeat(2, max-content);
        align-items: center;
        column-gap: 1rem;
        color: var(--text-color);
        padding-left: 2rem;
        transition: color .4s, opacity .4s;
    }

    .sidebar__link i {
        font-size: 1.25rem;
    }

    .sidebar__link span {
        font-weight: var(--font-semi-bold);
    }

    .sidebar__link:hover {
        color: var(--first-color);
    }

    .sidebar__actions {
        margin-top: auto;
    }

    .sidebar__actions button {
        cursor: pointer;
    }

    .sidebar__theme {
        width: 100%;
        font-size: 1.25rem;
    }

    .sidebar__theme span {
        font-size: var(--normal-font-size);
        font-family: var(--body-font);
    }

    /* Show sidebar */
    .show-sidebar {
        left: 0;
    }

    /* Active link */
    .active-link {
        color: var(--first-color);
    }

    .active-link::after {
        content: "";
        position: absolute;
        left: 0;
        width: 3px;
        height: 20px;
        background-color: var(--first-color);
    }

    /*=============== BREAKPOINTS ===============*/
    /* For small devices */
    @media screen and (max-width: 360px) {
        .header__container {
            padding-inline: 1rem;
        }

        .sidebar {
            width: max-content;
        }

        .sidebar__info,
        .sidebar__link span {
            display: none;
        }

        .sidebar__user,
        .sidebar__list,
        .sidebar__actions {
            justify-content: center;
        }

        .sidebar__user,
        .sidebar__link {
            grid-template-columns: max-content;
        }

        .sidebar__user {
            padding: 0;
        }

        .sidebar__link {
            padding-inline: 2rem;
        }

        .sidebar__title {
            padding-inline: .5rem;
            margin-inline: auto;
        }
    }

    /* For large devices */
    @media screen and (min-width: 1150px) {
        .header {
            margin: 1rem;
            padding-left: 340px;
            transition: padding .4s;
        }

        .header__container {
            height: calc(var(--header-height) + 2rem);
            padding-inline: 2rem;
        }

        .header__logo {
            order: 1;
        }

        .sidebar {
            left: 0;
            width: 316px;
            margin: 1rem;
        }

        .sidebar__info,
        .sidebar__link span {
            transition: opacity .4s;
        }

        .sidebar__user,
        .sidebar__title {
            transition: padding .4s;
        }

        /* Reduce sidebar */
        .show-sidebar {
            width: 90px;
        }

        .show-sidebar .sidebar__user {
            padding-left: 1.25rem;
        }

        .show-sidebar .sidebar__title {
            padding-left: 0;
            margin-inline: auto;
        }

        .show-sidebar .sidebar__info,
        .show-sidebar .sidebar__link span {
            opacity: 0;
        }

        .main {
            padding-left: 340px;
            padding-top: 8rem;
            transition: padding .4s;
        }

        /* Add padding left */
        .left-pd {
            padding-left: 114px;
        }
    }
</style>