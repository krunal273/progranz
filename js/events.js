/* global date_tooltip, form_data, digit_filters_select, text_filters_select, current_page */
var is_mobile;
$(document).ready(function () {
    
    is_mobile = mobileAndTabletcheck();
//    fixedTableHead();
//
//    $(window).resize(function () {
//        fixedTableHead();
//    });

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    setButtonGroupRadius();
    if (!is_mobile) {
        focusFirstElement();
    }
    openNavbar();
    makeMenuActive();
    $(window).scroll(function () {
        checkTopBottom();
    });
    $(window).resize(function () {
        checkTopBottom();
    });

    $(document).on("click", "#print_page", function () {
        print();
    });

    $(document).on("click", "#orientation", function () {
        if (!$(this).find("i").hasClass("landscape")) {
            $(this).find("i").addClass("landscape fa-rotate-270");
            $("head").append("<link class='page_landscape' href='../css/landscape.css' rel='stylesheet'>");
        } else {
            $(this).find("i").removeClass("landscape fa-rotate-270");
            $("head .page_landscape").attr('disabled', true).remove();
        }
    });

    $(document).on("click", "[data-toggle=tooltip]", function () {
        $("[data-toggle=tooltip]").tooltip('hide');
    });

    $(document).on("click", "[data-reset_ta]", function () {
        var id = $(this).data("reset_ta");
        configureTypeahead(id);
        $("#" + id).val("");
        $("#" + id + "_selected").val("");
        $("[data-form_group='" + id + "']").addClass("hidden");
        $("[data-ta_form_group='" + id + "']").removeClass("hidden");
        $("#" + id + "_ta").val("");
        $("#" + id + "_ta").focus();
    });

    $(document).on('typeahead:select', '.typeahead.general', function (evt, item) {
        $(this).typeahead("val", "");
        var id = $(this).attr("id").replace("_ta", "");
        $("#" + id).val(item.id);
        $("#" + id + "_selected").val(item.name);
        $("[data-ta_form_group='" + id + "']").addClass("hidden");
        $("[data-form_group='" + id + "']").removeClass("hidden");
        $("[data-reset_ta=" + id + "]").focus();
    });

    $(document).on("click", ".back_to_top", function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: 0}, 500);
        $(this).blur();
        $("[data-toggle=tooltip]").tooltip('hide');
        return false;
    });
    $(document).on("click", ".back_to_bottom", function (e) {
        e.preventDefault();
        $('html, body').animate({scrollTop: $(document).height()}, 500);
        $(this).blur();
        $("[data-toggle=tooltip]").tooltip('hide');
        return false;
    });

    $(document).on("mouseenter", "footer button", function () {
        $(this).removeClass("btn-default").addClass("btn-primary");
    });

    $(document).on("mouseleave", "footer button", function () {
        $(this).removeClass("btn-primary").addClass("btn-default");
    });

    $(document).on("submit", "form[data-function]", function () {
        var functionName = $(this).data("function");
        functionName = window[functionName];
        if (!!functionName !== false) {
            functionName($(this));
        } else {
            console.log("Function " + $(this).data("function") + " not found");
        }
        return false;
    });
    $(document).on("submit", "form:not([data-function])", function (e) {
        var submit_button;
        if ($(this).closest(".modal").length > 0) {
            submit_button = $(this).closest(".modal").find(".modal-footer :submit:visible:not(:disabled):first");
        } else {
            submit_button = $(this).find(":submit:visible:not(:disabled):first");
        }
        enableSubmitButton(submit_button, false);
        submitForm($(this), e);
    });
    $(document).on("click", ".reset_operation", function () {
        resetForm($(this).closest(".modal").find("form"), "no clear");
    });
    $(document).on('show.bs.modal', '.modal', function () {
        var modal = $(this);
        $(":file").each(function (index, ele) {
            var filestyle_object = {
                buttonText: "",
                buttonName: "btn-primary",
                placeholder: "Select File"
            };
            if (!!$(ele).data("buttontext") !== false) {
                filestyle_object.buttonText = capitalizeFirstLetter($(ele).data("buttontext"));
            }
            if (!!$(ele).data("placeholder") !== false) {
                filestyle_object.placeholder = capitalizeFirstLetter($(ele).data("placeholder"));
            }
            if (!!$(ele).attr("accept") !== false) {
                filestyle_object.placeholder += " (" + $(ele).attr("accept") + ")";
            }
            if (!!$(ele).data("buttontext") !== false) {
                filestyle_object.buttonText = capitalizeFirstLetter($(ele).data("buttontext"));
            }
            if (modal.hasClass("warning")) {
                filestyle_object.buttonName = "btn-warning";
            }
            $(ele).filestyle(filestyle_object);
            $(ele).closest(".form-group").find(".bootstrap-filestyle input").prop("disabled", false);
            $(ele).closest(".form-group").find(".bootstrap-filestyle input").prop("readonly", true);
        });
        $(this).find(".wait").removeAttr("disabled").removeClass("wait");
    });

    $(document).on("click", ".bootstrap-filestyle input", function () {
        $(this).closest(".bootstrap-filestyle").find(".group-span-filestyle span:last").click();
    });

    $(document).on('shown.bs.modal', '.modal', function () {
        autosize($('textarea'));
        if ($(this).find("form").length > 0) {
            focusFirstElement();
        } else {
            focusCancelModalButton($(this));
        }
        $("[data-toggle=tooltip]").tooltip();
        $("[data-toggle=popover]").tooltip();
    });
    $(document).on('hidden.bs.modal', '.modal', function () {
        $(this).closest(".modal[id^=edit]").remove();
        var add_other = $(this).find("[name=this_col]").length;
        if ($(this).closest(".modal").attr("id").indexOf("insert") !== -1 && add_other === 0) {
            focusFirstElement();
        }
    });
    $(document).on("keyup", "input[data-required]:not([data-max]):not([data-float]):not([data-exact]),textarea[data-required]:not([data-max]):not([data-exact]), input[type=email]", function () {
        if ($(this).val().length > 0) {
            removeValidation($(this), "error");
        }
    });
    $(document).on("keyup", "input[type=tel]", function (e) {
        return limitText($(this), $(this).data("exact"), e);
    });
    $(document).on("keydown", "input[type=tel]", function (e) {
        return isValidMobile($(this), 10, e);
    });
    $(document).on("keydown", "input[data-float]", function (e) {
        return isValidFloat($(this), e);
    });
    $(document).on("keyup", "input[data-float]", function (e) {
        if (is_mobile) {
            mobileIsValidFloat($(this));
        }
    });
    $(document).on("keyup", "input[type=tel], input[type=number]", function (e) {
        if (is_mobile) {
            isNumber($(this));
        }
    });
    $(document).on("keydown", "input[data-number]", function (e) {
        return isDigit($(this), e);
    });
    $(document).on("keydown", "input[data-max]:not([data-limit])", function (e) {
        var is_valid = limitText($(this), $(this).data("max"), e);
        if (is_valid) {
            removeValidation($(this), "error");
        }
        return is_valid;
    });
    $(document).on("keydown", "input[data-exact]", function (e) {
        return limitText($(this), $(this).data("exact"), e);
    });

    $(document).on('paste', "input[data-max]:not([data-limit])", function (e) {
        return isValidaPaste($(this), $(this).data("max"), e);
    });

    $(document).on('paste', "input[data-exact]", function (e) {
        return isValidaPaste($(this), $(this).data("exact"), e);
    });

    $(document).on("change", "select[data-required]", function (e) {
        var selectedIndex = JSON.parse($(this).find("option:selected").val());
        if (selectedIndex === -1) {
            showValidation($(this), "error", "Please select " + getLabelName($(this)));
        } else {
            removeValidation($(this), "error");
        }
    });
    $(document).on("click", "[data-dismiss='alert']", function () {
        focusFirstElement();
    });
    $(document).on("click", "[data-dismiss='modal']", function () {
        if ($(this).closest(".modal").find("#editId").length === 1) {
            $("#checkboxes_" + $("#editId").val()).focus();
        }
        if (!!$(this).data("destroy") !== false) {
            destroyModal($(this).closest(".modal"));
        }
    });
    $(document).on("click", "button[data-modal], [data-select]", function () {
        showAddEditModal($(this));
    });
    $(document).on("change", "#all", function () {
        var status = $(this).prop("checked");
//        if (status) {
//            $(".checkboxes :checkbox:not(#all)").closest("tr").addClass("checked");
//        } else {
//            $(".checkboxes :checkbox:not(#all)").closest("tr").removeClass("checked");
//        }
        $(".checkboxes :checkbox:not(#all)").prop("checked", status);
        checkMultipleOperation();
    });
    $(document).on("change", ".checkboxes :checkbox:not(#all)", function () {
//        if ($(this).prop("checked")) {
//            $(this).closest("tr").addClass("checked");
//        } else {
//            $(this).closest("tr").removeClass("checked");
//        }
        var total = $(".checkboxes :checkbox:not(#all)").length;
        var total_checked = $(".checkboxes :checkbox:not(#all):checked").length;
        if (total === total_checked) {
            $("#all").prop("checked", true);
        } else {
            $("#all").prop("checked", false);
        }
        checkMultipleOperation();
    });
//    $(document).on("focus, mouseenter", ".checkboxes :checkbox:not(#all)", function (e) {
//        $(this).closest("tr").addClass("hover");
//    });
//    $(document).on("blur, mouseleave", ".checkboxes :checkbox:not(#all)", function (e) {
//        $(this).closest("tr").removeClass("hover").removeClass("checked");
//    });

    $(document).on("change", "[data-select_all]", function () {
        var status = $(this).prop("checked");
        $(this).closest(".modal").find(":checkbox:not([data-select_all])").prop("checked", status);
    });
    $(document).on("change", "#filter_select :checkbox:not([data-select_all])", function () {
        var total = $("#filter_select :checkbox:not([data-select_all])").length;
        var total_checked = $("#filter_select :checkbox:not([data-select_all]):checked").length;
        if (total === total_checked) {
            $("[data-select_all]").prop("checked", true);
        } else {
            $("[data-select_all]").prop("checked", false);
        }
    });
    $(document).on("change", ".date_checkbox", function () {
        if ($(".date_checkbox:checked").length === 0) {
            $("[data-date]").prop("disabled", true);
            $(".date input").prop("disabled", true);
        } else {
            $("[data-date]").prop("disabled", false);
            $(".date input").prop("disabled", false);
        }
    });
    $(document).on("click", ".delete_operation, .activate_operation, .deactivate_operation, .destroy_operation, .harddelete_operation, .restore_operation, .logout_operation", function () {
        showOperationModal($(this));
    });
    $(document).on("click", ".yes_delete, .yes_activate, .yes_deactivate, .yes_destroy, .yes_restore, .yes_harddelete", function () {
        yesOperation($(this));
    });
    $(document).on("click", ".yes_logout", function () {
        logout();
    });
    $(document).on("click", ".cancel_operation", function () {
        focusCheckbox($(this).closest(".modal"));
        destroyModal($(this).closest(".modal"));
    });

    $(document).on("click", "[data-category]", function () {
        var filters = {
            category: $(this).data("category")
        };
        getGUI(filters);
    });
    $(document).on("click", "[data-page]", function () {
        var filters = {
            page: $(this).data("page")
        };
        getGUI(filters);
    });
    $(document).on("click", "[data-per_page]", function () {
        var filters = {
            per_page: $(this).data("per_page")
        };
        getGUI(filters);
    });
    $(document).on("click", "[data-sort]:not(.wait)", function () {
        var filters = {
            sort: $(this).data("sort"),
            order: $(this).data("order")
        };
        getGUI(filters);
    });
    $(document).on("click", "[data-remove_sort]:not(.wait)", function () {
        var filters = {
            remove_sort: $(this).data("remove_sort")
        };
        getGUI(filters);
    });
    $(document).on("click", "[data-remove_search]", function () {
        var filters = {
            remove_search: $(this).data("remove_search")
        };
        getGUI(filters);
    });

    $(document).on("click", "[data-remove_asearch]", function () {
        var filters = {
            remove_asearch: $(this).data("remove_asearch")
        };
        getGUI(filters);
        destroyModal($(this).closest(".modal"));
    });

    $(document).on("click", "[data-filter]:not(.wait)", function () {
        openSelectionBox($(this));
        $("[data-toggle=tooltip]").tooltip('hide');
    });

    $(document).on("click", "[data-remove_filter]:not(.wait)", function () {
        removeFilter($(this));
    });

    $(document).on("click", "#operations", function () {
        var display = $(".operations").css("display") === "table-cell" ? "none" : "table-cell";
        toggleOperations(display, "");
    });

    $(document).on("click", "#date_search [data-date]:not([data-date=custom_range])", function (e) {
        $(".date_selected").removeClass("date_selected");
        var filters = {
            date_filter: $(this).data("date")
        };
        getGUI(filters);
    });

    $(document).on("click", ".clear_date", function (e) {
        $(".date_selected").removeClass("date_selected");
        $(this).remove();
    });

    $(document).on("click", "[data-date=custom_range]", function (e) {
        var display = $("#end_date").closest(".date").css("display") === "table" ? "none" : "table";
        $("#end_date").closest(".date").css("display", display);
        if (display === "table") {
            $("#start_date").closest(".date").addClass("date_selected");
            $("#end_date").closest(".date").addClass("date_selected");

            if ($(".clear_date").length === 0 && $(".date_selected.danger").length === 0) {
                var clear_date = {
                    title: 'clear date',
                    class: 'clear_date btn-primary'
                };
                $("[data-date]:first").before(getButton(clear_date));
            }
        } else {
            $("#end_date").closest(".date").removeClass("date_selected");
        }
    });

    $(document).on("click", "[data-a_search]:not(.wait)", function () {
        openAdvancedSearch();
    });

    $(document).on("click", "#date_search li, #date_search", function (e) {
        e.stopPropagation();
    });

    $(document).on("show.bs.dropdown", "#date_dropdown", function (event) {
        $(this).attr("data-original-title", "");
        $("[data-toggle=tooltip]").tooltip('hide');
    });

    $(document).on("hide.bs.dropdown", "#date_dropdown", function (event) {
        $(this).attr("data-original-title", date_tooltip);
    });
    $(document).on("click", "#date_search .date input,#date_search .date label", function () {
        if ($("#end_date").closest(".date").css("display") !== "none") {
            $(".date").addClass("date_selected");
        } else {
            $(this).closest(".date").addClass("date_selected");
        }
        if ($(".clear_date").length === 0 && $(".date_selected.danger").length === 0) {
            var clear_date = {
                title: 'clear date',
                class: 'clear_date btn-primary'
            };
            $("[data-date]:first").before(getButton(clear_date));
        }
    });

    $(document).on("click", ".password_operation", function () {
        var modal_button = $(this);
        $.ajax({
            url: "../classes/user.php",
            beforeSend: function () {
                processing(true);
            },
            data: {
                get_form_password: ''
            },
            type: "POST",
            success: function (response) {
                var json_ob = parseJSON(response);
                if (json_ob !== false) {
                    modal_button.closest("tr").find(":checkbox").prop("checked", true);
                    if (modal_button.closest("tr").length > 0) {
                        json_ob.checkbox_id = modal_button.closest("tr").find(":checkbox").attr("id");
                    }
                    showModal(json_ob);
                }
            },
            error: function (response) {
                showAJAXError(response);
            }
        });
    });

    $(document).on("click", ".profile_operation", function () {
        var id = $(this).data("id");
        $.ajax({
            url: "../classes/user.php",
            beforeSend: function () {
                processing(true);
            },
            data: {
                get_form_profile: id
            },
            type: "POST",
            success: function (response) {
                var json_ob = parseJSON(response);
                if (json_ob !== false) {
                    showModal(json_ob);
                }
            },
            error: function (response) {
                showAJAXError(response);
            }
        });
    });

    $(document).on("click", "#get_pdf", function () {
        var orientation = 'P';
        if ($("#orientation").find("i").hasClass("landscape")) {
            orientation = 'L';
        }
        window.location = "../classes/" + current_page + "?operation=pdf&orientation=" + orientation;
    });

    $(document).on("click", "#get_excel", function () {
        window.location = "../classes/" + current_page + "?operation=excel";
    });

    $(document).on("click", ".and_condition, .or_condition", function () {
        if ($(this).closest(".input-group-btn").find(".btn-primary").length === 0) {
            $(this).closest(".input-group").after(getCleanedClone($(this)));
            checkASearchGUI();
        }
        $(this).closest("div").find(".btn").removeClass("btn-primary").addClass("btn-default");
        $(this).removeClass("btn-default").addClass("btn-primary");
    });

    $(document).on("click", ".group_and_condition, .group_or_condition", function () {
        if ($(this).closest(".btn-group").find(".btn-primary").length === 0) {
            $(this).closest("fieldset").after(getCleanedGroup());
            checkASearchGUI();
        }
        $(this).closest(".btn-group").find(".btn-primary").removeClass("btn-primary").addClass("btn-default");
        $(this).removeClass("btn-default").addClass("btn-primary");
    });

    $(document).on("click", ".remove_button", function () {
        $(this).closest(".input-group").remove();
        checkASearchGUI();
    });

    $(document).on("click", ".group_remove_button", function () {
        $(this).closest("fieldset").remove();
        checkASearchGUI();
    });

    $(document).on("click", ".move_up", function () {
        var clone = $(this).closest(".input-group").clone();
        $(this).closest(".input-group").prev().before(clone);
        $(this).closest(".input-group").remove();
        checkASearchGUI();
    });

    $(document).on("click", ".group_move_up", function () {
        var clone = $(this).closest("fieldset").clone();
        $(this).closest("fieldset").prev().before(clone);
        $(this).closest("fieldset").remove();
        checkASearchGUI();
    });

    $(document).on("click", ".move_down", function () {
        var clone = $(this).closest(".input-group").clone();
        $(this).closest(".input-group").next().after(clone);
        $(this).closest(".input-group").remove();
        checkASearchGUI();
    });

    $(document).on("click", ".group_move_down", function () {
        var clone = $(this).closest("fieldset").clone();
        $(this).closest("fieldset").next().after(clone);
        $(this).closest("fieldset").remove();
        checkASearchGUI();
    });

    $(document).on("click", ".a_search_submit", function () {
        validateASearch();
    });

    $(document).on("click", "[data-search_fields], [data-filter_condition]", function (e) {
        if (!!$(this).data("search_fields") !== false) {
            var field = $(this).data("search_fields");
            var type = form_data.fields[field]["type"];
            if (type === "tel" || type === "number") {
                if ($(this).closest(".btn-group").next(".filter_select").data("filter_type") !== "digit") {
                    $(this).closest(".btn-group").next(".filter_select").replaceWith(digit_filters_select);
                }
            } else {
                if ($(this).closest(".btn-group").next(".filter_select").data("filter_type") !== "text") {
                    $(this).closest(".btn-group").next(".filter_select").replaceWith(text_filters_select);
                }
            }
        }

        $(this).closest("ul").find("i").attr("data-hide", "hide");
        $(this).find("i").attr("data-hide", "show");
        $(this).closest(".btn-group").find(".btn").html($(this).closest("a").text());
        validateASearchField($(this));
    });

    $(document).on("keyup", "[data-filter_value]", function (e) {
        validateASearchField($(this));
    });

    $(document).on("keyup", "[data-same_as_compare]", function (e) {
        var id = $(this).attr("id");
        var status = $(this).closest(".modal").find("[data-same_as=" + id + "]").prop("checked");
        var same_as = $(this);
        var target = $(this).closest(".modal").find("#" + $(this).data("same_as_compare"));

        if (status) {
            target.val(same_as.val());
        }
    });

    $(document).on("change", "[data-same_as]", function () {
        var status = $(this).prop("checked");
        var same_as = $(this).closest(".modal").find("#" + $(this).data("same_as"));
        var target = $(this).closest(".form-group").find("textarea");
        if (status) {
            target.val(same_as.val());
            target.prop("readOnly", true);
        } else {
            target.prop("readOnly", false);
        }

    });

    $(document).on('change', ':file', function (e) {
        var file_input = this;
        var ext = this.value.match(/\.(.+)$/)[1];
        ext = ext.toLowerCase();
        var allowed = [];
        if (!!$(this).attr("accept") !== false) {
            allowed = $(this).attr("accept").split(",");
        }

        if (allowed.length > 0) {
            for (var i = 0; i < allowed.length; i++) {
                allowed[i] = allowed[i].trim().replace(".", "");
            }
            if ($.inArray(ext, allowed) === -1 || ext === "exe") {
                $(":file").filestyle('clear');
                showValidation($(this), "error", "Invalid format. Only " + allowed.join(", ") + " format allowed");
                this.value = '';
            } else {
                previewImage(file_input);
                removeValidation($(this), "error");
            }
        } else {
            if (ext === "exe") {
                $(":file").filestyle('clear');
                showValidation($(this), "error", "Invalid format");
                this.value = '';
            } else {
                previewImage(file_input);
                removeValidation($(this), "error");
            }
        }
    });
});

function validateASearchField(ele) {
    var input_group = ele.closest(".input-group");
    var filter_field = input_group.find(".filter_field [data-hide=show]").length;
    var filter_select = input_group.find(".filter_select [data-hide=show]").length;
    var filter_value = input_group.find("[data-filter_value]").val().length;
    if (filter_field !== 0 && filter_select !== 0 && filter_value !== 0) {
        $(input_group).removeClass("danger");
    }
}

function validateASearch() {
    var submit = true;
    var asearch = {};

    $("fieldset").each(function (i, fieldset) {
        asearch["group_" + i] = {
            condition: [],
            join: ""
        };
        $(fieldset).find(".input-group").each(function (j, input_group) {
            var filter_field = $(input_group).find(".filter_field [data-hide=show]");
            var filter_select = $(input_group).find(".filter_select [data-hide=show]");
            var filter_value = $(input_group).find("[data-filter_value]").val();
            if (filter_field.length === 0 || filter_select.length === 0 || filter_value.length === 0) {
                $(input_group).addClass("danger");
                submit = false;
            } else {
                $(input_group).removeClass("danger");
                var ob = {
                    field: filter_field.closest("a").data("search_fields"),
                    condition: filter_select.closest("a").data("filter_condition"),
                    value: filter_value
                };
                var join = $(input_group).find(".btn-primary");
                if (join.length > 0) {
                    if (join.hasClass("or_condition")) {
                        ob["join"] = "OR";
                    } else if (join.hasClass("and_condition")) {
                        ob["join"] = "AND";
                    }
                }
                asearch["group_" + i].condition.push(ob);
            }
        });
        if ($(fieldset).find("legend .btn-primary").length !== 0) {
            if ($(fieldset).find("legend .btn-primary").hasClass("group_and_condition")) {
                asearch["group_" + i].join = "AND";
            } else if ($(fieldset).find("legend .btn-primary").hasClass("group_or_condition")) {
                asearch["group_" + i].join = "OR";
            }
        }
    });

    if (submit) {
        $.ajax({
            url: "../classes/" + current_page,
            beforeSend: function () {
                processing(true);
                enableSubmitButton($(".a_search_submit"), false);
            },
            data: {
                operation: "asearch",
                asearch: asearch
            },
            type: "GET",
            success: function (response) {
                var json_ob = parseJSON(response);
                if (json_ob !== false) {
                    destroyModal($("#advanced_search"));
                    displayGUI(json_ob);
                }
            },
            error: function (response) {
                showAJAXError(response);
            }
        });
    } else {
        var json_ob = {
            type: "danger",
            message: "Provide missing information in search conditions"
        };
        showAlert(json_ob);
    }
}

function checkASearchGUI() {
    $("#a_search_form fieldset").each(function (i, fieldset) {
        if ($(fieldset).find(".input-group").length > 1) {
            var total = $(fieldset).find(".input-group").length;
            $(fieldset).find(".input-group").each(function (j, input_group) {
                var remove_button = "<button type='button' class='remove_button btn btn-danger'><i class='fa fa-times'></i></button>";
                var move_up_disabled = "";
                var move_down_disabled = "";
                if (j === 0) {
                    move_up_disabled = "disabled";
                }

                if (j === total - 1) {
                    move_down_disabled = "disabled";
                }

                var move_up_button = "<button " + move_up_disabled + " type='button' class='move_up btn btn-default'><i class='fa fa-arrow-up'></i></button>";
                var move_down_button = "<button " + move_down_disabled + " type='button' class='move_down btn btn-default'><i class='fa fa-arrow-down'></i></button>";

                if ($(input_group).find(".move_down").length === 0) {
                    $(input_group).find(".input-group-btn:first").prepend(move_down_button);
                } else if (j < total - 1) {
                    $(input_group).find(".move_down").prop("disabled", false);
                } else if (j === total - 1) {
                    $(input_group).find(".move_down").prop("disabled", true);
                }

                if ($(input_group).find(".move_up").length === 0) {
                    $(input_group).find(".input-group-btn:first").prepend(move_up_button);
                } else if (j > 0) {
                    $(input_group).find(".move_up").prop("disabled", false);
                } else if (j === 0) {
                    $(input_group).find(".move_up").prop("disabled", true);
                }

                if (j === total - 1) {
                    $(input_group).find(".and_condition").addClass("btn-default").removeClass("btn-primary");
                    $(input_group).find(".or_condition").addClass("btn-default").removeClass("btn-primary");
                } else {
                    if ($(input_group).find(".btn-primary").length === 0) {
                        $(input_group).find(".and_condition").addClass("btn-primary").removeClass("btn-default");
                    }
                }

                if ($(input_group).find(".input-group-btn:last .remove_button").length === 0) {
                    $(input_group).find(".input-group-btn:last").append(remove_button);
                }
            });
        } else {
            $(fieldset).find(".input-group .remove_button").remove();
            $(fieldset).find(".input-group .btn-primary").removeClass("btn-primary").addClass("btn-default");
            $(fieldset).find(".move_up").remove();
            $(fieldset).find(".move_down").remove();
        }

        total = $("#a_search_form fieldset").length;
        if (total > 1) {
            var remove_button = "<button type='button' class='group_remove_button btn btn-danger'><i class='fa fa-times'></i></button>";
            var move_up_disabled = "";
            var move_down_disabled = "";
            if (i === 0) {
                move_up_disabled = "disabled";
            }

            if (i === total - 1) {
                move_down_disabled = "disabled";
            }

            var move_up_button = "<button " + move_up_disabled + " type='button' class='group_move_up btn btn-default'><i class='fa fa-arrow-up'></i></button>";
            var move_down_button = "<button " + move_down_disabled + " type='button' class='group_move_down btn btn-default'><i class='fa fa-arrow-down'></i></button>";

            if ($(fieldset).find(".group_move_down").length === 0) {
                $(fieldset).find("legend .btn:first").before(move_down_button);
            } else if (i < total - 1) {
                $(fieldset).find(".group_move_down").prop("disabled", false);
            } else if (i === total - 1) {
                $(fieldset).find(".group_move_down").prop("disabled", true);
            }

            if ($(fieldset).find(".group_move_up").length === 0) {
                $(fieldset).find("legend .btn:first").before(move_up_button);
            } else if (i > 0) {
                $(fieldset).find(".group_move_up").prop("disabled", false);
            } else if (i === 0) {
                $(fieldset).find(".group_move_up").prop("disabled", true);
            }

            if (i === total - 1) {
                $(fieldset).find(".group_and_condition").addClass("btn-default").removeClass("btn-primary");
                $(fieldset).find(".group_or_condition").addClass("btn-default").removeClass("btn-primary");
            } else {
                if ($(fieldset).find("legend .btn-primary").length === 0) {
                    $(fieldset).find("legend .group_and_condition").addClass("btn-primary").removeClass("btn-default");
                }
            }

            if ($(fieldset).find(".group_remove_button").length === 0) {
                $(fieldset).find("legend .btn:last").after(remove_button);
            }
        }
    });

    if ($("#a_search_form fieldset").length === 1) {
        $("#a_search_form fieldset").find(".group_remove_button").remove();
        $("#a_search_form fieldset").find(".group_move_up").remove();
        $("#a_search_form fieldset").find(".group_move_down").remove();
        $("#a_search_form fieldset").find(".group_and_condition").removeClass("btn-primary").addClass("btn-default");
        $("#a_search_form fieldset").find(".group_or_condition").removeClass("btn-primary").addClass("btn-default");
    }
}

function getCleanedClone(ele) {
    var clone = ele.closest(".input-group").clone();
    clone.find("[data-hide]").attr("data-hide", "hide");
    clone.find(".btn-primary").removeClass("btn-primary").addClass("btn-default");
    clone.find(".filter_field > .btn").text("select field");
    clone.find(".filter_select > .btn").text("select filter");
    clone.find("[data-filter_value]").val("");
    clone.removeClass("danger");
    return clone;
}

function getCleanedGroup() {
    var cloned_fieldset = $("fieldset:first").clone();
    cloned_fieldset.find(".btn-primary").removeClass("btn-primary").addClass("btn-default");
    cloned_fieldset.find(".input-group:not(:first)").remove();
    var clone = cloned_fieldset.find(".input-group:first");
    clone.find("[data-hide]").attr("data-hide", "hide");
    clone.find(".filter_field > .btn").text("select field");
    clone.find(".filter_select > .btn").text("select filter");
    clone.find("[data-filter_value]").val("");
    clone.removeClass("danger");
    return cloned_fieldset;
}