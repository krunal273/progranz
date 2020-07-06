$(document).ready(function () {
    $(document).on("click", ".modal-login, .modal-signup", function () {

        var active = "";
        if ($(this).hasClass("modal-login")) {
            active = "login";
        } else if ($(this).hasClass("modal-signup")) {
            active = "signup";
        }

        if ($("#login_modal").length === 0) {
            $.ajax({
                url: "../classes/user.php",
                beforeSend: function () {
                    $("#processing").css("display", "block");
                },
                data: {
                    get_form_login: ""
                },
                type: "POST",
                success: function (response) {
                    $("#processing").css("display", "none");
                    var json_ob = parseJSON(response);
                    if (json_ob !== false) {
                        json_ob.active_tab = active;
                        json_ob.modal_class = "login_modal";
                        json_ob.operation = "login";
                        showTabs(json_ob, "primary");
                    }
                },
                error: function (response) {
                    $("#processing").css("display", "none");
                    showAJAXError(response);
                }
            });
        } else {
            setActiveTab($("#login_modal"), active);
            $("#login_modal").modal('toggle');
        }

    });
});

function checkLogin(form) {
    var is_valid = validateForm(form);

    if (is_valid) {
        var email = form.find("#col1").val();
        var pass = form.find("#col2").val();

        $.ajax({
            url: "../classes/user.php",
            beforeSend: function () {
                processing(true);
            },
            data: {
                login: '',
                uname: email,
                upass: pass
            },
            type: "POST",
            success: function (response) {
                var json_ob = parseJSON(response);
                if (json_ob !== false) {
                    if (json_ob.type === "success") {
                        window.location = json_ob.redirect;
                    } else if (json_ob.type === "danger") {
                        enableSubmitButton(form, true);
                        showAlert(json_ob);
                    }
                } else {
                    enableSubmitButton(form, true);
                }
            },
            error: function (response) {
                showAJAXError(response);
            }
        });
    }
}

function checkRegister(form) {
    var is_valid = validateForm(form);

    if (is_valid) {
        var name = form.find("#col1").val();
        var email = form.find("#col2").val();
        var password = form.find("#col3").val();
        var confirm_password = form.find("#col4").val();
        if (password !== confirm_password) {
            showValidation($("#col4"), "danger", "Passwords do not match");
        } else {
            $.ajax({
                url: "../classes/user.php",
                beforeSend: function () {
                    processing(true);
                },
                data: {
                    signup: '',
                    uname: name,
                    uemail: email,
                    upass: password,
                },
                type: "POST",
                success: function (response) {
                    var json_ob = parseJSON(response);
                    if (json_ob !== false) {
                        if (json_ob.type === "success") {
                            showAlert(json_ob);
                            form.closest(".modal").modal("hide");
                        } else if (json_ob.type === "danger") {
                            enableSubmitButton(form, true);
                            showAlert(json_ob);
                        }
                    } else {
                        enableSubmitButton(form, true);
                    }
                },
                error: function (response) {
                    showAJAXError(response);
                }
            });
        }
    }
}