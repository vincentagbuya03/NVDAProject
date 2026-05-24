$(document).ready(function () {
    // Generic Container AJAX Handler (No Form Tag)
    // Using event delegation so it works even for content loaded in modals
    $(document).on("click", '[id^="btnCreate"], [id^="btnEdit"]', function () {
        const button = $(this);
        const buttonId = "#" + button.attr("id");
        const container = button.closest('[id$="Container"]');

        if (!container.length) return;

        const fields = container.find("input, select, textarea").filter(function () {
            return !this.disabled && this.type !== "hidden" && this.type !== "button";
        });

        let firstInvalidField = null;
        fields.each(function () {
            if (typeof this.checkValidity === "function" && !this.checkValidity()) {
                firstInvalidField = firstInvalidField || this;
                return false;
            }
        });

        if (firstInvalidField) {
            if (typeof firstInvalidField.reportValidity === "function") {
                firstInvalidField.reportValidity();
            }
            firstInvalidField.focus();
            return;
        }

        const url = container.data("url");
        const method = container.data("method") || "POST";
        const buttonText = button.text();

        // Reset errors
        $(".field-error").remove();
        $(".alert-error").remove();

        button.prop("disabled", true).text("Processing...");

        const hasFileInput = container.find('input[type="file"]').length > 0;
        const ajaxOptions = {
            url: url,
            type: "POST",
        };

        if (hasFileInput) {
            const formData = new FormData();

            container.find(":input[name]").each(function () {
                const el = this;
                const $el = $(this);
                const name = $el.attr("name");

                if (!name) return;

                if (el.type === "file") {
                    if (el.files && el.files.length > 0) {
                        formData.append(name, el.files[0]);
                    }
                    return;
                }

                if (el.type === "checkbox") {
                    if (el.checked) formData.append(name, $el.val());
                    return;
                }

                if (el.type === "radio") {
                    if (el.checked) formData.append(name, $el.val());
                    return;
                }

                formData.append(name, $el.val());
            });

            if (["PUT", "PATCH", "DELETE"].includes(method.toUpperCase())) {
                formData.append("_method", method.toUpperCase());
            }

            ajaxOptions.data = formData;
            ajaxOptions.processData = false;
            ajaxOptions.contentType = false;
        } else {
            let data = container.find(":input").serialize();
            if (["PUT", "PATCH", "DELETE"].includes(method.toUpperCase())) {
                data += `&_method=${method.toUpperCase()}`;
            }
            ajaxOptions.data = data;
        }

        $.ajax({
            ...ajaxOptions,
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

            const hasFileInput = form.find('input[type="file"]').length > 0;
            const ajaxOptions = {
                url: url,
                type: "POST",
            };

            if (hasFileInput) {
                const formData = new FormData(form[0]);
                ajaxOptions.data = formData;
                ajaxOptions.processData = false;
                ajaxOptions.contentType = false;
            } else {
                ajaxOptions.data = form.serialize();
            }

            $.ajax({
                ...ajaxOptions,
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
