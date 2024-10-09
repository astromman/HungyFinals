<aside id="sidebar" class="js-sidebar" style="background-color: #191F2F;">
    <div class="h-100" style="position: fixed;">
        <div class="sidebar-logo">
            <a href=" route ('dashboard') "> <img src="/images/logo.svg" alt="..." style="height: 23px;"> <strong> STOCKSPHERE </strong>
            <p class="no-margin">Inventory Management System</p>
            <hr style="border-color: white;">
        </a>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href=" route ('dashboard') " class="sidebar-link"><i class="fa-solid fa-list pe-2 bi bi-house"></i> DASHBOARD </a>
            </li>
            <li class="sidebar-item">
                <a href=" route ('branch') " class="sidebar-link"><i class="fa-solid fa-list pe-2 bi bi-archive"></i> BRANCH </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#pages" aria-expanded="false">
                    <i class="fa-solid fa-file-lines pe-2 bi bi-graph-up"></i> PERSONNEL
                </a>
                <ul id="pages" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a href=" route ('addpersonnel') " class="sidebar-link">Add Personnel</a></li>
                    <li class="sidebar-item"><a href=" route ('personnel') " class="sidebar-link">View Personnel</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#posts" aria-expanded="false">
                    <i class="fa-solid fa-sliders pe-2 bi bi-archive"></i> INVENTORY
                </a>
                <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a href="#" class="sidebar-link">Products</a></li>
                    <li class="sidebar-item"><a href=" route ('category') " class="sidebar-link">Category</a></li>
                    <li class="sidebar-item"><a href=" route ('vendors') " class="sidebar-link">Vendor</a></li>
                    <li class="sidebar-item"><a href=" route ('admin.tables.adjustments') " class="sidebar-link">Adjustments</a></li>
                    <li class="sidebar-item"><a href=" route ('admin.tables.ingoing') " class="sidebar-link">Ingoing</a></li>
                    <li class="sidebar-item"><a href=" route ('admin.tables.outgoing') " class="sidebar-link">Outgoing</a></li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false">
                    <i class="fa-regular fa-user pe-2 bi bi-graph-up"></i> REPORTS
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a href=" route ('inventorylevels') " class="sidebar-link">Inventory Level</a></li>
                    <li class="sidebar-item"><a href=" route ('batchtracking') " class="sidebar-link">Batch Tracking</a></li>
                    <li class="sidebar-item"><a href=" route ('expirytracking') " class="sidebar-link">Expiry Tracking</a></li>
                </ul>
            </li>
        </ul>
    </div>
</aside>