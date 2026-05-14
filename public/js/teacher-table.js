/**
 * teacher-table.js
 * Teacher-specific table logic (Fetching, Search, Pagination).
 */

$(document).ready(function () {
    const getTeacherFetchUrl = () => {
        const baseUrl = $("#teacherIndexSection").data("url");
        const query = $("#teacherSearch").val() || "";
        return query ? `${baseUrl}?search=${encodeURIComponent(query)}` : baseUrl;
    };

    window.fetchTeachers = (url, options = {}) => {
        const tableBody = $("#teacherTableBody");
        const quiet = options.quiet || false;

        if (!tableBody.length) return;
        if (!quiet) tableBody.css("opacity", "0.5");

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            cache: false,
            success: function (response) {
                const teachers = response.teachers.data;
                let html = "";

                if (teachers.length > 0) {
                    teachers.forEach((teacher) => {
                        const showUrl = `/teacher/${teacher.id}`;
                        const editUrl = `/teacher/${teacher.id}/edit`;
                        const destroyUrl = `/teacher/${teacher.id}`;
                        const degreeName = teacher.degree ? teacher.degree.name : "No Degree";
                        const username = teacher.user ? teacher.user.username : "N/A";

                        html += `
                            <tr>
                                <td>#${teacher.id}</td>
                                <td style="font-weight: 600;">${teacher.fname} ${teacher.lname}</td>
                                <td>${teacher.email}</td>
                                <td><span class="badge badge-secondary">${degreeName}</span></td>
                                <td><code>${username}</code></td>
                                <td>
                                    <div class="action-group">
                                        <a href="${showUrl}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">View</a>
                                        <button type="button" class="btn btn-secondary btn-edit-teacher" data-url="${editUrl}" style="padding: 0.45rem 0.85rem;">Edit</button>
                                        <button type="button" class="btn btn-delete-teacher" data-url="${destroyUrl}" style="padding: 0.45rem 0.85rem; background: #ef4444; color: white;">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = '<tr><td colspan="6" class="empty-state">No teachers found.</td></tr>';
                }

                tableBody.html(html).css("opacity", "1");
                $("#totalTeachersBadge").text(`Total Teachers: ${response.total}`);
            },
            error: function () {
                tableBody.css("opacity", "1");
                if (!quiet) alert("Failed to fetch data.");
            },
        });
    };

    // Pagination
    $(document).on("click", "#teacherPagination a", function (e) {
        e.preventDefault();
        fetchTeachers($(this).attr("href"));
    });

    // Search
    if ($("#teacherSearch").length) {
        $("#teacherSearch").on("keyup", function () {
            fetchTeachers(getTeacherFetchUrl());
        });
    }

    // Auto-fetch initialization
    if ($("#teacherIndexSection").length) {
        fetchTeachers(getTeacherFetchUrl());

        setInterval(function () {
            if (!document.hidden) fetchTeachers(getTeacherFetchUrl(), { quiet: true });
        }, 15000);

        $(window).on("focus", function () {
            fetchTeachers(getTeacherFetchUrl(), { quiet: true });
        });
    }

    // Initialize Delete
    if (typeof handleAjaxDelete === "function") {
        handleAjaxDelete(".btn-delete-teacher", "Are you sure you want to delete this teacher and their user account?");
    }
});
