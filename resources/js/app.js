import jQuery from "jquery";
window.$ = jQuery;
window.jQuery = jQuery;

import "bootstrap"; // Ensure Bootstrap JS is also included
import "datatables.net-bs5"; // DataTables Bootstrap 5 integration
import "chart.js"; // Import Chart.js

// Initialize DataTables after DOM is ready
$(document).ready(function () {
    $("#auditTrailTable").DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true,
        autoWidth: false,
        order: [[0, "desc"]], // Order by ID descending
    });

    $("#buyerTable").DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true,
        autoWidth: false,
        order: [[0, "desc"]], // Order by ID descending
    });
});

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

// Listen to the NewOrderPlaced event for this seller
window.Echo.private("orders." + shopId).listen("NewOrderPlaced", (event) => {
    const order = event.order;

    // You can append the new order to the order table
    const orderRow = `
            <tr>
                <td>${order.order_reference}</td>
                <td>${order.customer_name}</td>
                <td>${order.created_at}</td>
                <td>${order.payment_status}</td>
                <td>${order.payment_type}</td>
                <!-- Add other columns as necessary -->
            </tr>
        `;

    document
        .querySelector(".order-table tbody")
        .insertAdjacentHTML("beforeend", orderRow);
});
