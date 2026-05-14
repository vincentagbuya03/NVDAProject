$(document).ready(function () {
    // Generic Container AJAX Handler (No Form Tag)
    // Using event delegation so it works even for content loaded in modals
    $(document).on("click", '[id^="btnCreate"], [id^="btnEdit"]', function () {
        const button = $(this);
        const buttonId = "#" + button.attr("id");
        const container = button.closest('[id$="Container"]');

        if (!container.length) return;

        const url = container.data("url");
        const method = container.data("method") || "POST";
        const buttonText = button.text();

        // Reset errors
        $(".field-error").remove();
        $(".alert-error").remove();

        button.prop("disabled", true).text("Processing...");

        let data = container.find(":input").serialize();

        if (["PUT", "PATCH", "DELETE"].includes(method.toUpperCase())) {
            data += `&_method=${method.toUpperCase()}`;
        }

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function (response) {
                if (response.success) {
                    const teacherSection = $("#teacherIndexSection");
                    const studentSection = $("#studentIndexSection");

                    if (
                        teacherSection.length &&
                        typeof window.fetchTeachers === "function"
                    ) {
                        $("#globalModal").fadeOut(200);
                        window.fetchTeachers(teacherSection.data("url"));
                    } else if (
                        studentSection.length &&
                        typeof window.fetchStudents === "function"
                    ) {
                        $("#globalModal").fadeOut(200);
                        window.fetchStudents(studentSection.data("url"));
                    } else {
                        window.location.href = response.redirect;
                    }
                }
            },
            error: function (xhr) {
                button.prop("disabled", false).text(buttonText);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach((key) => {
                        const input = container.find(`[name="${key}"]`);
                        const errorMessage = errors[key][0];

                        if (input.length) {
                            input.after(
                                `<p class="field-error">${errorMessage}</p>`,
                            );
                        }
                    });

                    if ($(".field-error").length) {
                        const firstError = $(".field-error").first();
                        const scrollContainer = button.closest(
                            ".login-modal-card",
                        ).length
                            ? button.closest(".login-modal-card")
                            : $("html, body");

                        if (button.closest(".login-modal-card").length) {
                            scrollContainer.animate(
                                {
                                    scrollTop: firstError.position().top - 20,
                                },
                                500,
                            );
                        } else {
                            $("html, body").animate(
                                {
                                    scrollTop: firstError.offset().top - 100,
                                },
                                500,
                            );
                        }
                    }
                } else {
                    alert("An unexpected error occurred. Please try again.");
                }
            },
        });
    });

    const handleAjaxForm = (formId, buttonText) => {
        $(document).on("submit", formId, function (e) {
            e.preventDefault();

            const form = $(this);
            const button = form.find('button[type="submit"]');
            const url = form.attr("action");

            // Reset errors
            $(".field-error").remove();
            $(".alert-error").remove();

            button.prop("disabled", true).text("Processing...");

            $.ajax({
                url: url,
                type: "POST",
                data: form.serialize(),
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.redirect;
                    }
                },
                error: function (xhr) {
                    button.prop("disabled", false).text(buttonText);

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach((key) => {
                            const input = form.find(`[name="${key}"]`);
                            const errorMessage = errors[key][0];

                            if (input.length) {
                                input.after(
                                    `<p class="field-error">${errorMessage}</p>`,
                                );
                            }
                        });

                        if ($(".field-error").length) {
                            $("html, body").animate(
                                {
                                    scrollTop:
                                        $(".field-error").first().offset().top -
                                        100,
                                },
                                500,
                            );
                        }
                    } else {
                        alert(
                            "An unexpected error occurred. Please try again.",
                        );
                    }
                },
            });
        });
    };

    // Initialize traditional form handlers if they exist
    if ($("#teacherCreateForm").length)
        handleAjaxForm("#teacherCreateForm", "Create Teacher Account");
    if ($("#studentCreateForm").length)
        handleAjaxForm("#studentCreateForm", "Add Student");
});
