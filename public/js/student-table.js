/**
 * student-table.js
 * Student-specific table logic (Fetching, Search, Pagination).
 */

$(document).ready(function () {
    window.fetchStudents = (url) => {
        const tableBody = $("#studentTableBody");
        if (!tableBody.length) return;

        tableBody.css("opacity", "0.5");

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            cache: false,
            success: function (response) {
                const students = response.students.data;
                let html = "";

                if (students.length > 0) {
                    students.forEach((student, index) => {
                        const showUrl = `/students/${student.id}`;
                        const editUrl = `/students/${student.id}/edit`;
                        const destroyUrl = `/students/${student.id}`;
                        const degreeName = student.degree ? student.degree.name : "N/A";
                        const email = student.user ? student.user.email : "N/A";

                        const birthYear = new Date(student.birthdate).getFullYear();
                        const currentYear = new Date().getFullYear();
                        const age = currentYear - birthYear;

                        let statusBadge = "";
                        if (age === 19) statusBadge = '<span class="badge" style="background: #dbeafe; color: #1d4ed8;">Freshman</span>';
                        else if (age === 20) statusBadge = '<span class="badge" style="background: #dcfce7; color: #15803d;">Sophomore</span>';
                        else if (age === 21) statusBadge = '<span class="badge" style="background: #fef3c7; color: #b45309;">Junior</span>';
                        else if (age === 22) statusBadge = '<span class="badge" style="background: #fee2e2; color: #b91c1c;">Senior</span>';
                        else statusBadge = '<span class="badge" style="background: #f1f5f9; color: #475569;">Irregular</span>';

                        const dateObj = new Date(student.birthdate);
                        const formattedDate = dateObj.toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" });

                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td style="font-weight: 600;">${student.fname} ${student.mname || ""} ${student.lname}</td>
                                <td>${email}</td>
                                <td>${formattedDate}</td>
                                <td>${student.gender}</td>
                                <td>${student.contact_no}</td>
                                <td>${degreeName}</td>
                                <td>${statusBadge}</td>
                                <td>
                                    <div class="action-group">
                                        <a href="${showUrl}" class="btn btn-secondary" style="padding: 0.45rem 0.85rem;">View</a>
                                        <button type="button" class="btn btn-secondary btn-edit-student" data-url="${editUrl}" style="padding: 0.45rem 0.85rem;">Edit</button>
                                        <button type="button" class="btn btn-delete-student" data-url="${destroyUrl}" style="padding: 0.45rem 0.85rem; background: #ef4444; color: white;">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = '<tr><td colspan="9" class="empty-state">No students found.</td></tr>';
                }

                tableBody.html(html).css("opacity", "1");
                $("#totalStudentsBadge").text(`Total Students: ${response.total}`);
                $("#boysBadge").text(`Boys: ${response.maleCount}`);
                $("#girlsBadge").text(`Girls: ${response.femaleCount}`);
            },
            error: function () {
                tableBody.css("opacity", "1");
                alert("Failed to fetch student data.");
            },
        });
    };

    // Pagination
    $(document).on("click", "#studentPagination a", function (e) {
        e.preventDefault();
        fetchStudents($(this).attr("href"));
    });

    // Search
    if ($("#studentSearch").length) {
        $("#studentSearch").on("keyup", function () {
            const query = $(this).val();
            const baseUrl = $("#studentIndexSection").data("url");
            fetchStudents(`${baseUrl}?search=${query}`);
        });
    }

    // Initialization
    if ($("#studentIndexSection").length) {
        fetchStudents($("#studentIndexSection").data("url"));
    }

    // Initialize Delete
    if (typeof handleAjaxDelete === "function") {
        handleAjaxDelete(".btn-delete-student", "Are you sure you want to delete this student and their user account?");
    }
});
