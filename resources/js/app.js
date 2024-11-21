import jQuery from "jquery";
window.$ = jQuery;
window.jQuery = jQuery;

import "bootstrap"; // Ensure Bootstrap JS is also included
import "datatables.net-bs5"; // DataTables Bootstrap 5 integration
import "chart.js"; // Import Chart.js

// Initialize DataTables after DOM is ready
$(document).ready(function () {
    $('#auditTrailTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true,
        autoWidth: false,
        order: [[0, 'desc']], // Order by Timestamp descending
        columnDefs: [
            { targets: '_all', defaultContent: '-' } // Fills missing content with '-'
        ]
    });

    $('#auditTrailTableManager').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true,
        autoWidth: false,
        order: [[0, 'desc']], // Order by Timestamp descending
        columnDefs: [
            { targets: '_all', defaultContent: '-' } // Fills missing content with '-'
        ]
    });

    $("#buyerTable").DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true,
        autoWidth: false,
        order: [[0, "desc"]], // Order by ID descending
        columnDefs: [
            { targets: '_all', defaultContent: '-' } // Fills missing content with '-'
        ]
    });
});

