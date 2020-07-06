//$(document).ready(function () {
//    $(document).on("click", ".password_operation", function () {
//        var modal_button = $(this), checkbox_id;
//        $.ajax({
//            url: "../classes/user.php",
//            beforeSend: function () {
//                processing(true);
//            },
//            data: {
//                get_form_password: ''
//            },
//            type: "POST",
//            success: function (response) {
//                var json_ob = parseJSON(response);
//                if (json_ob !== false) {
//                    modal_button.closest("tr").find(":checkbox").prop("checked", true);
//                    json_ob.checkbox_id = modal_button.closest("tr").find(":checkbox").attr("id");
//                    showModal(json_ob);
//                    processing(false);
//                }
//            },
//            error: function (response) {
//                showAJAXError(response);
//            }
//        });
//    });
//});
//
//function changePassword(form) {
//    var is_valid = validateForm(form);
//    if (is_valid) {
//        var password = form.find("#col1").val();
//        var confirm_password = form.find("#col2").val();
//        form = $("#table_form");
//        if (password !== confirm_password) {
//            showValidation($("#col2"), "error", "Passwords does not match");
//            return;
//        } else {
//            $.ajax({
//                url: "../classes/user.php",
//                beforeSend: function () {
//                    processing(true);
//                },
//                data: form.serialize() + "&password=" + password + "&change_password",
//                type: "POST",
//                success: function (response) {
//                    var json_ob = parseJSON(response);
//                    if (json_ob !== false) {
//                        if (json_ob.type === "success" || json_ob.type === "danger") {
//                            enableSubmitButton(form, true);
//                            showAlert(json_ob);
//                            destroyModal($(".modal.in"));
//                            $("#table_form :checkbox:checked").prop("checked", false);
//                            $(".categories_btn_group .multiple").addClass("no_print");
//                        }
//                    } else {
//                        enableSubmitButton(form, true);
//                    }
//                },
//                error: function (response) {
//                    showAJAXError(response);
//                }
//            });
//        }
//    }
//}
//
function getExtraInfo(extra, value) {
    if (extra.email_verified) {
        value += " <i class='fa fa-check-circle text-success' title='email verified' data-toggle='tooltip'></i>";
    }
    return value;
}