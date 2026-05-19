/**
 * course.js
 * Course-specific logic: Form handling (Save/Update) and Table management (Fetching/Search).
 */

$(document).ready(function () {
    // Lightweight non-blocking toast for notifications (replaces alert())
    window.showToast = function (message, type = "success") {
        const colors = {
            success: "#4f46e5",
            error: "#ef4444",
            info: "#374151",
        };

        const toast = $(
            `<div class="nvda-toast" role="status" aria-live="polite" style="display:none; position:fixed; right:20px; top:20px; z-index:99999; min-width:200px; max-width:360px; padding:12px 16px; color:#fff; border-radius:8px; box-shadow:0 6px 18px rgba(15,23,42,0.2); font-weight:600;"></div>`,
        );

        toast.css("background", colors[type] || colors.info);
        toast.text(message);
        $("body").append(toast);
        toast
            .fadeIn(150)
            .delay(2500)
            .fadeOut(300, function () {
                $(this).remove();
            });
    };
    // 1. Initialize the broadcast channel for cross-tab communication
    const courseChannel = new BroadcastChannel("course_sync");

    // 2. Listen for refresh signals from other tabs
    courseChannel.onmessage = (event) => {
        if (event.data === "refresh_course_list") {
            // If the user is on the courses index page, refresh the list via AJAX
            if (
                $("#courseIndexSection").length &&
                typeof fetchCourses === "function"
            ) {
                fetchCourses($("#courseIndexSection").data("url"), {
                    quiet: true,
                });
            }
        }
    };

    // 3. Course List AJAX Fetching
    window.fetchCourses = (url, options = {}) => {
        const tableBody = $("#courseTableBody");
        const quiet = options.quiet || false;

        if (!tableBody.length) return;
        if (!quiet) tableBody.css("opacity", "0.5");

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            cache: false,
            success: function (response) {
                const courses = response.courses.data;
                let html = "";

                if (courses.length > 0) {
                    courses.forEach((course) => {
                        const showUrl = `/courses/${course.id}`;
                        const editUrl = `/courses/${course.id}/edit`;
                        const destroyUrl = `/courses/${course.id}`;
                        const degreeName = course.degree
                            ? course.degree.name
                            : "N/A";

                        html += `
                            <tr>
                                <td>#${course.id}</td>
                                <td style="font-weight: 600;">${course.name}</td>
                                <td>${course.description}</td>
                                <td><span class="badge badge-secondary">${degreeName}</span></td>
                                <td>
                                    <div class="action-group">
                                        <a href="${showUrl}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">View</a>
                                        <a href="${editUrl}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">Edit</a>
                                        <button type="button" class="btn btn-delete-course" data-url="${destroyUrl}" style="padding: 0.45rem 0.85rem; background: #ef4444; color: white;">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html =
                        '<tr><td colspan="5" class="empty-state">No courses found.</td></tr>';
                }

                tableBody.html(html).css("opacity", "1");
                $("#totalCoursesBadge").text(
                    `Total Courses: ${response.total}`,
                );
            },
            error: function () {
                tableBody.css("opacity", "1");
                if (!quiet) showToast("Failed to fetch course data.", "error");
            },
        });
    };

    // Pagination & Search for Courses
    $(document).on("click", "#coursePagination a", function (e) {
        e.preventDefault();
        fetchCourses($(this).attr("href"));
    });

    if ($("#courseSearch").length) {
        $("#courseSearch").on("keyup", function () {
            const query = $(this).val();
            const baseUrl = $("#courseIndexSection").data("url");
            fetchCourses(`${baseUrl}?search=${query}`);
        });
    }

    if ($("#courseIndexSection").length) {
        fetchCourses($("#courseIndexSection").data("url"));
    }

    // 4. Form Actions (Save/Update)
    $("#save_courses").click(function (event) {
        event.preventDefault();

        var name = $("#name").val();
        var description = $("#description").val();
        var degree_id = $("#degree_id").val();
        var teacher_id = $("#teacher_id").val();

        $.ajax({
            url: "/courses",
            method: "POST",
            data: {
                name: name,
                description: description,
                degree_id: degree_id,
                teacher_id: teacher_id,
            },
            success: function (response) {
                if (response.success) {
                    courseChannel.postMessage("refresh_course_list");
                    showToast(response.message, "success");
                    window.location.href = response.redirect;
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var firstError = Object.values(errors)[0][0];
                    showToast(firstError, "error");
                } else {
                    showToast(
                        "Something went wrong. Please try again.",
                        "error",
                    );
                }
            },
        });
    });

    $("#update_courses").click(function (event) {
        event.preventDefault();

        var id = $(this).data("id");
        var name = $("#name").val();
        var description = $("#description").val();
        var degree_id = $("#degree_id").val();
        var teacher_id = $("#teacher_id").val();

        $.ajax({
            url: "/courses/" + id,
            method: "POST",
            data: {
                _method: "PUT",
                name: name,
                description: description,
                degree_id: degree_id,
                teacher_id: teacher_id,
            },
            success: function (response) {
                if (response.success) {
                    courseChannel.postMessage("refresh_course_list");
                    showToast(response.message, "success");
                    window.location.href = response.redirect;
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var firstError = Object.values(errors)[0][0];
                    showToast(firstError, "error");
                } else {
                    showToast(
                        "Something went wrong. Please try again.",
                        "error",
                    );
                }
            },
        });
    });

    // Initialize Delete
    if (typeof handleAjaxDelete === "function") {
        handleAjaxDelete(
            ".btn-delete-course",
            "Are you sure you want to delete this course?",
        );
    }
});
