/**
 * maintenance-table.js
 * Logic for Degrees, Users, and Posts tables (mostly client-side search).
 */

$(document).ready(function () {
    if (typeof handleTableSearch === "function") {
        // Degree Search
        if ($("#degreeSearch").length) {
            handleTableSearch("#degreeSearch", "tbody", "No degrees match your search.", 5);
        }

        // User Search
        if ($("#userSearch").length) {
            handleTableSearch("#userSearch", "tbody", "No users match your search.", 4);
        }

        // Post Search
        if ($("#postSearch").length) {
            handleTableSearch("#postSearch", "tbody", "No posts match your search.", 5);
        }
    }

    if (typeof handleAjaxDelete === "function") {
        handleAjaxDelete(".btn-delete-degree", "Are you sure you want to delete this degree?");
        handleAjaxDelete(".btn-delete-user", "Are you sure you want to delete this user?");
        handleAjaxDelete(".btn-delete-post", "Are you sure you want to delete this post?");
    }
});
