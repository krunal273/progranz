$(document).ready(function () {

    getAllPermissions();

    $(document).on("click", ".module_checkbox", function () {
        if ($(this).find(".fa-square-o").length === 1) {
            $(this).find(".fa-square-o").removeClass("fa-square-o").addClass("fa-circle-o");
            $(this).closest(".btn-group").find(".check_all").prop("disabled", true);
            changeCheckboxes("radio");
        } else {
            $(this).find(".fa-circle-o").removeClass("fa-circle-o").addClass("fa-square-o");
            $(this).closest(".btn-group").find(".check_all").prop("disabled", false);
            changeCheckboxes("checkbox");
        }
        $(this).next(".check_all").removeClass("btn-info").addClass("btn-default");
        getPermissions();
    });

//    $(document).on("click", ".add_permission", function () {
//        getData('');
//    });

    $(document).on("click", ".delete_permission", function () {
        deletePermission($("#uid").val());
    });

    $(document).on("click", ".close_permission", function () {
        getAllPermissions();
    });

    $(document).on("click", "#apply", function () {
        setPermissions();
    });

    $(document).on("click", "[data-uid]", function () {
        if ($(this).hasClass("btn-warning") || $(this).hasClass("btn-primary")) {
            getData($(this).data("uid"));
        } else {
            var delete_modal = "<div id='delete_permission' class='modal danger fade ui-draggable' role='dialog'>" +
                    "<div class='modal-dialog modal-sm'>" +
                    "<div class='modal-content'>" +
                    "<div class='modal-header ui-draggable-handle'>" +
                    "<h4 class='modal-title text-capitalize'>Confirm delete</h4>" +
                    "</div>" +
                    "<div class='modal-body'>Really want to delete?</div>" +
                    "<input type='hidden' id='uid' value='" + $(this).data("uid") + "'>" +
                    "<div class='modal-footer'>" +
                    "<button type='submit' form='' class='btn btn-danger delete_permission'>Yes delete</button>" +
                    "<button type='button' class='btn btn-default cancel_operation' data-dismiss='modal' data-destroy='modal'>no</button>" +
                    "</div></div></div></div>";
        }
        $("#modal_area").append(delete_modal);
        $('#delete_permission').modal({backdrop: 'static', keyboard: false}, 'show');
        $(".modal").draggable({
            handle: ".modal-header"
        });
    });
    $(document).on("change", "[name^=module_ids]", function () {
        getPermissions();
    });
    $(document).on("change", "#usertype", function () {
        getPermissions();
    });

    $(document).on("click", ".check_all", function () {
        if (!$(this).attr("data-none") !== false) {
            $(this).attr("data-none", "none");
            $(this).closest(".panel").find(":checkbox").prop("checked", true);
            $(this).removeClass("btn-default").addClass("btn-info");
        } else {
            $(this).removeAttr("data-none");
            $(this).closest(".panel").find(":checkbox").prop("checked", false);
            $(this).removeClass("btn-info").addClass("btn-default");
        }
        if ($(this).closest(".panel").find(".module_boxes").length === 1) {
            getPermissions();
        }
    });

    $(document).on("change", ":checkbox", function () {
        var checked = $(this).closest(".panel").find(":checkbox:checked").length;
        var total = $(this).closest(".panel").find(":checkbox").length;
        var all = $(this).closest(".panel").find(".check_all");
        if (total === checked) {
            all.attr("data-none", "none");
            all.removeClass("btn-default").addClass("btn-info");
        } else {
            all.removeAttr("data-none");
            all.removeClass("btn-info").addClass("btn-default");
        }
    });
});

function changeCheckboxes(type) {
    var other_type = type === "radio" ? "checkbox" : "radio";
    var checkboxes = $(".module_boxes input");
    checkboxes.each(function (index, ele) {
        $(ele).attr("type", type);
        $(ele).closest("div").removeClass(other_type).addClass(type);
    });
}

function openPermissionModal(json_ob, type) {
    var usertype_select = getUsertypeGUI(json_ob.usertype);

    var permission_data = "<div class='row'>";
    permission_data += getModuleGUI(json_ob.module);
    permission_data += getCategoryGUI(json_ob.category);
    permission_data += getOperationGUI(json_ob.operation);
    permission_data += "</div>";

    var modal_color = "info";//type === "add" ? "info" : "info";
    //var operation = type === "add" ? "add" : "edit";
    var modal = "<div id='permission_modal' class='modal " + modal_color + " fade'>" +
            "<div class='modal-dialog modal-lg'>" +
            "<div class='modal-content'>" +
            "<div class='modal-header'>" +
            "<h4 class='modal-title'>Set Permission</h4>" +
            "</div>" +
            "<div class='modal-body'>" +
            "<form enctype='multipart/form-data' method='post' class='form-horizontal' novalidate='' role='form' id='form_permission'>" +
            usertype_select +
            permission_data +
            "</form>" +
            "</div>" +
            "<div class='modal-footer'>" +
            "<button type='button' form='form_permission' disabled id='apply' class='btn btn-" + modal_color + "'>Apply</button>" +
            "<button type='button' class='btn btn-default close_permission' data-dismiss='modal'>Cancel</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";

    if ($('#permission_modal').length === 0) {
        $("#modal_area").append(modal);
    } else {
        $('#permission_modal').replaceWith(modal);
    }
    $('#permission_modal').modal({backdrop: 'static', keyboard: false}, 'show');
    $(".modal").draggable({
        handle: ".modal-header"
    });

    if ($(".modal.in").length > 0) {
        var zindex = JSON.parse($(".modal.in:last").css("z-index"));
        $('#permission_modal').css("z-index", zindex + 1);
    }

    $('[data-toggle="popover"]').popover();
}

function getPermissions() {
    var modules = [], usertype = $("#usertype").val();

    $("[name^=module_ids]:checked").each(function () {
        modules.push($(this).val());
    });

    if (modules.length > 0 && JSON.parse(usertype) !== -1) {
        $.ajax({
            url: "../classes/permission.php",
            beforeSend: function () {
                processing(true);
                enableSubmitButton($("#apply"), false);
            },
            data: {
                usertype: usertype,
                get_permissions: modules
            },
            type: "GET",
            success: function (response) {
                var json_ob = parseJSON(response);
                refreshPermissions(json_ob);
                enableSubmitButton($("#apply"), true);
                $("[data-toggle=tooltip]").tooltip();
                $("[data-toggle=popover]").tooltip();
            },
            error: function (response) {
                showAJAXError(response);
                enableSubmitButton($("#apply"), true);
            }
        });
    } else {
        resetCheckboxes();
        checkCheckboxes();
        getOperations();
    }
}

function getAllPermissions() {
    $.ajax({
        url: "../classes/permission.php",
        beforeSend: function () {
            processing(true);
        },
        data: {
            get_all_permissions: ''
        },
        type: "GET",
        success: function (response) {
            var json_ob = parseJSON(response);
            if (json_ob !== false) {
                processing(false);
                allPermissionGUI(json_ob);
            }
        },
        error: function (response) {
            showAJAXError(response);
        }
    });
}

function refreshPermissions(json_ob) {
    if (json_ob !== false) {
        processing(false);
        resetCheckboxes();
        $(".operation_boxes").html(getOperationCheckboxes(json_ob.module_operation));
        $.each(json_ob.category, function (index, object) {
            $("#category_checkboxes_" + object.category_id).prop("checked", true);
        });
        $.each(json_ob.operation, function (index, object) {
            $("#operation_checkboxes_" + object.operation_id).prop("checked", true);
        });
    }
    checkCheckboxes();
}

function setPermissions() {
    var modules = [], usertype = $("#usertype").val(), category = [], operation = [];

    $("[name^=module_ids]:checked").each(function () {
        modules.push($(this).val());
    });
    $("[name^=category_ids]:checked").each(function () {
        category.push($(this).val());
    });
    if (category.length === 0) {
        category = "none";
    }

    $("[name^=operation_ids]:checked").each(function () {
        operation.push($(this).val());
    });
    if (operation.length === 0) {
        operation = "none";
    }

    if (modules.length > 0 && JSON.parse(usertype) !== -1) {
        $.ajax({
            url: "../classes/permission.php",
            beforeSend: function () {
                processing(true);
                enableSubmitButton($("#apply"), false);
            },
            data: {
                usertype: usertype,
                category: category,
                operation: operation,
                set_permissions: modules
            },
            type: "GET",
            success: function (response) {
                var json_ob = parseJSON(response);
                var ob = {
                    type: "success",
                    message: "permission succeessfully set"
                };
                showAlert(ob);
                refreshPermissions(json_ob);
                enableSubmitButton($("#apply"), true);
            },
            error: function (response) {
                showAJAXError(response);
                enableSubmitButton($("#apply"), true);
            }
        });
    } else {
        resetCheckboxes();
    }
}

function resetCheckboxes() {
    $("[name^=category_ids]").prop("checked", false);
    $("[name^=operation_ids]").prop("checked", false);
}

function checkCheckboxes() {
    $(".panel").each(function (index, panel) {
        var checked = $(panel).find(":checkbox:checked").length;
        var total = $(panel).find(":checkbox").length;
        var total_radio = $(panel).find(":radio").length;
        var all = $(panel).find(".check_all");
        if (total === checked && total_radio === 0) {
            all.attr("data-none", "none");
            all.removeClass("btn-default").addClass("btn-info");
        } else {
            all.removeAttr("data-none");
            all.removeClass("btn-info").addClass("btn-default");
        }
    });
}

function getOperations() {
    var modules = [];

    $("[name^=module_ids]:checked").each(function () {
        modules.push($(this).val());
    });
    if (modules.length === 0) {
        modules = "none";
    }

    $.ajax({
        url: "../classes/permission.php",
        beforeSend: function () {
            processing(true);
            enableSubmitButton($("#apply"), false);
        },
        data: {
            get_operations: modules
        },
        type: "GET",
        success: function (response) {
            var json_ob = parseJSON(response);
            if (json_ob !== false) {
                processing(false);
                $(".operation_boxes").html(getOperationCheckboxes(json_ob));
                $("[data-toggle=tooltip]").tooltip();
                $("[data-toggle=popover]").tooltip();
            }
            enableSubmitButton($("#apply"), true);
        },
        error: function (response) {
            showAJAXError(response);
            enableSubmitButton($("#apply"), true);
        }
    });
}

function getData(uid) {
    $.ajax({
        url: "../classes/permission.php",
        beforeSend: function () {
            processing(true);
            enableSubmitButton($("#apply"), false);
        },
        data: {
            permission_data: ''
        },
        type: "GET",
        success: function (response) {
            var json_ob = parseJSON(response);
            if (json_ob !== false) {
                processing(false);
                openPermissionModal(json_ob, "add");
                if (uid !== '') {
                    $("#usertype").val(uid);
                }
            }
            enableSubmitButton($("#apply"), true);
        },
        error: function (response) {
            showAJAXError(response);
            enableSubmitButton($("#apply"), true);
        }
    });
}

function getModuleGUI(json_ob) {
    var permission_data = "";
    permission_data += "<div class='col-md-6'>";
    permission_data += "<div class='panel panel-info'>" +
            "<div class='panel-heading text-capitalize'>" +
            "<span class='text-uppercase'><strong>modules</strong></span>" +
            "<div class='btn-group btn-group-xs pull-right'>" +
            "<button class='btn btn-default btn-xs module_checkbox' type='button'><i class='fa fa-circle-o'></i></button>" +
            "<button class='btn btn-default btn-xs check_all' disabled type='button'>all</button>" +
            "</div>" +
            "</div>" +
            "<div class='panel-body module_boxes'>";

    var cols = 1;
    if (json_ob.length > 9) {
        cols = 2;
    }

    var width = 12 / cols;
    var total = json_ob.length;
    var gap = Math.ceil(total / cols);
    var start = 0;
    var end;
    for (var i = 0; i < cols; i++) {
        permission_data += "<div class='col-md-" + width + "'>";
        start = i * gap;
        end = (start + gap) > total ? total : start + gap;
        var type = "radio";
        for (var j = start; j < end; j++) {
            permission_data += "<div class='" + type + " info'>" +
                    "<input class='' type='" + type + "' name='module_ids[]' id='module_checkboxes_" + json_ob[j].id + "' value='" + json_ob[j].id + "'>" +
                    "<label for='module_checkboxes_" + json_ob[j].id + "' class='text-capitalize'>" + json_ob[j].name + "</label>" +
                    "</div>";

        }
        permission_data += "</div>";
    }

    permission_data += "</div></div>";
    permission_data += "</div>";
    return permission_data;
}

function getCategoryGUI(json_ob) {
    var permission_data = "";
    permission_data += "<div class='col-md-3'>";
    permission_data += "<div class='panel panel-info'>" +
            "<div class='panel-heading text-capitalize'>" +
            "<span class='text-uppercase'><strong>categories</strong></span>" +
            "<button class='btn btn-default btn-xs pull-right check_all' type='button'>all</button>" +
            "</div>" +
            "<div class='panel-body category_boxes'>";

    $.each(json_ob, function (index, object) {
        permission_data += "<div class='checkbox info'>" +
                "<input class='' type='checkbox' name='category_ids[]' id='category_checkboxes_" + object.id + "' value='" + object.id + "'>" +
                "<label for='category_checkboxes_" + object.id + "' class='text-capitalize'>" + object.name + "</label>" +
                "</div>";

    });

    permission_data += "</div></div>";
    permission_data += "</div>";
    return permission_data;
}

function getOperationGUI(json_ob) {
    var permission_data = "";
    permission_data += "<div class='col-md-3'>";
    permission_data += "<div class='panel panel-info'>" +
            "<div class='panel-heading text-capitalize'>" +
            "<span class='text-uppercase'><strong>operations</strong></span>" +
            "<button class='btn btn-default btn-xs pull-right check_all' type='button'>all</button>" +
            "</div>" +
            "<div class='panel-body operation_boxes'>";

    permission_data += getOperationCheckboxes(json_ob);

    permission_data += "</div></div>";
    permission_data += "</div>";
    return permission_data;
}

function getOperationCheckboxes(json_ob) {
    var permission_data = "";
    $.each(json_ob, function (index, object) {
        var specific = "";
        if (object.common === "specific") {
            specific = " <i class='fa fa-info-circle' title='only relevant modules' data-toggle='tooltip' data-placement='top'></i>";
        }
        permission_data += "<div class='checkbox info'>" +
                "<input class='' type='checkbox' name='operation_ids[]' id='operation_checkboxes_" + object.id + "' value='" + object.id + "'>" +
                "<label for='operation_checkboxes_" + object.id + "' class='text-capitalize'>" + object.name +
                specific +
                "</label>" +
                "</div>";

    });
    return permission_data;
}

function getUsertypeGUI(json_ob) {
    var usertype_select = "";
    usertype_select += "<div class='form-group'>" +
            "<label class='text-capitalize col-sm-1 control-label' for='usertype' >usertype</label>" +
            "<div class='padding_lr_15 col-sm-4'>" +
            "<select class='form-control text-capitalize' id='usertype'>";
    $.each(json_ob, function (index, object) {
        usertype_select += "<option value='" + object.id + "'>" + object.name + "</option>";
    });
    usertype_select += "</select>" +
            "</div>" +
            "</div>";
    return usertype_select;
}

function allPermissionGUI(json_ob) {
    var gui = "";

    $.each(json_ob, function (index, utype) {
        var modules = "", module_count = 0;
        modules += "<div class='panel-body'>" +
                "<div class='panel-group' id='accordion_" + utype.id + "'>";

        $.each(utype.module, function (index, module) {
            var categories = module.category.length;
            var operations = module.operation.length;

            if (categories > 0 || operations > 0) {
                module_count++;
                modules += "<div class='panel panel-default'>" +
                        "<div class='panel-heading' data-toggle='collapse' data-parent='#accordion_" + utype.id + "' href='#collapse_" + utype.id + "_" + module.id + "'>" +
                        "<h4 class='panel-title text-capitalize'>" +
                        module.name +
                        "</h4>" +
                        "</div>" +
                        "<div id='collapse_" + utype.id + "_" + module.id + "' class='panel-collapse collapse'>" +
                        "<div class='panel-body'>" +
                        "<ul class='list-group col-md-6'>" +
                        "<li class='list-group-item text-center info'><strong>Categories</strong></li>";

                $.each(module.category, function (index, category) {
                    var del_button = "";//"<button class='btn btn-xs btn-danger pull-right'>delete</button>";
                    modules += "<li class='list-group-item text-capitalize'>" + category.name + del_button + "</li>";
                });

                modules += "</ul>" +
                        "<ul class='list-group col-md-6'>" +
                        "<li class='list-group-item text-center info'><strong>Operations</strong></li>";

                $.each(module.operation, function (index, operation) {
                    var del_button = "";//"<button class='btn btn-xs btn-danger pull-right'>delete</button>";
                    modules += "<li class='list-group-item text-capitalize'>" + operation.name + del_button + "</li>";
                });

                modules += "</ul>" +
                        "</div>" +
                        "</div>" +
                        "</div>";
            }
        });

        gui += "<div class='col-sm-4'>" +
                "<div class='panel panel-info'>" +
                "<div class='panel-heading'>" +
                "<strong class='text-uppercase'>" + utype.name.replace(' ', '&nbsp;') + "</strong>";

        if (module_count === 0) {
            gui += "<button class='btn btn-primary btn-xs add_permission pull-right' type='button' data-uid='" + utype.id + "'>add</button> ";
        } else {
            gui += "<div class='btn-group1 btn-group-xs pull-right'>" +
                    "<button class='btn btn-warning' type='button' data-uid='" + utype.id + "'>edit</button> ";
            if (!utype.hasOwnProperty("same")) {
                gui += "<button class='btn btn-danger' type='button' data-uid='" + utype.id + "'>delete</button>";
            }
            gui += "</div>";
        }

        gui += "</div>";

        if (module_count > 0) {
            gui += modules;
        } else {
            gui += "<span class='well well-sm btn-block text-capitalize text-danger'><strong>no permissions set</strong></span>";
            gui += " ";
        }

        gui += "</div> " +
                "</div>" +
                "</div>" +
                "</div>";
    });

    $(".all_permission").html(gui);
}

function deletePermission(uid) {
    $.ajax({
        url: "../classes/permission.php",
        beforeSend: function () {
            processing(true);
            enableSubmitButton($(".delete_permission"), false);
        },
        data: {
            delete_permission: uid
        },
        type: "GET",
        success: function (response) {
            var json_ob = parseJSON(response);
            if (json_ob !== false) {
                processing(false);
                showAlert(json_ob);
                destroyModal($("#delete_permission"));
                getAllPermissions();
            }
            enableSubmitButton($(".delete_permission"), true);
        },
        error: function (response) {
            showAJAXError(response);
            enableSubmitButton($(".delete_permission"), true);
        }
    });
}