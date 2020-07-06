/* global current_page, is_mobile */
var validLimit;
var old_value;
function submitForm(form, e) {
    e.preventDefault();
    var add_other = false, is_typeahead = false;
    var preserve = "";
    var is_valid = validateForm(form);
    var operation = "";
    if (form.attr("id").includes("form_insert")) {
        operation = "insert";
    } else if (form.attr("id").includes("form_edit")) {
        operation = "edit";
    }

    var afterFunctionName = false;
    if (!!form.data("after_function") !== false) {
        afterFunctionName = form.data("after_function");
        afterFunctionName = window[afterFunctionName];
    }
    var page = current_page;
    if (!!form.data("select_page") !== false) {
        page = form.data("select_page");
    }
    if (page !== current_page) {
        add_other = true;
        preserve = "&preserve";
    }

    if (form.find("[name=is_typeahead]").length > 0) {
        is_typeahead = form.find("[name=is_typeahead]").val();
    }

    if (is_valid) {
        var ajax_object = {
            url: "../classes/" + page,
            beforeSend: function () {
                processing(true);
            },
            data: form.serialize() + "&operation=" + operation + preserve,
            type: "POST",
            success: function (response) {
                var json_ob = parseJSON(response);
                if (!!afterFunctionName !== false) {
                    if (form.closest(".modal").length === 1) {
                        destroyModal(form.closest(".modal"));
                    }
                    enableSubmitButton(form, true);
                    afterFunctionName(json_ob);
                } else {
                    var this_col = false;
                    var selected = false;
                    if (json_ob !== false) {
                        if (json_ob.type === "success") {
                            var options = "";
                            if (json_ob.hasOwnProperty("add_other")) {

                                if (!is_typeahead) {
                                    this_col = form.find("[name='this_col']").val();
                                    selected = json_ob.add_other.selected;
                                    var field = json_ob.add_other.field;
                                    options += "<option value='-1'>--select " + $(".modal.in:last").find("#" + this_col).closest(".form-group").find("label").text() + "--</option>";
                                    $(json_ob.add_other.data).each(function (index, value) {
                                        options += "<option value='" + value.id + "'>" + value[field] + "</option>";
                                    });
                                } else {
//                                    $.each(json_ob.add_other.data, function(i, v){
//                                        if(JSON.parse(v.id)===JSON.parse(json_ob.add_other.selected)){
//                                            var id = v.id;
//                                            var name = v.name;
//                                        }
//                                    });
                                    configureTypeahead(is_typeahead);
                                }
                            }

                            if (json_ob.hasOwnProperty("gui")) {
                                displayGUI(json_ob.gui);
                            }

                            $("#checkboxes_" + json_ob.id).closest("tr").addClass("animated flash changecolor");
                            if (form.closest(".modal").length === 1 && operation === "edit") {
                                destroyModal(form.closest(".modal"));
                            } else if (form.closest(".modal").length === 1 && operation === "insert") {
                                form.closest(".modal").modal("hide");
                                enableSubmitButton(form, true);
                            }
                            showAlert(json_ob);
                            if (json_ob.hasOwnProperty("add_other")) {

                                if (!is_typeahead) {
                                    var last_modal = $(".modal.in:last");
                                    var default_select = last_modal.find("#" + this_col).find("[data-default]").data("default");
                                    last_modal.find("#" + this_col).html(options);
                                    last_modal.find("#" + this_col + " option[value=" + default_select + "]").attr("data-default", default_select);
                                    last_modal.find("#" + this_col + " option[value=" + selected + "]").prop("selected", true);
                                    last_modal.find("#" + this_col).focus();
                                }

                            }
                        } else if (json_ob.type === "warning") {
                            if (form.closest(".modal").length === 1) {
                                destroyModal(form.closest(".modal"));
                            }
                            enableSubmitButton(form, true);
                            showAlert(json_ob);
                        } else if (json_ob.type === "danger") {
                            enableSubmitButton(form, true);
                            if (json_ob.hasOwnProperty("unique")) {
                                $.each(json_ob.unique, function (index, field) {
                                    showValidation($("#" + field), "error", "This field should be unique");
                                });
                            }
                            showAlert(json_ob);
                        }
                    } else {
                        enableSubmitButton(form, true);
                    }
                }
            },
            error: function (response) {
                showAJAXError(response);
            }
        };

        var data = new FormData(form[0]);
        data.append("operation", operation);
        if ($(".image_preview").length > 0) {
            data.append("cropped_image", $(".image_preview:first").attr("src"));
        }
        if (preserve !== "") {
            data.append("preserve", "");
        }
        ajax_object.data = data;
        ajax_object.cache = false;
        ajax_object.processData = false;
        ajax_object.contentType = false;

        $.ajax(ajax_object);
    }
}

function enableSubmitButton(ele, state) {
    if (state) {
        if (ele.closest(".modal").length > 0) {
            ele = ele.closest(".modal");
        }
        ele.find("button[form]:disabled").find("i").remove();
        ele.find("button[form]:disabled").next("[data-dismiss]:disabled").prop("disabled", false);
        ele.find("button[form]:disabled").prop("disabled", false);
    } else {
        ele.prop("disabled", true);
        ele.next("[data-dismiss]").prop("disabled", true);
        var spinner = " <i class='fa fa-spinner fa-pulse fa-fw'></i>";
        ele.html(ele.text() + spinner);
    }
}

function yesOperation(modal_button) {
    var operation, form = $("#table_form");
    if (modal_button.hasClass("yes_delete")) {
        operation = "delete";
    } else if (modal_button.hasClass("yes_activate")) {
        operation = "activate";
    } else if (modal_button.hasClass("yes_deactivate")) {
        operation = "deactivate";
    } else if (modal_button.hasClass("yes_destroy")) {
        operation = "destroy";
    } else if (modal_button.hasClass("yes_restore")) {
        operation = "restore";
    } else if (modal_button.hasClass("yes_harddelete")) {
        operation = "harddelete";
    }

    $.ajax({
        url: "../classes/" + current_page,
        beforeSend: function () {
            processing(true);
        },
        data: form.serialize() + "&operation=" + operation,
        type: "POST",
        success: function (response) {
            var json_ob = parseJSON(response);
            if (json_ob !== false) {
                if (modal_button.closest(".modal").length === 1) {
                    destroyModal(modal_button.closest(".modal"));
                }
                if (json_ob.type === "success") {
                    displayGUI(json_ob.gui);
                    showAlert(json_ob);
                } else {
                    showAlert(json_ob);
                }
            }
        },
        error: function (response) {
            showAJAXError(response);
        }
    });
}

function searchValidate(form) {
    var start_date = $("#start_date").closest(".date").hasClass("date_selected");
    var end_date = $("#end_date").closest(".date").hasClass("date_selected");
    if (start_date && !end_date) {
        var filters = {
            date_filter: "custom_date"
        };
        getGUI(filters);
    } else if (start_date && end_date) {
        var filters = {
            date_filter: "custom_range"
        };
        getGUI(filters);
    } else {
        if ($("#search").val().trim().length !== 0) {
            var filters = {
                search: $("#search").val().trim()
            };
            getGUI(filters);
        } else {
            $("#search").val("");
            var json_ob = {type: "danger", message: "Please provide search"};
            showAlert(json_ob);
        }
    }
}

function validateForm(form) {
    var elements = form.find("input:visible:not(:disabled),textarea:visible:not(:disabled)");
    var is_valid = true;
    elements.each(function (index, ele) {
        ele = $(ele);
        if (ele.attr("type") === "file") {
            is_valid &= isFileSelected(ele);
        } else {
            ele.val(ele.val().trim());
            if (is_mobile) {
                is_valid &= isNumber(ele);
                is_valid &= mobileIsValidFloat(ele);
            }
            is_valid &= isNotEmpty(ele);
            is_valid &= isValidLength(ele);
            is_valid &= isValidEmail(ele);
            is_valid &= isValidURL(ele);
        }
    });
    elements = form.find("select:visible:not(:disabled)");
    !
            elements.each(function (index, ele) {
                ele = $(ele);
                ele.val(ele.val().trim());
                is_valid &= isSelected(ele);
            });
    if (!is_valid) {
        focusFirstElement();
        enableSubmitButton(form, true);
    }
    return is_valid;
}

function isFileSelected(ele) {
    var validation = !!ele.data("required");
    if (validation !== false) {
        var id = ele.attr("id");
        var preview = $("#" + id + "_preview");

        if (ele.val() === "" && preview.attr("src") === "") {
            showValidation(ele, "error", "Please " + getLabelName(ele).toLowerCase());
            return false;
        } else {
            return true;
        }
    }
    return true;
}

function getLabelName(ele) {
    ele = ele.closest(".form-group").find("label").clone();
    ele.find("span").remove();
    ele = capitalizeFirstLetter(ele.text());
    return ele;
}

function isNotEmpty(ele) {
    var validation = !!ele.data("required");
    if (validation !== false) {
        if (ele.hasClass("typeahead general")) {
            var message = "Please select valid " + getLabelName(ele);
            var id = ele.attr("id").replace("_ta", "");
            if ($("#" + id).val().length === 0) {
                showValidation(ele, "error", message);
                ele.typeahead("val", "");
                return false;
            }
        } else {
            if (ele.attr("type") !== "checkbox" && ele.attr("type") !== "radio") {
                var message = getLabelName(ele) + " can't be empty";
                if (ele.val().length === 0) {
                    showValidation(ele, "error", message);
                    ele.val("");
                    return false;
                }
            } else {
                return true;
            }

        }
    }
    return true;
}

function isValidLength(ele) {
    var min = !!ele.data("min");
    var max = !!ele.data("max");
    var exact = !!ele.data("exact");
    var field_length = ele.val().length;
    if (!!ele.data("required") !== false || ele.val().length > 0) {
        if (min !== false && max === false) {
            if (field_length < JSON.parse(ele.data("min"))) {
                showValidation(ele, "error", "At least " + ele.data("min") + " characters required");
                return false;
            } else {
                return true;
            }
        } else if (min === false && max !== false) {
            if (field_length >= ele.data("max")) {
                showValidation(ele, "error", "Maximum " + ele.data("max") + " characters allowed");
                return false;
            } else {
                return true;
            }
        } else if (min !== false && max !== false) {
            if (field_length >= ele.data("min") && field_length <= ele.data("max")) {
                return true;
            } else {
                showValidation(ele, "error", "Min : " + ele.data("min") + " and Max: " + ele.data("max") + " characters required");
                return false;
            }
        } else if (exact !== false) {
            if (field_length === ele.data("exact")) {
                return true;
            } else {
                showValidation(ele, "error", "Exactly " + ele.data("exact") + " characters required");
                return false;
            }
        }
    }
    return true;
}

function isValidEmail(ele) {
    if (ele.attr("type") === "email") {
        if (ele.val().length > 0) {
            var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
            if (!pattern.test(ele.val())) {
                showValidation(ele, "error", "Please enter valid email address");
                return false;
            }
        } else {
            if (!!ele.data("required") === false) {
                removeValidation(ele, "error");
            }
        }
    }
    return true;
}

function isValidURL(ele) {
    if (ele.attr("type") === "url") {
        if (ele.val().length > 0) {
            var pattern = /^((https?|s?ftp):\/\/)?(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
            if (!pattern.test(ele.val())) {
                showValidation(ele, "error", "Please enter valid website");
                return false;
            }
        } else {
            if (!!ele.data("required") === false) {
                removeValidation(ele, "error");
            }
        }
    }
    return true;
}

function isValidMobile(ele, limit, e) {
    if (isDigit(ele, e)) {
        removeValidation(ele, "error");
        return true;
    } else {
        return false;
    }
}

function isDigit(ele, event) {
    if (allowedKeys(ele, event)) {
        removeValidation(ele, "error");
        return true;
    }
    if (notAllowedKeys(ele, event)) {
        return false;
    }

    event.which = event.keyCode ? event.keyCode : event.which;
    if ((event.which >= 48 && event.which <= 57) || (event.which >= 96 && event.which <= 105)) {
        if (isValidLimit(ele, event)) {
            return true;
        } else {
            return false;
        }
        return true;
    } else {
        return false;
    }
}

function isValidLimit(ele, event) {
    validLimit = true;
    var limit = !!ele.data("limit");
    var isFloat = !!ele.data("before");
    if (limit !== false && isFloat === false) {
        limit = JSON.parse(ele.data("limit"));
        event.which = event.keyCode ? event.keyCode : event.which;
        event.which = event.which <= 57 ? event.which - 48 : event.which - 96;
        var value = ele.val();
        var cursor = ele.getCursorPosition();
        var beforeCursor = value.substring(0, cursor);
        var afterCursor = value.substring(cursor, value.length);
        var newValue = beforeCursor.concat(event.which).concat(afterCursor);
        if (newValue !== "") {
            newValue = JSON.parse(newValue);
        } else {
            newValue = 0;
        }
        if (newValue <= limit) {
            removeValidation(ele, "error");
            return true;
        } else {
            validLimit = false;
            showValidation(ele, "error", "Max allowed value : " + limit);
            return false;
        }

    } else {
        return true;
    }
}

function isValidFloat(ele, event) {
    if (is_mobile) {
        old_value = ele.val();
    } else {
        event.which = event.keyCode ? event.keyCode : event.which;
        if (event.which !== 8 && event.which !== 46) {
            if (allowedKeys(ele, event)) {
                removeValidation(ele, "error");
                return true;
            }
        }

        if (notAllowedKeys(ele, event)) {
            return false;
        }
        var value = ele.val();
        var dotIndex = value.indexOf(".");
        if (dotIndex === -1) {
            dotIndex = value.length;
        }
        var before = JSON.parse(ele.data("before"));
        var after = JSON.parse(ele.data("after"));
        var beforeValue = value.substring(0, dotIndex);
        var afterValue = value.substring(dotIndex + 1, value.length);
        var cursor = ele.getCursorPosition();
        var isValidDot = (ele.val().indexOf(".") === -1 && (event.which === 190 || event.which === 110)) && cursor <= before;
        var format = "";
        for (var i = 0; i < before; i++) {
            format += "X";
        }

        if (after > 0) {
            format += ".";
        }
        for (var i = 0; i < after; i++) {
            format += "X";
        }
        var errorMessage = "Allowed Format : " + format;
        var new_value = value.replace(".", "");
        var validLimit = true;
        var limit = !!ele.data("limit");
        if (limit) {
            limit = ele.data("limit");
            var errorMessage1 = "Max allowed value : " + ele.data("limit");
            var compare_value;
            if (new_value !== "") {
                compare_value = JSON.parse(new_value);
            } else {
                compare_value = 0;
            }
            if (compare_value > limit) {
                validLimit = false;
            }
        }

        if (event.which === 8) {
            if (dotIndex + 1 === cursor) {
                if (new_value.length > before) {
                    showValidation(ele, "error", errorMessage);
                    return false;
                } else {
                    if (validLimit) {
                        removeValidation(ele, "error");
                        return true;
                    } else {
                        showValidation(ele, "error", errorMessage1);
                        return false;
                    }
                }
            } else {
                return true;
            }
        } else if (event.which === 46) {
            if (dotIndex === cursor) {
                if (new_value.length > before) {
                    showValidation(ele, "error", errorMessage);
                    return false;
                } else {
                    if (validLimit) {
                        removeValidation(ele, "error");
                        return true;
                    } else {
                        showValidation(ele, "error", errorMessage1);
                        return false;
                    }
                }
            } else {
                return true;
            }
        }

        if (isValidDot) {
            removeValidation(ele, "error");
            return true;
        } else {
            if (isDigit(ele, event)) {
                var validBefore = cursor <= dotIndex && beforeValue.length < before;
                var validaAfter = cursor > dotIndex && afterValue.length < after;
                var floatLimit = checkFloatLimit(ele, limit, cursor, event, errorMessage1);
                if (cursor <= dotIndex) {
                    if (validBefore) {
                        if (floatLimit) {
                            removeValidation(ele, "error");
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        showValidation(ele, "error", errorMessage);
                        return false;
                    }
                } else if (cursor > dotIndex) {
                    if (validaAfter) {
                        if (floatLimit) {
                            removeValidation(ele, "error");
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        showValidation(ele, "error", errorMessage);
                        return false;
                    }
                } else {
                    showValidation(ele, "error", errorMessage);
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}

function checkFloatLimit(ele, limit, cursor, event, errorMessage1) {
    if (!!ele.data("limit")) {
        var beforeCursor = ele.val().substring(0, cursor);
        var afterCursor = ele.val().substring(cursor, ele.val().length);
        var code = "";
        var newValue;
        if ((event.which >= 48 && event.which <= 57) || (event.which >= 96 && event.which <= 105)) {
            code = event.which <= 57 ? event.which - 48 : event.which - 96;
            newValue = beforeCursor.concat(code).concat(afterCursor);
        } else {
            newValue = beforeCursor.concat(afterCursor);
        }
        if (newValue !== "") {
            newValue = JSON.parse(newValue);
        } else {
            newValue = 0;
        }
        if (newValue > limit) {
            showValidation(ele, "error", errorMessage1);
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function isSelected(ele) {
    var validation = !!ele.data("required");
    var selectedIndex = JSON.parse(ele.find("option:selected").val());
    if (validation !== false && selectedIndex === -1) {
        var message = "Please select " + getLabelName(ele);
        showValidation(ele, "error", message);
        return false;
    }
    return true;
}

function showValidation(ele, type, message) {
    ele.closest(".form-group").addClass("has-" + type);
    var message_span = "<span class='help-block animated fadeIn";
    if (ele.attr("type") === "file") {
        message_span += "'>" + message + "</span>";
        if (ele.closest(".form-group").find(".help-block").length === 0) {
            ele.closest(".form-group").find(".group-span-filestyle").after(message_span);
            ele.attr("data-default", ele.filestyle('buttonName'));
            ele.filestyle('buttonName', 'btn-danger');
        } else {
            ele.closest(".form-group").find(".help-block").html(message);
        }

    } else if (ele.hasClass("typeahead")) {
        message_span += " ta_help-block'>" + message + "</span>";
        if (ele.closest(".form-group").find(".help-block").length === 0) {
            ele.closest(".form-group").find(".twitter-typeahead").after(message_span);
        } else {
            ele.closest(".form-group").find(".help-block").html(message);
        }

    } else {
        if (ele.next(".help-block").length === 0) {
            var message_span = "<span class='help-block animated fadeIn";
            if (ele.is($("select"))) {
                message_span += " help-block-select";
            }
            message_span += "'>" + message + "</span>";

            ele.after(message_span);

        } else {
            ele.next(".help-block").html(message);
        }
    }
}

function removeValidation(ele, type) {
    ele.closest(".form-group").removeClass("has-" + type);
    ele.closest(".form-group").find(".help-block").remove();
    if (ele.attr("type") === "file") {
        ele.filestyle('buttonName', ele.data("default"));
        ele.removeAttr("data-default");
    }
}

function allowedKeys(ele, event) {
    //return true for allowed keys
    event.which = event.keyCode ? event.keyCode : event.which;

    //backspace = 8,
    //tab = 9,
    //enter = 13,
    //esc = 27,
    //page_up = 33
    //page_down = 34
    //end = 35
    //home = 36
    //insert = 45,
    //delete = 46,
    //f5(refresh) = 116,
    //f12(developer options) = 123

    if ($.inArray(event.which, [8, 9, 13, 27, 33, 34, 35, 36, 45, 46, 116, 123]) !== -1 ||
            (event.which === 65 && event.ctrlKey === true) || //ctrl+a
            (event.which === 67 && event.ctrlKey === true) || //ctrl+c
            (event.which === 86 && event.ctrlKey === true) || //ctrl+v
            (event.which === 88 && event.ctrlKey === true) || //ctrl+x
            (event.which >= 37 && event.which <= 40)) { // arrow keys
        removeValidation(ele, "error");
        return true;
    } else {
        return false;
    }
}

function notAllowedKeys(event) {
    //return true for not allowed keys
    event.which = event.keyCode ? event.keyCode : event.which;
    return false;
}

function limitText(ele, limit, e) {
    if (allowedKeys(ele, e)) {
        return true;
    } else if (notAllowedKeys(e)) {
        return false;
    } else if (ele.val().length >= limit) {
        showValidation(ele, "error", "Max " + limit + " characters allowed");
        return false;
    } else {
        return true;
    }
}


function isValidaPaste(ele, limit, e) {
    var data = e.originalEvent.clipboardData.getData('Text');
    var length = data.length + ele.val().length;
    if (length > limit) {
        showValidation(ele, "error", "Max " + limit + " characters allowed");
        return false;
    } else {
        removeValidation(ele, "error");
        return true;
    }
}

(function ($, undefined) {
    $.fn.getCursorPosition = function () {
        var el = $(this).get(0);
        var pos = 0;
        if ('selectionStart' in el) {
            pos = el.selectionStart;
        } else if ('selection' in document) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }
        return pos;
    };
})(jQuery);

function mobileIsValidFloat(ele) {
    var required = !!ele.data("required");
    var value = ele.val();
    if (is_mobile && !!ele.data("float")) {

        if (isNaN(value) && value.length > 0) {
            showValidation(ele, "error", "Invalid characters detected");
            return false;
        } else {
            removeValidation(ele, "error");
        }


        if (required) {
            if (value.length === 0) {
                return false;
            }

            var dotIndex = value.indexOf(".");
            if (dotIndex === -1) {
                dotIndex = value.length;
            }
            var before = JSON.parse(ele.data("before"));
            var after = JSON.parse(ele.data("after"));
            var beforeValue = value.substring(0, dotIndex);
            var afterValue = value.substring(dotIndex + 1, value.length);
            var limit = !!ele.data("limit");
            var format = "";
            for (var i = 0; i < before; i++) {
                format += "X";
            }
            if (after > 0) {
                format += ".";
            }
            for (var i = 0; i < after; i++) {
                format += "X";
            }
            var errorMessage = "Allowed Format : " + format;

            if (beforeValue.length > before || afterValue.length > after) {
                if (limit) {
                    limit = ele.data("limit");
                    var errorMessage1 = "Max allowed value : " + limit;
                    if (value > limit) {
                        showValidation(ele, "error", errorMessage1);
                    } else {
                        showValidation(ele, "error", errorMessage);
                    }
                } else {
                    showValidation(ele, "error", errorMessage);
                }
                return false;
            } else {
                if (limit) {
                    limit = ele.data("limit");
                    var errorMessage1 = "Max allowed value : " + limit;
                    if (value > limit) {
                        showValidation(ele, "error", errorMessage1);
                        return false;
                    } else {
                        removeValidation(ele, "error");
                        return true;
                    }
                } else {
                    removeValidation(ele, "error");
                    return true;
                }
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function isNumber(ele) {
    var type = ele.attr("type");
    if (type === "tel" || type === "number" || !!ele.data("float")) {
        var value = ele.val();
        if (isNaN(value) && value.length > 0) {
            showValidation(ele, "error", "Invalid characters detected");
            return false;
        } else {
            if ((type === "tel" || type === "number") && value.indexOf(".") !== -1) {
                showValidation(ele, "error", "Invalid dot(.) detected");
                return false;
            } else {
                return true;
            }
        }
    } else {
        return true;
    }
}