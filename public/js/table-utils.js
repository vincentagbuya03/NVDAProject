/**
 * table-utils.js
 * Generic utilities for table searching, AJAX deletion, and global modals.
 */

$(document).ready(function () {
    // 1. Generic Table Search Handler (Client-side filtering)
    window.handleTableSearch = (inputId, tableBodySelector, emptyMsg, colSpan) => {
        $(inputId).on("keyup", function () {
            const value = $(this).val().toLowerCase();
            $(tableBodySelector + " tr").filter(function () {
                const text = $(this).text().toLowerCase();
                $(this).toggle(text.indexOf(value) > -1);
            });

            // Show empty state if no results
            if ($(tableBodySelector + " tr:visible").length === 0) {
                if ($(".no-results-msg").length === 0) {
                    $(tableBodySelector).append(
                        `<tr class="no-results-msg"><td colspan="${colSpan}" class="empty-state">${emptyMsg}</td></tr>`
                    );
                }
            } else {
                $(".no-results-msg").remove();
            }
        });
    };

    // 2. Generic AJAX Delete Handler
    window.handleAjaxDelete = (buttonSelector, confirmMsg) => {
        $(document).on("click", buttonSelector, function (e) {
            e.preventDefault();

            const button = $(this);
            const url = button.data("url") || button.closest("form").attr("action");
            const row = button.closest("tr");

            if (confirm(confirmMsg)) {
                button.prop("disabled", true).text("Deleting...");

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        _method: "DELETE",
                    },
                    success: function (response) {
                        row.fadeOut(400, function () {
                            $(this).remove();

                            // Notify other tabs if it's a course (or broadcast generally)
                            const courseChannel = new BroadcastChannel('course_sync');
                            courseChannel.postMessage('refresh_course_list');

                            // Update total count badge if it exists
                            const badge = $(".badge-primary").first();
                            const currentText = badge.text();
                            const match = currentText.match(/\d+/);
                            if (match) {
                                const newCount = parseInt(match[0]) - 1;
                                badge.text(currentText.replace(/\d+/, newCount));
                            }
                        });
                    },
                    error: function (xhr) {
                        alert("Error deleting item. Please try again.");
                        button.prop("disabled", false).text("Delete");
                    },
                });
            }
        });
    };

    // 3. Global Modal Handler (for Teacher/Student forms)
    $(document).on(
        "click",
        "#btnOpenCreateTeacher, .btn-edit-teacher, #btnOpenCreateStudent, .btn-edit-student",
        function () {
            const url = $(this).data("url");
            const modal = $("#globalModal");
            const content = $("#modalContent");

            content.html('<div class="empty-state">Loading form...</div>');
            modal.fadeIn(200);

            $.get(url, function (html) {
                const formHtml = $(html).find(".form-card").html();
                content.html(formHtml);
            });
        }
    );
});
