/* global current_page */

var current_page = $(location).attr('href').split("?")[0];
current_page = current_page.split("/");
current_page = current_page[current_page.length - 1];
current_page = current_page.replace("#", "");

function checkMultipleOperation() {
    var checked;
    $(".categories [data-operation]:not([data-always_show])").each(function (index, value) {
        checked = $("#table_form").find("." + $(this).data("operation") + ":not([data-always_show])").closest("tr").find(":checkbox:checked").length;
        if (checked > 1) {
            $(".categories_btn_group ." + $(this).data("operation")).removeClass("hidden", false);
        } else {
            $(".categories_btn_group ." + $(this).data("operation")).addClass("hidden", true);
        }
    });

    setButtonGroupRadius();
}

function checkTopBottom() {
    if ($(this).scrollTop() > 4) {
        $('.back_to_top').removeClass("hidden");
    } else {
        $('.back_to_top').addClass("hidden");
    }
    var window_height = $(window).height();
    var scroll = $(window).scrollTop();
    var container_height = $("#main_container").height() + 50;
    if (container_height > window_height && (scroll + window_height) !== container_height) {
        $('.back_to_bottom').removeClass("hidden");
    } else {
        $('.back_to_bottom').addClass("hidden");
    }
    if ($(".back_to_top:visible").length === 0) {
        $('.back_to_bottom').css("bottom", "40px");
    } else if ($(".back_to_bottom:visible").length === 0) {
        $('.back_to_top').css("bottom", "40px");
    } else {
        $('.back_to_bottom').css("bottom", "40px");
        $('.back_to_top').css("bottom", "75px");
    }
}

function capitalizeFirstLetter(string) {
    if (string !== null)
        return string.charAt(0).toUpperCase() + string.slice(1);
    else
        return "null";
}

function logout() {
    $.ajax({
        url: "../includes/functions.php",
        beforeSend: function () {
            processing(true);
            enableSubmitButton($(".yes_logout"), false);
        },
        data: "operation=logout",
        type: "POST",
        success: function (response) {
            var json_ob = parseJSON(response);
            if (json_ob !== false) {
                if (json_ob.type === "success") {
                    window.location.href = "../public/index.php";
                } else {
                    enableSubmitButton($(".yes_logout"), true);
                    showAlert(json_ob);
                }
            }
        },
        error: function (response) {
            showAJAXError(response);
        }
    });
}

function fixedTableHead() {
    if ($("#table_form").length === 1) {
        var first_row = $("#table_form .table-responsive:first tbody tr:first");
        var head_clone = $("#table_form thead").clone();
        $.each(head_clone.find("th"), function (key, value) {
            var width = first_row.find("td").eq(key).outerWidth(true);
            $(value).css("width", width + "px");
        });
        var head = head_clone.html();

        var fixed_table_head = "<div class='table-responsive' id='fixed_table_head'>";
        fixed_table_head += "<table class='table table-bordered'>";
        fixed_table_head += "<thead>";
        fixed_table_head += head;
        fixed_table_head += "</thead>";
        fixed_table_head += "</table>";
        fixed_table_head += "</div>";

        if ($("#fixed_table_head").length === 0) {
            $("#table_form").before(fixed_table_head);
        } else {
            $("#fixed_table_head").replaceWith(fixed_table_head);
        }
    }
}

function focusFirstElement() {
    var ele = $(".modal.in");
    if (ele.length === 0) {
        ele = $(document);
    }

    var first = ele.find("input:not(:disabled):visible:first");
    if (!(first.attr("id") === "search" && mobileAndTabletcheck())) {
        first.attr("autofocus", "");
    }
    first = ele.find("[autofocus]:not(:disabled):visible:first");
    if (!(first.attr("id") === "search" && mobileAndTabletcheck())) {
        first.focus();
    }
}

function parseJSON(response) {
    processing(false);
    try {
        return JSON.parse(response);
    } catch (e) {
        console.log("JSON parse Error : " + response);
        return false;
    }
}

function openNavbar() {
    if ($(document).width() > "768") {
        $('.dropdown').hover(function () {
            $(this).addClass('open');
        }, function () {
            $(this).removeClass('open');
        });
    }
}

function makeMenuActive() {
    $(".navbar-nav .active").closest(".dropdown").addClass("active");
}

function processing(state) {
    if (state) {
        $("#processing").css("display", "block");
    } else {
        $("#processing").css("display", "none");
    }
}

function showAJAXError(response) {
    var json_ob = {
        type: 'danger',
        message: 'AJAX Error'
    };
    console.log(response);
    showAlert(json_ob);
}

function sendMail(json_ob) {
    $.ajax({
        url: "../includes/mail.php",
        beforeSend: function () {
            processing(true);
        },
        data: {
            mail: "",
            to: json_ob.to,
            operation: "json_ob.operation"
        },
        type: "POST",
        success: function (response) {
            var json_ob = parseJSON(response);
            if (json_ob !== false) {
                if (json_ob.type === "success") {
                    showAlert(json_ob);
                } else if (json_ob.type === "danger") {
                    showAlert(json_ob);
                }
            }
        },
        error: function (response) {
            showAJAXError(response);
        }
    });
}

function changePassword(form) {
    var is_valid = validateForm(form);
    if (is_valid) {
        var password = form.find("#col1").val();
        var confirm_password = form.find("#col2").val();
        form = $("#table_form");
        if (password !== confirm_password) {
            showValidation($("#col2"), "error", "Passwords does not match");
            return;
        } else {
            $.ajax({
                url: "../classes/user.php",
                beforeSend: function () {
                    processing(true);
                },
                data: form.serialize() + "&password=" + password + "&change_password",
                type: "POST",
                success: function (response) {
                    var json_ob = parseJSON(response);
                    if (json_ob !== false) {
                        if (json_ob.type === "success" || json_ob.type === "danger") {
                            enableSubmitButton(form, true);
                            showAlert(json_ob);
                            destroyModal($(".modal.in"));
                            $("#table_form :checkbox:checked").prop("checked", false);
                            $(".categories_btn_group .multiple").addClass("hidden");
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

function editProfile(form) {
    var is_valid = validateForm(form);
    if (is_valid) {
        $.ajax({
            url: "../classes/user.php",
            beforeSend: function () {
                processing(true);
                enableSubmitButton(form.closest(".modal").find("button[type=submit]"), false);
            },
            data: form.serialize() + "&edit_profile",
            type: "POST",
            success: function (response) {
                var json_ob = parseJSON(response);
                if (json_ob !== false) {
                    if (json_ob.type === "success" || json_ob.type === "danger") {
                        enableSubmitButton(form, true);
                        showAlert(json_ob);
                        destroyModal($(".modal.in"));
                        $(".profile_operation").html("<i class='fa fa-user'></i> " + form.find("#col1").val());
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

function validateFilter(form) {
    var filtername = form.attr("id").replace("_form", "");
    var total_checked = form.closest(".modal").find(":checkbox:not([data-select_all]):checked").length;
    var field = form.closest(".modal").find("[data-apply]").data("apply");
    var submit_button = $("[data-apply]");
    if (total_checked === 0) {
        var json_ob = {
            type: "danger",
            message: "please select al least one value"
        };
        showAlert(json_ob);
    } else {
        $.ajax({
            url: "../classes/" + current_page,
            beforeSend: function () {
                processing(true);
                enableSubmitButton(submit_button, false);
            },
            data: form.serialize() + "&filter=" + filtername + "&field=" + field + "&operation=set_filter",
            type: "POST",
            success: function (response) {
                var json_ob = parseJSON(response);
                if (json_ob !== false) {
                    displayGUI(json_ob);
                    destroyModal(form.closest(".modal"));
                }
            },
            error: function (response) {
                showAJAXError(response);
            }
        });
    }
}

function removeFilter(filter) {
    var field = "";
    if (!!filter.data("field") !== false) {
        field = filter.data("field");
    }

    $.ajax({
        url: "../classes/" + current_page,
        beforeSend: function () {
            processing(true);
        },
        data: {
            operation: "remove_filter",
            filter: filter.data("remove_filter"),
            field: field
        },
        type: "POST",
        success: function (response) {
            var json_ob = parseJSON(response);
            if (json_ob !== false) {
                displayGUI(json_ob);
            }
        },
        error: function (response) {
            showAJAXError(response);
        }
    });
}

function toggleOperations(display, hide) {
    if (hide !== "") {
        $(".categories").css("display", hide);
    }
    $(".operations").css("display", display);
    $(".custom_checkbox").css("display", display);
    if (display === "none") {
        $("#table_form :checkbox:checked").click();
        $("#operations").removeClass('btn-harddelete').addClass('btn-default');
    } else {
        $("#operations").removeClass('btn-default').addClass('btn-harddelete');
    }
    setButtonGroupRadius();
    $.ajax({
        url: "../classes/" + current_page,
        beforeSend: function () {
        },
        data: {
            operation: "display",
            display: display,
            hide: hide
        },
        type: "GET",
        success: function (response) {
            parseJSON(response);
        },
        error: function (response) {
            showAJAXError(response);
        }
    });
}

function focusCheckbox(modal) {
    var checkbox_id = modal.find("#operation_id").val();
    if (!!checkbox_id !== false) {
        $("#" + checkbox_id).prop("checked", false);
        $("#" + checkbox_id).focus();
    }
}

function createImageModal() {

    var image_operations =
            "<button type='button' class='rotate btn btn-primary' data-toggle='tooltip' data-container='body' title='rotate'><i class='fa fa-rotate-right'></i></button>" +
            "<button type='button' class='flipX btn btn-primary' data-toggle='tooltip' data-container='body' title='flip horizontally'><i class='fa fa-columns'></i></button>" +
            "<button type='button' class='flipY btn btn-primary' data-toggle='tooltip' data-container='body' title='flip vertically'><i class='fa fa-columns fa-rotate-90'></i></button>" +
            "<button type='button' class='crop btn btn-primary' data-toggle='tooltip' data-container='body' title='crop'><i class='fa fa-crop'></i></button>" +
            "<button type='button' class='full_image btn btn-primary' data-toggle='tooltip' data-container='body' title='full image'>full image</button>";

    var modal = "<div id='image_preview_modal' class='modal fade primary' role='dialog'>" +
            "<div class='modal-dialog '>" +
            "<div class='modal-content'>" +
            "<div class='modal-header ui-draggable-handle'>" +
            "<h4 class='modal-title text-capitalize'>Image Operations</h4>" +
            "</div>" +
            "<div class='modal-body'>" +
            "<form class='form-horizontal' novalidate='' role='form' id='image_container'>" +
            "</form>" +
            "</div>" +
            "<div class='modal-footer image_operations'>" +
            image_operations +
//            "<button type='button' class='btn btn-default' data-dismiss='modal' data-destroy='destroy'>Cancel</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";
    $("#modal_area").append(modal);
}

var $image, image_width, image_height, image_size;
function previewImage(input) {
    createImageModal();
    var key = $(input).attr("id");
    if (input.files && input.files[0]) {
        var ext = input.value.match(/\.(.+)$/)[1];
        ext = ext.toLowerCase();
        var allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if ($.inArray(ext, allowed) !== -1) {
            var reader = new FileReader();
            reader.onload = function (e) {

                var img = new Image;

                img.onload = function () {
                    image_width = img.width;
                    image_height = img.height;
                };

                img.src = reader.result; // is the data URL because called with readAsDataURL

                image_size = input.files[0].size;
                var image_preview = "<img id='" + key + "_crop_preview' class='img-thumbnail' src='#' data-image='" + key + "' alt=''/>";
                $("#image_container").html(image_preview);
                $("#" + key + "_crop_preview").attr('src', e.target.result);
                $image = $("#" + key + "_crop_preview");
                processing(true);
                $('#image_preview_modal').modal({backdrop: 'static', keyboard: false}, 'show');
                $(".modal").draggable({
                    handle: ".modal-header"
                });

                if ($(".modal.in").length > 0) {
                    var zindex = JSON.parse($(".modal.in:last").css("z-index"));
                    $('#image_preview_modal').css("z-index", zindex + 1);
                }

                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="popover"]').popover();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
}

$(document).on('shown.bs.modal', '#image_preview_modal', function () {
    showCropper($(this).find("img"));
});

$(document).on('hide.bs.modal', '#image_preview_modal', function () {
    var id = $(this).find("img").attr("id");
    id = id.replace("_crop_preview", "");
    $("#" + id).val("");
});

var cropper, scale = 1, zoom = 0, minWidth, minHeight, imageSize;

function showCropper($image) {
    var is_zoom = true;
    minWidth = $image.closest(".modal").innerWidth(true);
    minHeight = $image.closest(".modal").innerHeight(true);
    processing(false);
    cropper = $image.cropper({
//        viewMode: 1,
//        multiple: false,
//        highlight: true,
//        dragMode: 'move',
//        cropBoxMovable: false,
//        cropBoxResizable: false,

        aspectRatio: false,
        autoCropArea: false,
        background: false,
        strict: true,
        guides: false,
        highlight: true,
        dragCrop: false,
        cropBoxMovable: true,
//        cropBoxResizable: false,
        center: false,
        zoomable: false,
        minContainerWidth: minWidth,
        minContainerHeight: minHeight,
        ready: function () {
            imageSize = {
                height: $image[0].height,
                width: $image[0].width
            };
            console.log(imageSize);
//            $(this).cropper('setData', {
//                x: 0,
//                y: 0,
//                width: $image.width(),
//                height: $image.height()
//            });
//            if ((image_size > 1024000 && image_size < 2048000)) {
//                zoom = 10;
//                scale = 0.1;
//            } else if (image_size > 2048000) {
//                zoom = 20;
//                scale = 0.05;
//            } else {
//                zoom = 1;
//                scale = 0.5;
//            }
//            $(this).cropper('scale', scale, scale);
//            $(this).cropper('zoom', zoom);
            $(this).cropper('setDragMode', 'none');
        }
    });
}

$(document).on("click", ".image_operations .rotate", function () {
    rotated = 1 - rotated;
    cropper.cropper('rotate', 90);
});
var flipx = 0;
$(document).on("click", ".image_operations .flipX", function () {
    flipx = 1 - flipx;
    if (flipx === 1) {
        cropper.cropper('scale', -1 * scale, 1 * scale);
    } else {
        cropper.cropper('scale', 1 * scale, 1 * scale);
    }

});

var flipy = 0;
$(document).on("click", ".image_operations .flipY", function () {
    flipy = 1 - flipy;
    if (flipy === 1) {
        cropper.cropper('scale', 1 * scale, -1 * scale);
    } else {
        cropper.cropper('scale', 1 * scale, 1 * scale);
    }

});

$(document).on("click", ".image_operations .full_image", function () {
    processing(true);
    $('[data-toggle="tooltip"]').tooltip("destroy");
    $(".image_operations .btn").prop("disabled", true);

    cropper.cropper('setData', {
        x: 0,
        y: 0,
        width: imageSize.width,
        height: imageSize.height
    });
    setTimeout(cropImage, 500);
});

$(document).on("click", ".image_operations .crop", function () {
    processing(true);
    $('[data-toggle="tooltip"]').tooltip("destroy");
    $(".image_operations .btn").prop("disabled", true);

    setTimeout(cropImage, 500);
});

function cropImage() {
    var width = imageSize.width > 700 ? 700 : imageSize.width;
    var croppedCanvas = cropper.cropper('getCroppedCanvas', {
        width: width
    });
    var key = $image.data("image");

    $("#" + key + "_preview").attr('src', croppedCanvas.toDataURL());
    $("#" + key + "_preview").closest(".form-group").removeClass("hidden");

    cropper.cropper("destroy");
    destroyModal($("#image_preview_modal"));
    processing(false);
}