/* global current_page, Bloodhound, Handlebars, ta_objects */
var search = "";
var category = "";
var form_date_fields = {};
var form_typeahead_fields = {};
var pkey;


/* default field options start(Note:Please change value in resetFieldData())*/
var validation = "";
var required = "";
var placeholder = "";
var autofocus = "";
var autocomplete = "autocomplete='off'";
var input_class = "col-sm-9";
var label_class = "col-sm-3 control-label";
var transform = "";
var value = "";
var sort_sequence = [];
/* default field options end*/

var popover_trigger = "hover";
var help = "";
var operations = "table-cell";
var hide = "block";
var search_filter = "";
var header_filter = "";
var multi_filter = {};
var form_data = "";
var date_fields = {};
var datebox = {};
var date_searchbox = "";
var date_tooltip = "";
var date_flag = 0;

//advanced search
var text_filters = ["starts with", "ends with", "equals", "contains", "does not start with", "does not end with", "does not equal to", "does not contain"];
var digit_filters = ["=", ">", ">=", "<", "<=", "not ="];
var text_filters_select = "";
var digit_filters_select = "";
var asearch = "";

function mobileAndTabletcheck() {
    var check = false;
    (function (a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4)))
            check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
}

function showAlert(json_ob) {
    processing(false);
    var alert_data = "<div class='alert alert-" + json_ob.type + "' style='display:none'>" +
            "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>" +
            json_ob.message +
            "</div>";
    $("#message_area").append(alert_data);
    $('.alert').show().animateCss('fadeIn', 'fadeOut', 1500);
}

$.fn.extend({
    animateCss: function (animationName1, animationName2, delay) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        $('.alert').show().addClass('animated ' + animationName1).one(animationEnd, function () {
            $(this).removeClass('animated ' + animationName1);
            setTimeout(function () {
                $('.alert').addClass('animated ' + animationName2).one(animationEnd, function () {
                    $(this).removeClass('animated ' + animationName2).hide();
                    setTimeout(function () {
                        $('.alert').alert('close');
                        focusFirstElement();
                    }, 1);
                });
            }, delay);
        });
    }
});
function showAddEditModal(button) {
    var modal_class = getButtonColor(button);
    var modal_id = button.data("modal");
    var operation = button.text();
    var add_other = false;
    var id = "";
    if (operation === "edit") {
        id = button.closest("tr").find(":checkbox").val();
    }
    var page = current_page, is_typeahead = false;
    if (!!button.data("select") !== false) {
        modal_class = "primary";
        page = button.data("select") + ".php";
        modal_id = "insert" + button.data("select");
        operation = "add";
        add_other = {
            other_page_col: button.data("select_col"),
            this_col: button.closest("span").prev().attr("id")
        };
        if (button.closest(".form-group").find(".typeahead.general").length > 0) {
            is_typeahead = button.closest(".form-group").find(".typeahead.general").attr("id").replace("_ta", "");
        }
    }
    if ($("#" + modal_id).length === 0) {
        $.ajax({
            url: "../classes/" + page,
            beforeSend: function () {
                processing(true);
            },
            data: {
                operation: "form",
                add_edit: operation,
                id: id
            },
            type: "POST",
            success: function (response) {
                var json_ob = parseJSON(response);
                if (json_ob !== false) {
                    json_ob.modal_class = modal_class;
                    json_ob.modal_id = modal_id;
                    json_ob.modal_operation = operation;
                    json_ob.page = page;
                    json_ob.add_other = add_other;
                    json_ob.is_typeahead = is_typeahead;
                    showModal(json_ob);
                }
            },
            error: function (response) {
                showAJAXError(response);
            }
        });
    } else {
        resetForm($('#' + modal_id + '').find("form"), "clear");
        $('#' + modal_id + '').modal({backdrop: 'static', keyboard: false}, 'show');
    }
}

function showOperationModal(modal_button) {
    var modal_class = "", message, modal_operation, checkbox_id = "";
    modal_button.closest("tr").find(":checkbox").prop("checked", true);
    if (modal_button.closest("tr").length > 0) {
        checkbox_id = modal_button.closest("tr").find(":checkbox").attr("id");
    }
    modal_operation = modal_button.text().trim();
    message = "Really want to " + modal_operation + "?";
    if (modal_operation === "logout") {
        modal_class = "danger";
    } else {
        modal_class = getButtonColor(modal_button);
    }

    var json_ob = {};
    json_ob.modal_class = modal_class;
    json_ob.modal_id = "operation_modal";
    json_ob.modal_operation = modal_operation;
    json_ob.message = message;
    json_ob.size = "modal-sm";
    if (checkbox_id !== "") {
        json_ob.checkbox_id = checkbox_id;
    }
    showModal(json_ob);
}

function showModal(json_ob) {
    var edit_operation = "", size = "";
    var modal_header = "", modal_body = "", modal_footer = "";
    if (json_ob.hasOwnProperty("color")) {
        json_ob.modal_class = json_ob.color;
    }

    if (!json_ob.hasOwnProperty("modal_operation")) {
        json_ob.modal_operation = json_ob.title.replace("_", " ");
        json_ob.title = "";
    }

    if (json_ob.modal_operation === "edit") {
        edit_operation = "edit_operation";
    }

    if (json_ob.hasOwnProperty("size")) {
        size = json_ob.size;
    }

    if (json_ob.hasOwnProperty("checkbox_id")) {
        modal_body += "<input type='hidden' id='operation_id' value='" + json_ob.checkbox_id + "'>";
    }

    if (json_ob.hasOwnProperty("fields")) {
        modal_header += "<h4 class='modal-title text-capitalize'>" + json_ob.modal_operation + " " + json_ob.title.replace("_", " ") + "</h4>";

        if (json_ob.fields.hasOwnProperty("pkey")) {
            if (json_ob.fields.pkey.hasOwnProperty("value")) {
                pkey = json_ob.fields.pkey.value;
            }
        }

        modal_body += getForm(json_ob);
        if (json_ob.hasOwnProperty("buttons")) {
            modal_footer += getButtons(json_ob.buttons.buttons, json_ob.modal_id);
        } else {
            modal_footer += "<button type='submit' class='btn btn-" + json_ob.modal_class + " " + edit_operation + "' form='form_" + json_ob.modal_id + "'>" + json_ob.modal_operation + "</button>";
        }
        modal_footer += "<button type='button' class='btn btn-default reset_operation' form='form_" + json_ob.modal_id + "'>reset</button>" +
                "<button type='button' class='btn btn-default cancel_operation' data-dismiss='modal'>Cancel</button>";
    } else {
        modal_header += "<h4 class='modal-title text-capitalize'>Confirm " + json_ob.modal_operation + "</h4>";
        modal_body += json_ob.message;
        modal_footer += "<button type='submit' form='' class='btn btn-" + json_ob.modal_class + " yes_" + json_ob.modal_operation + "'>Yes " + json_ob.modal_operation + "</button>";
        modal_footer += "<button type='button' class='btn btn-default cancel_operation' data-dismiss='modal'>no</button>";
    }
    var modal = "<div id='" + json_ob.modal_id + "' class='modal " + json_ob.modal_class + " fade' role='dialog'>" +
            "<div class='modal-dialog " + size + "'>" +
            "<!-- Modal content-->" +
            "<div class='modal-content'>" +
            "<div class='modal-header'>";
    modal += modal_header;
    modal += "</div>" +
            "<div class='modal-body'>";
    if (json_ob.hasOwnProperty("left_size")) {
        modal += "<div class='row'>";
        modal += "<div class='" + json_ob.left_size + "'>";
        if (json_ob.left_div) {
            modal += "<div id='" + json_ob.left_div + "'></div>";
        }
        if (json_ob.form_position === "left") {
            modal += modal_body;
        }
        modal += "</div>";
        modal += "<div class='" + json_ob.right_size + "'>";
        if (json_ob.right_div) {
            modal += "<div id='" + json_ob.right_div + "'></div>";
        }
        if (json_ob.form_position === "right") {
            modal += modal_body;
        }
        modal += "</div>";
        modal += "</div>";
    } else {
        modal += modal_body;
    }


    modal += "</div><div class='modal-footer'>";
    modal += modal_footer;
    modal += "</div>" +
            "</div>" +
            "</div>" +
            "</div>";
    $("#modal_area").append(modal);

    configureDateTimePicker();
    configureTypeahead(false);

    processing(false);
    $('#' + json_ob.modal_id).modal({backdrop: 'static', keyboard: false}, 'show');
    $(".modal").draggable({
        handle: ".modal-header"
    });

    if ($(".modal.in").length > 0) {
        var zindex = JSON.parse($(".modal.in:last").css("z-index"));
        $('#' + json_ob.modal_id).css("z-index", zindex + 1);
    }

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
}

function configureDateTimePicker() {
    var date_fields_length = Object.keys(form_date_fields).length;
    if (date_fields_length > 0) {
        $.each(form_date_fields, function (key, field_data) {
            var date_config = {
//                inline: true,
                format: field_data.format,
                ignoreReadonly: true,
                showClose: true,
                useCurrent: false,
                toolbarPlacement: 'top',
                viewMode: 'days',
                allowInputToggle: true,
                icons: {
                    time: 'fa fa-hourglass-start',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-map-marker',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove'
                }
            };

            if (!field_data.hasOwnProperty("hideToday")) {
                date_config.showTodayButton = true;
            }

            if (field_data.hasOwnProperty("value")) {
                date_config.defaultDate = field_data.value;
            } else if (!field_data.hasOwnProperty("defaultDate")) {
                date_config.defaultDate = new Date();
            } else {
                date_config.defaultDate = field_data.defaultDate;
            }

            if (field_data.hasOwnProperty("minDate")) {
                date_config.minDate = field_data.minDate;
            }

            if (field_data.hasOwnProperty("maxDate")) {
                date_config.maxDate = field_data.maxDate;
            }

            $("#" + key).datetimepicker(date_config);

        });
    }
}

function configureTypeahead(field_id) {

    var temp_array = form_typeahead_fields;
    if (field_id !== false) {
        temp_array = {};
        temp_array[field_id] = form_typeahead_fields[field_id];
        $("#" + field_id + "_ta.typeahead").typeahead('destroy');
    }
    $.each(temp_array, function (field, field_data) {
        var search_from = field_data.search_from;
        var query_string = field_data.query_string;

        var ta_object = new Bloodhound({
            datumTokenizer: function (d) {
                var filters = [];
                for (var j = 0; j < search_from.length; j++) {
                    var filter = Bloodhound.tokenizers.whitespace(d[search_from[j]]);
                    $.each(filter, function (k, v) {
                        i = 0;
                        while ((i + 1) < v.length) {
                            filter.push(v.substr(i, v.length));
                            i++;
                        }
                    });
                    filters = filters.concat(filter);
                }
                return filters;
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '../classes/' + field_data.page + '.php?' + query_string,
                cache: false
            },
            remote: {
                url: '../classes/' + field_data.page + '.php?' + query_string + '=%QUERY',
                wildcard: '%QUERY'
            }
        });

        var ta_template = "";
        if (field_data.hasOwnProperty("ta_template")) {
            var ta_template_fields = [];
            for (var count = 0; count < field_data.ta_template.length; count++) {
                ta_template_fields[count] = "{{" + field_data.ta_template[count] + "}}";
            }

            ta_template_fields = ta_template_fields.join(", ");
            ta_template = {
                empty: [
                    '<div class="empty_message">No match found</div>'
                ].join('\n'),
                suggestion: Handlebars.compile("<div class='text-capitalize'>" + ta_template_fields + "</div>")
            };
        } else {
            ta_template = ta_objects[field].templates;
        }

        $("#" + field + "_ta.typeahead").typeahead({
            hint: false,
            highlight: false,
            minLength: 1
        }, {
            limit: 25,
            display: field_data.display,
            displayKey: field_data.displayKey,
            valueKey: field_data.valueKey,
            source: ta_object,
            templates: ta_template
        });
    });
}

function focusCancelModalButton(modal) {
    modal.find(".modal-footer").find("button[data-dismiss=modal]:visible:not(:disabled)").focus();
}

function destroyModal(ele) {
    ele.remove();
    $('.modal-backdrop:last').remove();
    if ($(".modal").length === 0) {
        $('body').removeClass('modal-open');
    } else if ($(".modal").length === 1) {
        if ($(".modal").attr("id") === "advanced_search") {
            $('body').removeClass('modal-open');
        }
    }
}

var form_field_data = "";

function getForm(json_ob) {
    var form_container = "", form = "";
    form_field_data = json_ob.fields;
    $.each(json_ob.fields, function (key, value) {
        if (!value.hasOwnProperty("hide_form")) {
            form += getFormField(key, value, json_ob.modal_class);
        }
    });
    if (json_ob.hasOwnProperty("id")) {
        json_ob.modal_id = json_ob.id;
    }

    if (json_ob.hasOwnProperty("afterFunction")) {
        json_ob.afterFunction = "data-after_function='" + json_ob.afterFunction + "'";
    } else {
        json_ob.afterFunction = "";
    }

    var fun_name = json_ob.hasOwnProperty("function") ? "data-function='" + json_ob.function + "'" : "";
    form_container = "<form enctype='multipart/form-data' " + json_ob.afterFunction + " data-select_page='" + json_ob.page + "' method='post' class='form-horizontal' novalidate role='form' " + fun_name + " id='form_" + json_ob.modal_id + "'>";

    if (json_ob.hasOwnProperty("add_other")) {
        if (json_ob.add_other !== false) {
            form_container += "<input name='other_page_col' type='hidden' data-default='" + json_ob.add_other.other_page_col + "' value='" + json_ob.add_other.other_page_col + "'>";
            form_container += "<input name='this_col' type='hidden' data-default='" + json_ob.add_other.this_col + "' value='" + json_ob.add_other.this_col + "'>";
        }

        if (json_ob.is_typeahead !== false) {
            form_container += "<input name='is_typeahead' type='hidden' data-default='" + json_ob.is_typeahead + "' value='" + json_ob.is_typeahead + "'>";
        }
    }

    if (json_ob.modal_operation === "edit")
        form_container += "<input type='hidden' name='id' id='editId' data-default='" + json_ob.fields.pkey.value + "' value='" + json_ob.fields.pkey.value + "'>";
    if (json_ob.hasOwnProperty("buttons")) {
        if (json_ob.buttons.hasOwnProperty("class")) {
            json_ob.buttons.form = "form_" + json_ob.modal_id;
            if (json_ob.buttons.hasOwnProperty("class")) {
                form += "<div class='form-group'>";
                form += "<div class='" + json_ob.buttons.class + "'>";
            }
            form += getButtons(json_ob.buttons.buttons);
            if (json_ob.buttons.hasOwnProperty("class")) {
                form += "</div>";
                form += "</div>";
            }
        }
    }

    form_container += form;
    form_container += "</form>";
    return form_container;
}

function resetForm(form, clear) {
    if(!!form[0] !== false){
        form[0].reset();
    }
    
    $.each(form.find("input"), function (i, ele) {
        removeValidation($(ele), "error");
        if (clear === "clear") {
            $(ele).val("");
        }
        if ($(ele).hasClass("typeahead general")) {
            var id = $(ele).attr("id").replace("_ta", "");

            if ($("#" + id).data("default") === '') {
                $("#" + id).val("");
                $("#" + id + "_selected").val("");
                $("[data-form_group='" + id + "']").addClass("hidden");
                $("[data-ta_form_group='" + id + "']").removeClass("hidden");
            } else {
                $("[data-form_group='" + id + "']").removeClass("hidden");
                $("[data-ta_form_group='" + id + "']").addClass("hidden");
            }
        }
    });
    $.each(form.find("textarea"), function (i, ele) {
        removeValidation($(ele), "error");
        if (clear === "clear") {
            $(ele).val("");
        }
    });
    $.each(form.find("select"), function (i, ele) {
        removeValidation($(ele), "error");
        if ($(ele).find("[data-default]").length > 0) {
            $(ele).val($(ele).find("[data-default]").data("default"));
        }
        if (clear === "clear") {
            $(ele).val("-1");
        }
    });

    $.each(form.find(":file"), function (i, ele) {
        removeValidation($(ele), "error");
        $(ele).filestyle('clear');
        var id = $(ele).attr("id");
        var preview = $("#" + id + "_preview");
        if (preview.length > 0) {
            if (!!preview.data("default") !== false) {
                preview.attr("src", preview.data("default"));
            } else {
                preview.attr("src", "");
                preview.closest(".form-group").addClass("hidden");
            }
        }
    });
    $($("input[type=hidden][data-default]")).each(function (index, value) {
        $(this).val($(this).data("default"));
    });
}

function getFormField(key, field_data, modal_class) {
    var field;
    switch (field_data.type) {
        case "text":
        case "email":
        case "password":
        case "tel":
        case "number":
        case "url":
            field = getTextfield(key, field_data);
            break;
        case "file":
            field = getFilefield(key, field_data);
            break;
        case "typeahead":
            field = getTypeahead(key, field_data);
            break;
        case "hidden":
            field = getHiddenfield(key, field_data);
            break;
        case "checkbox":
        case "radio":
            field = getCheckbox(key, field_data);
            break;
        case "textarea":
            field = getTextarea(key, field_data);
            break;
        case "select":
            field = getSelect(key, field_data, modal_class);
            break;
        case "date":
        case "datetime":
            field = getDatepicker(key, field_data);
            break;
        case "buttons":
            field = getButtons(key, field_data);
            break;
        default :
            field = "";
            break;
    }
    return field;
}

function resetFieldData() {
    validation = "";
    required = "";
    placeholder = "";
    autofocus = "";
    autocomplete = "autocomplete='off'";
    input_class = "col-sm-9";
    label_class = "col-sm-3 control-label";
    transform = "";
    value = "";
    help = "";
}

function setFieldData(key, field_data) {
    resetFieldData();
    var message = "";
    if (field_data.hasOwnProperty("validation")) {
        $.each(field_data.validation, function (data, value) {
            validation += "data-" + data + "='" + value + "' ";
            if (data === "required") {
                required = "<span class='text-danger'>* </span>";
            }
            message = getHelp(data, value);
            if (message !== "") {
                help += message + "<br>";
            }
        });
    }

    message = "";
    if (field_data.hasOwnProperty("type")) {
        switch (field_data.type) {
            case "number":
                message += "Only digits allowed";
                break;
            case "tel":
                message += "Valid 10 digit telephone required";
                break;
            case "email":
                message += "Valid email is requierd";
                break;
            case "url":
                message += "Valid URL/Website address is required";
                break;
        }
    }

    if (message !== "") {
        help = message + "<br>" + help;
    }

    if (help !== "") {
        help = "data-toggle='popover' data-trigger='" + popover_trigger + "' data-html='true' data-content='" + help + "'";
    }


    placeholder = field_data.hasOwnProperty("placeholder") ? field_data.placeholder : "Enter " + field_data.title;
    autofocus = !field_data.hasOwnProperty("autofocus") ? "autofocus='autofocus'" : "";
    autocomplete = field_data.hasOwnProperty("autocomplete") ? "autocomplete='on'" : autocomplete;
    input_class = field_data.hasOwnProperty("input_class") ? field_data.input_class : input_class;
    label_class = field_data.hasOwnProperty("label_class") ? field_data.label_class : label_class;
    value = field_data.hasOwnProperty("value") ? field_data.value : "";
}

function getHiddenfield(key, field_data) {
    var value = field_data.hasOwnProperty("value") ? field_data.value : "";
    var field = "<input name='" + key + "' id='" + key + "' type='" + field_data.type + "' data-default='" + value + "' value='" + value + "'>";
    return field;
}

function getTextfield(key, field_data) {
    setFieldData(key, field_data);
    var field = "<div class='form-group'>" +
            "<label class=' text-capitalize control-label " + label_class + "' for='" + key + "' " + help + " >" + required + field_data.title + "</label>" +
            "<div class='" + input_class + "'>" +
            "<input " + autofocus + " " + autocomplete + " type='" + field_data.type + "' " + validation + " class='form-control " + transform + "' id='" + key + "' name='" + key + "' placeholder='" + placeholder + "' value='" + value + "' spellcheck='false'>" +
            "</div>" +
            "</div>";
    return field;
}

function getFilefield(key, field_data) {
    setFieldData(key, field_data);
    var container = "";
    if (field_data.hasOwnProperty("container")) {
        container += " data-container=" + field_data.container + " ";
    }
    var accept = [];
    if (field_data.hasOwnProperty("allowed_formats")) {
        $.each(field_data.allowed_formats, function (index, value) {
            accept.push("." + value);
        });
    }
    if (accept.length > 0) {
        accept = "accept='" + accept.join(", ") + "'";
    } else {
        accept = "";
    }

    var field = "";
    var hidden = "hidden", data_default = "", src = 'src=""';
    if (value !== "") {
        hidden = "";
        data_default = "data-default = '" + field_data.path + pkey + "/" + field_data.value + "'";
        src = "src = '" + field_data.path + pkey + "/" + field_data.value + "'";
    }

    if (field_data.hasOwnProperty("preview")) {
        if (field_data.preview === "image") {
            field += "<div class='form-group " + hidden + "'>" +
                    "<label class='text-capitalize " + label_class + "' for='" + key + "'>image preview</label>" +
                    "<div class='" + input_class + "'>" +
                    "<img id='" + key + "_preview' " + data_default + " class='image_preview img-thumbnail' " + src + " alt=''/>" +
                    "</div>" +
                    "</div>";
        } else if (field_data.preview === "video") {
            field += "<div class='form-group " + hidden + "'>" +
                    "<label class='text-capitalize " + label_class + "' for='" + key + "'>video preview</label>" +
                    "<div class='" + input_class + "'>" +
                    "<video controls=''><source src='"+field_data.path+form_field_data.course_id.value+"/videos/"+field_data.value+"' type='video/mp4'></video>" +
                    "</div>" +
                    "</div>";
        }

    }
    field += "<div class='form-group'>" +
            "<label class=' text-capitalize " + label_class + "' for='" + key + "' " + help + " >" + required + field_data.title + "</label>" +
            "<div class='" + input_class + "'>" +
            "<input " + container + accept + " data-buttontext='' data-placeholder='" + field_data.title + "' " + autofocus + " " + autocomplete + " value='" + value + "' type='" + field_data.type + "' " + validation + " class='form-control " + transform + "' id='" + key + "' name='" + key + "' placeholder='" + placeholder + "' value='" + value + "' spellcheck='false'>" +
            "</div>" +
            "</div>";
    return field;
}

function getCheckbox(key, field_data) {
    setFieldData(key, field_data);
    var field = "<div class='form-group'>" +
            "<label for='' class='text-capitalize " + label_class + " ' " + help + ">" + required + field_data.title + "</label>" +
            "<div class='" + input_class + "'>";
    var inline = field_data.hasOwnProperty("inline") ? field_data.type + "-inline" : "";
    var i = 0;
    var color = "primary";
    $.each(field_data.options, function (key1, value) {
        var checked = "";
        if (field_data.hasOwnProperty("value")) {
            color = "warning";
            checked = value.value === field_data.value ? "checked" : "";
        } else {
            checked = value.hasOwnProperty("checked") ? "checked" : "";
        }

        field += "<div class='" + field_data.type + " " + color + " " + inline + "'>" +
                "<input id='" + key + "_" + i + "' name='" + key + "' value='" + value.value + "' autofocus='' type='" + field_data.type + "' " + validation + " " + checked + ">" +
                "<label for='" + key + "_" + i + "' class='text-capitalize'>" + value.title +
                "</label>" +
                "</div>";
        i++;
    });
    field += "</div>" +
            "</div>";
    return field;
}

function getTextarea(key, field_data) {
    var same_as = "", same_as_compare = "", color = 'primary';

    if (field_data.hasOwnProperty("value")) {
        color = "warning";
    }

    if (field_data.hasOwnProperty("same_as")) {
        same_as += "<div class='checkbox " + color + " inlilne'>" +
                "<input data-same_as='" + field_data.same_as + "' id='same_as_" + key + "' autofocus='' type='checkbox'>" +
                "<label for='same_as_" + key + "' class='same_as text-capitalize'>same as " + field_data.same_as_text +
                "</label>" +
                "</div>";
    }

    if (field_data.hasOwnProperty("same_as_compare")) {
        same_as_compare = " data-same_as_compare='" + field_data.same_as_compare + "' ";
    }

    setFieldData(key, field_data);

    var field = "<div class='form-group'>" +
            "<label class='autoExpand  text-capitalize " + label_class + "' for='" + key + "' " + help + ">" + required + field_data.title + same_as + "</label>" +
            "<div class='" + input_class + "'>" +
            "<textarea rows='5' " + same_as_compare + " data-min-rows='5' " + autofocus + " " + autocomplete + " type='" + field_data.type + "' " + validation + " class='form-control " + transform + "' id='" + key + "' name='" + key + "' placeholder='" + placeholder + "' spellcheck='false'>" + value + "</textarea>" +
            "</div>" +
            "</div>";
    return field;
}

function getSelect(key, field_data, modal_class) {
    setFieldData(key, field_data);
    var page = field_data.hasOwnProperty("page") ? "data-select=" + field_data.page : "";
    var page_col = field_data.hasOwnProperty("page_col") ? "data-select_col=" + field_data.page_col : "";
    var extra_class = "";
    if (page_col !== "") {
        extra_class += " input-group padding_lr_15";
    }

    var field = "", hide = "";
    if (field_data.hasOwnProperty("sub_type")) {
        if (field_data.hasOwnProperty("value")) {
            hide = "hidden";
        }
        placeholder = "search " + field_data.title;
        form_typeahead_fields[key] = field_data;
        field += "<div class='form-group " + hide + "' data-ta_form_group='" + key + "'>" +
                "<label class='text-capitalize control-label " + label_class + "' for='" + key + "_ta' " + help + " >" + required + field_data.title + "</label>" +
                "<div class='" + input_class + " " + extra_class + "'>" +
                "<input type='text' form='dummy_form' " + validation + " class='typeahead general form-control text-capitalize' id='" + key + "_ta' placeholder='" + placeholder + "' spellcheck='false'>";

    } else {

        field += "<div class='form-group'>" +
                "<label class=' text-capitalize " + label_class + "' for='" + key + "' " + help + ">" + required + field_data.title + "</label>" +
                "<div class='" + input_class + extra_class + "'>" +
                "<select " + autofocus + " " + validation + " class='text-capitalize form-control' id='" + key + "' name='" + key + "' value='" + value + "' spellcheck='false'>" +
                "<option value='-1'>--select " + field_data.title + "--</option>";

        if (field_data.hasOwnProperty('select_data')) {
            var select_length = field_data.select_data.length, selected_index = -1;
            if (field_data.hasOwnProperty("value")) {
                selected_index = field_data.value;
            }
            for (var i = 0; i < select_length; i++) {
                var selected = selected_index === field_data.select_data[i].id ? "selected data-default='" + field_data.select_data[i].id + "'" : "";
                field += "<option " + selected + " value='" + field_data.select_data[i].id + "'>" + field_data.select_data[i].name + "</option>";
            }
        }

        field += "</select>";
    }

    if (page_col !== "") {
        field += "<span class='input-group-btn'>" +
                "<button type='button' class='btn btn-" + modal_class + "' " + page + " " + page_col + ">" +
                "<i class='fa fa-plus'></i>" +
                "</button>" +
                "</span>";
    }

    field += "</div>" +
            "</div>";
    if (field_data.hasOwnProperty("sub_type")) {
        var val = "", val_name = "", hide = "hidden";
        if (field_data.hasOwnProperty("value")) {
            val = field_data.value;
            val_name = field_data.value_name;
            hide = "";
        }

        field += "<input type='hidden' value='" + val + "' name='" + key + "' id='" + key + "' data-default='" + val + "'>";
        field += "<div class='form-group " + hide + "' data-form_group='" + key + "'>" +
                "<label class='text-capitalize control-label " + label_class + "' for='" + key + "_ta' " + help + " >" + required + field_data.title + "</label>" +
                "<div class='" + input_class + " input-group padding_lr_15'>" +
                "<input readonly " + autofocus + " " + autocomplete + " type='text' class='form-control text-capitalize" + transform + "' id='" + key + "_selected' placeholder='Selected " + field_data.title + "' value='" + val_name + "'  data-default='" + val_name + "' spellcheck='false'>" +
                "<span class='input-group-btn'>" +
                "<button type='button' class='btn btn-" + modal_class + "' data-reset_ta='" + key + "'>" +
                "<i class='fa fa-pencil'></i>" +
                "</button>" +
                "</span>" +
                "</div>" +
                "</div>";
    }

    return field;
}

function getDatepicker(key, field_data) {
    form_date_fields[key] = field_data;
    setFieldData(key, field_data);
    var field = "<div class='form-group'>" +
            "<label class=' text-capitalize " + label_class + "' for='" + key + "' " + help + ">" + required + field_data.title + "</label>" +
            "<div class='" + input_class + "'>" +
            "<div class='input-group date' id='" + key + "'>" +
            "<input type='text' readonly class='text-center form-control' name='" + key + "'/>" +
            "<span class='input-group-addon'>" +
            "<span class='fa fa-calendar'></span>" +
            "</span>" +
            "</div>" +
            "</div>" +
            "</div>";
    return field;
}

function getButtons(json_ob, modal_id = "") {
    var buttons = "";
    $(json_ob).each(function (key, value) {
        if (modal_id !== "") {
            value.form = modal_id;
        }
        if (!value.hasOwnProperty("disabled")) {
            value.disabled = "";
            if (value.hasOwnProperty("class")) {
                value.class += " wait";
            } else {
                value.class = "wait";
            }
        }
        buttons += getButton(value);
    });
    return buttons;
}

function getButton(json_ob) {
    var form = json_ob.hasOwnProperty("form") ? "form='form_" + json_ob.form + "'" : "";
    var data = "";
    if (json_ob.hasOwnProperty("data")) {
        $(json_ob.data).each(function (index, value) {
            $(json_ob.data).each(function (index, value) {
                data += "data-" + value.title + "='" + value.value + "' ";
            });
        });
    }

    var disabled = json_ob.hasOwnProperty("disabled") ? "disabled " : "";
    var type = json_ob.hasOwnProperty("type") ? json_ob.type : "button";
    var btn_class = json_ob.hasOwnProperty("class") ? json_ob.class : "";
    var size = json_ob.hasOwnProperty("size") ? json_ob.size : "";
    var color = json_ob.hasOwnProperty("color") ? json_ob.color : "default";
    var visibility = json_ob.hasOwnProperty("visibility") ? json_ob.visibility : "";
    var span_class = json_ob.hasOwnProperty("span_class") ? json_ob.span_class : "";
    var icon = "", icon_class = "";
    if (json_ob.hasOwnProperty("icon")) {
        if (json_ob.hasOwnProperty("icon_class")) {
            icon_class = json_ob.icon_class;
        }
        icon = "<i class='fa fa-" + json_ob.icon + " " + icon_class + "'></i>";
    }
    return "<button " + disabled + " " + data + " type='" + type + "' " + form + " class='btn btn-" + color + " " + btn_class + " " + size + "'><span class='" + visibility + " " + span_class + "'>" + json_ob.title + "</span>" + icon + "</button>";
}

function getButtonColor(button) {
    if (button.hasClass("btn-primary"))
        return "primary";
    else if (button.hasClass("btn-success"))
        return "success";
    else if (button.hasClass("btn-warning"))
        return "warning";
    else if (button.hasClass("btn-info"))
        return "info";
    else if (button.hasClass("btn-danger"))
        return "danger";
    else if (button.hasClass("btn-deactivated"))
        return "deactivated";
    else if (button.hasClass("btn-destroyed"))
        return "destroyed";
    else if (button.hasClass("btn-harddelete"))
        return "harddelete";
    else if (button.hasClass("btn-default"))
        return "";
}

function setButtonGroupRadius() {
    $(".categories_btn_group .btn:visible:first").css("border-top-left-radius", "4px").css("border-bottom-left-radius", "4px");
    $(".categories_btn_group .btn:visible:last").css("border-top-right-radius", "4px").css("border-bottom-right-radius", "4px");
    $(".categories_btn_group .btn:visible:not(:last):not(:first)").css("border-top-right-radius", "0px").css("border-bottom-right-radius", "0px");
}

function getGUI(filters) {
    var data = "";
    if (filters.hasOwnProperty("date_filter")) {
        data = $("#searchbox").serialize() + "&operation=gui&date_filter=" + filters.date_filter;
    } else {
        if (filters !== "") {
            filters = JSON.stringify(filters);
        }
        data = {
            operation: "gui",
            filters: filters
        };
    }

    if ($('#start_date').length > 0) {
        $('#start_date').data("DateTimePicker").destroy();
        $('#end_date').data("DateTimePicker").destroy();
    }

    $.ajax({
        url: "../classes/" + current_page,
        beforeSend: function () {
            processing(true);
        },
        data: data,
        type: "GET",
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

function displayGUI(json_ob) {
    console.log(json_ob);
    $("#main_container").empty();
    search_filter = json_ob.search_filter;
    header_filter = json_ob.header_filter;
    form_data = json_ob.form_data;
    asearch = json_ob.hasOwnProperty("asearch") ? json_ob.asearch : "";
    if (json_ob.hasOwnProperty("datebox")) {
        datebox = json_ob.datebox;
    } else {
        datebox = {};
    }

    hide = json_ob.hide;
    operations = json_ob.table.operations;
    printTaskbars(json_ob.taskbars);

    if (Object.keys(datebox).length > 0) {
        $("#date_dropdown").tooltip('hide')
                .attr('title', date_tooltip)
                .attr('data-original-title', date_tooltip)
                .tooltip('fixTitle');
    }
    dateConfiguration();
    printTable(json_ob.table);
    if (json_ob.hasOwnProperty("pagination")) {
        printPagination(json_ob.pagination);
    }
    prepareAdvancedSearch();
    $(".wait").removeAttr("disabled").removeClass("wait");
    setButtonGroupRadius();
    checkTopBottom();
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
    focusFirstElement();
}

function printTaskbars(json_ob) {
    var taskbars = "<div class='row categories' style='display:" + hide + "'>";
    taskbars += printLeftTaskbar(json_ob.left_taskbar);
    taskbars += printRightTaskbar(json_ob.right_taskbar);
    taskbars += "</div>";
    $("#main_container").append(taskbars);
}

function printLeftTaskbar(json_ob) {
    var left_taskbar = "<div class='no_print " + json_ob.col_width + "'>";
    left_taskbar += "<div class='btn-group categories_btn_group'>";
    var btn_class = operations === "none" ? "default" : "harddelete";
    var categories = getCategories(json_ob.categories);
    var per_page = getPerPage(json_ob.per_page);
    var buttons = getButtons(json_ob.operations);
    if (categories !== "" && per_page !== "" && buttons !== "") {
        left_taskbar += "<button id='operations' type='button' class='btn btn-" + btn_class + "' title='toggle operations' data-toggle='tooltip' data-container='body'><i class='fa fa-wrench'></i></button>";
    }

//    left_taskbar += "<button id='sort_sequence' type='button' class='btn btn-default' title='change sort sequence' data-toggle='tooltip' data-container='body'><i class='fa fa-sort'></i></button>";
    left_taskbar += categories;
    left_taskbar += per_page;
    left_taskbar += buttons;
    left_taskbar += "</div>";
    left_taskbar += "</div>";
    return left_taskbar;
}

function printRightTaskbar(json_ob) {
    var right_taskbar = "<div class='no_print " + json_ob.col_width + "'>";
    right_taskbar += getSearchbox(json_ob.searchbox);
    right_taskbar += "</div>";
    return right_taskbar;
}

function getCategories(json_ob) {
    var categories = "", badge, selected = "", categories_li = "", default_selected;
    var count = 0;
    if (!!json_ob !== false) {
        $(json_ob).each(function (key, value) {
            badge = " <span class='badge'>" + value.count + "</span>";
            if (value.hasOwnProperty("selected")) {
                category = value.title;
                selected += "<button disabled id='categories' class='wait btn btn-" + value.color + " dropdown-toggle' type='button' data-toggle='dropdown'>" +
                        value.title + badge +
                        " <span class='caret'></span></button>";
                default_selected = "<button disabled class='wait btn btn-" + value.color + "'>" + value.title + badge + "</button>";
            } else {
                var data;
                if (value.hasOwnProperty("data")) {
                    data = getData(value.data);
                }
                categories_li += "<li><a href='#' " + data + ">" + value.title + badge + "</a></li>";
            }
            count++;
        });

        if (count > 1) {
            categories += "<div class='btn-group'>" + selected +
                    "<ul class='dropdown-menu'>";
            categories += categories_li;
            categories += "</ul>" +
                    "</div>";
        } else {
            categories += default_selected;
        }
    }
    return categories;
}

function getPerPage(json_ob) {
    var per_page = "", per_page_li = "", selected = "";
    $(json_ob).each(function (key, value) {
        if (value.hasOwnProperty("selected")) {
            selected = "<button id='per_page' class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown'>" +
                    value.title +
                    " <i class='fa fa-reorder'></i></button>";
        } else {
            var data;
            if (value.hasOwnProperty("data")) {
                data = getData(value.data);
            }
            per_page_li += "<li><a href='#' " + data + ">" + value.title + "</a></li>";
        }
    });
    per_page += "<div class='btn-group'>" + selected +
            "<ul class='dropdown-menu per_page'>";
    per_page += per_page_li;
    per_page += "</ul>" +
            "</div>";
    return per_page;
}

function getSearchbox(json_ob) {
    var searchbox, remove_search = "", date_search = "", filters = "", filters_left = "", count = 0, total = 0;
    var filter_color, filter_icon_color, search_filter_button = "";
    var simple = false;
    if (json_ob.hasOwnProperty("simple")) {
        simple = true;
    }
    //decide search filters
    if (Object.keys(search_filter).length > 1 && !simple) {
        $.each(search_filter, function (index, field) {
            if (!field.hasOwnProperty("not_show")) {
                if (field.hasOwnProperty("selected")) {
                    filters += field.name + "<br>";
                    count++;
                } else {
                    filters_left += field.name + "<br>";
                }
                total++;
            }
        });

        filters = filters_left === "" ? filters : filters + "<hr>" + filters_left;

        if (total === count) {
            filter_color = "default";
            filter_icon_color = "#000";
        } else {
            filter_color = "danger";
            filter_icon_color = "#FFF";
        }
        search_filter_button = "<button disabled class='wait btn btn-" + filter_color + "' data-filter='search' type='button' title='" + filters + "' data-html=true data-placement=left data-toggle='tooltip' data-container=body ><i class='fa fa-filter' style='color:" + filter_icon_color + "'></i></button>";
    }
    //set date tooltips and store date fields array
    var count = 0, tooltip = "", tooltip_left = "";
    $.each(form_data.fields, function (field, field_array) {
        var is_searchable = true;
        if (search_filter.hasOwnProperty(field)) {
            if (!search_filter[field].hasOwnProperty("selected")) {
                is_searchable = false;
            }
        }
        if (!field_array.hasOwnProperty("hide_table") && is_searchable) {
            if (field_array.hasOwnProperty("type")) {
                if ((field_array.type === "date" || field_array.type === "datetime") && !field_array.hasOwnProperty("not_searchable")) {
                    date_fields[field] = field_array; // store date field array in global date_fields object
                    if (Object.keys(datebox).length > 0) {
                        if (datebox.hasOwnProperty(field)) {
                            tooltip += field_array.title + "<br>";
                        } else {
                            tooltip_left += field_array.title + "<br>";
                        }
                    } else {
                        tooltip += field_array.title + "<br>";
                    }
                    count++;
                }
            }
        }
    });

    tooltip = date_tooltip = tooltip_left !== "" ? tooltip + "<hr>" + tooltip_left : tooltip;
    if (date_searchbox === "") {
        date_search = date_searchbox = getDateSearch(count, tooltip);
    } else {
        date_search = date_searchbox;
    }

    search = "";
    var search_function = "searchValidate", remove_search_data = "data-remove_search";
    if (simple) {
        search_function = "searchValidateSimple";
        remove_search_data = "data-remove_search_simple";
    }
    if (json_ob.search !== '') {
        remove_search = "<button disabled class='wait btn btn-danger' type='button' "+remove_search_data+"=''><i class='fa fa-times'></i></button>";
        search = json_ob.search;
    }

    searchbox = "<form data-function='" + search_function + "' id='searchbox' action='#' method='GET'>" +
            "<div class='input-group'>" + // input-group-sm
            "<input type='search' disabled id='search' name='search' value='" + json_ob.search + "' placeholder='Enter text to search' class='wait form-control'>" +
            "<div class='input-group-btn'>" +
            remove_search +
            "<button disabled class='wait btn btn-default' type='submit'><i class='fa fa-search'></i></button>";

    if (!simple) {
        searchbox += search_filter_button +
                date_search;
    }


    var asearch_color = asearch === "" ? "default" : "danger";

    if (!simple) {
        searchbox += "<button disabled class='wait btn btn-" + asearch_color + "' type='button' data-a_search='search' title='advanced search' data-toggle='tooltip' data-container=body data-html=true data-placement=left><i class='fa fa-cog'></i></button>";
    }
    searchbox += "</div>" +
            "</div>" +
            "</form>";
    return searchbox;
}

function getDateSearch(count, tooltip) {
    var fields = "";
    if (count > 0) {
        $.each(date_fields, function (field, field_array) {
//            if (count > 1) {
            fields += "<div class='checkbox primary'>" +
                    "<input class='date_checkbox' id='date-search_" + field + "' name='date_fields[]' value='" + field + "' autofocus='' type='checkbox' checked>" +
                    "<label for='date-search_" + field + "' class='text-capitalize'>" +
                    "<strong>" + field_array.title + "</strong>" +
                    "</label>" +
                    "</div>";
//            } else {
//                fields += "<div class='date_field text-center text-capitalize'><strong>" + field_array.title + "</strong></div>";
//            }
        });

        var date_buttons = "";
        var date_filters = ["custom range", "today", "yesterday", "this week", "last week", "this month", "last month", "this year"];
        for (i = 0; i < date_filters.length; i++) {
            var date_class = date_filters[i].replace(" ", "_");
            var button = {
                title: date_filters[i],
                data: {
                    title: "date",
                    value: date_class
                }
            };

            date_buttons += getButton(button);
        }

        var end_date_show = "none";

        if (Object.keys(date_fields).length > 0) {
            $.each(date_fields, function (key, filter) {
                if (filter.hasOwnProperty("custom_range")) {
                    end_date_show = "table";
                }
            });
        }

        var date_search = "<div id='date_dropdown' class='btn-group' title='" + tooltip + "' data-toggle='tooltip' data-html=true data-placement=left>" +
                "<button disabled class='wait btn btn-default dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" +
                "<i class='fa fa-calendar'></i>" +
                "</button>" +
                "<ul id='date_search' class='dropdown-menu pull-right'>" +
                "<li>" +
                "<div class='row'>" +
                "<div class='col-xs-12'>" +
                fields + // checkboxes
                "<div class='input-group date'>" +
                "<input type='text' class=' form-control text-center text-uppercase' id='start_date' name='start_date' readonly='' autocomplete='off' autofocus=''>" +
                "<label for='start_date' class='input-group-addon'>" +
                "<span class='fa fa-calendar'></span>" +
                "</label>" +
                "</div>" +
                "<div class='input-group date' style='display : " + end_date_show + "'>" +
                "<input type='text' class=' form-control text-center text-uppercase' id='end_date' name='end_date' readonly='' autocomplete='off' autofocus=''>" +
                "<label for='end_date' class='input-group-addon'>" +
                "<span class='fa fa-calendar'></span>" +
                "</label>" +
                "</div>" +
                "<div class='date_tags'>" +
                date_buttons + // date buttons
                "</div>" +
                "</div>" +
                "</div>" +
                "</li>" +
                "</ul>" +
                "</div>";
    }
    return date_search;
}

function printTable(json_ob) {
    if (json_ob.hasOwnProperty("sort")) {
        sort_sequence = json_ob.sort;
    }

    var table = "<div class='row'>" +
            "<div class='" + json_ob.col_width + "'>";
    if (json_ob.hasOwnProperty("header")) {
        table += "<form id='table_form'>" +
                "<div class='table-responsive'>" +
                "<table class='table table-bordered'>";
        table += getTableHeader(json_ob);
        table += getTableBody(json_ob);
        table += "</table>" +
                "</div>" +
                "</form>";
    } else {
        table += "<div class='well well-sm text-danger'><strong>No records found</strong></div>";
    }

    table += "</div>";
    table += "</div>";
    $("#main_container").append(table);
}

function getTableHeader(table_ob) {
    var filter_color, filter_icon_color, filters = "", filters_left = "", count = 0, total = 0;
    var th_filter = "<th>#</th>";
    //finding selected and non-selected header filters
    if (Object.keys(header_filter).length > 1) {
        $.each(header_filter, function (index, field) {
            if (field.hasOwnProperty("selected")) {
                filters += field.name + "<br>";
                count++;
            } else {
                filters_left += field.name + "<br>";
            }
            total++;
        });

        filters = filters_left === "" ? filters : filters + "<hr>" + filters_left;
        var filter_class = "";
        if (total === count) {
            filter_color = "#fff";
            filter_icon_color = "#000";
            filter_class = 'text-primary';
        } else {
            filter_color = "#d9534f";
            filter_icon_color = "#FFF";
            filter_class = 'text-danger';
        }
        th_filter = "<th disabled class='wait sr_no' data-container=body data-filter='header' data-placement=right data-toggle='tooltip' data-html=true title='" + filters + "'>" + //style='background-color:" + filter_color + "' 
                "<button type='button' class='btn btn-link'>" + //style='color: " + filter_icon_color + "'
                "<i class='fa fa-filter " + filter_class + "'></i><span class='print_only'>#</span>" +
                "</button>" +
                "</th>";
    }
    var json_ob = table_ob.header;
    var table_header =
            "<thead>" +
            "<tr>" +
            th_filter;
    if (table_ob.body.operations > 0) {
        var hidden = category === "total" ? "hidden" : "";
        table_header +=
                "<th class='custom_checkbox " + hidden + "' style='display:" + operations + "'>" +
                "<div class='checkbox primary'><input disabled class='wait' type='checkbox' id='all'><label for='all'></label></div>" +
                "</th>" +
                "<th class='operations' style='display:" + operations + "'>operations</th>";
    }

    $(json_ob).each(function (key, value) {
        var sequence_no = "";
        var icon = value.hasOwnProperty("icon") ? " <i class='" + value.icon + "'></i>" : "";
        var data = "", remove_sort = "", multi = "", remove_filter = "";
        var th_class = "";
        if (value.hasOwnProperty("class")) {
            th_class = value.class;
        }

        if (value.hasOwnProperty("filter")) {
            if (value.filter.length > 1) {
                var multi_values = "";
                var multi_values_left = "";
                var count = 0;
                multi_filter[value.field] = value.filter;
                $(value.filter).each(function (index, field) {
                    if (field.hasOwnProperty("selected")) {
                        count++;
                        multi_values += capitalizeFirstLetter(field.name) + "<br>";
                    } else {
                        multi_values_left += capitalizeFirstLetter(field.name) + "<br>";
                    }
                });
                if (multi_values_left !== "") {
                    multi_values += "<hr>" + multi_values_left;
                }

                var multi_filter_icon = " <i class='fa fa-filter text-primary'></i>";
                if (count === value.filter.length) {
                    remove_filter = "";
//                multi_values = "all";//+"<br>" + multi_values;
                } else {
                    multi_filter_icon = " <i class='fa fa-filter text-danger'></i>";
                    remove_filter = " <i class='fa fa-times-rectangle text-danger'></i>";
                    remove_filter = " <button disabled type='button' class='wait btn btn-link' data-remove_filter='multi' data-field='" + value.field + "' data-html=true data-toggle='tooltip' title='remove filter'>" + remove_filter + "</button>";
                }
                multi += "<button disabled type='button' class='wait btn btn-link' data-filter='multi' data-placement=left data-field='" + value.field + "' data-html=true data-toggle='tooltip' title='" + multi_values + "'>" + multi_filter_icon + "</button>";
            }
        }

        if (value.hasOwnProperty("sort")) {
            data = "data-sort='" + value.sort.sort + "' ";
            data += "data-order='" + value.sort.order + "'";
            if (value.hasOwnProperty("remove")) {
                sequence_no = "<span class='badge sort_sequence no_print'>" + (sort_sequence.indexOf(value.sort.sort) + 1) + "</span>";
                remove_sort += " <button type='button' class='wait btn btn-link' data-remove_sort='" + value.sort.sort + "' data-toggle='tooltip' title='cancel sorting'> " + sequence_no + "</button>";//<i class='fa fa-times-circle text-danger'></i>
            }
        }
        table_header += "<th><a class='wait " + th_class + "' href='#' " + data + ">" + value.title + icon + "</a> " + remove_sort + multi + remove_filter + "</th>";
    });
    table_header += "</tr>";
    table_header += "</thead>";
    return table_header;
}

function getTableBody(table_ob) {
    var json_ob = table_ob.body;
    var row = "";
    var start = JSON.parse(json_ob.start_sr_no);
    var hidden = category === "total" ? "hidden" : "";
    $(json_ob.row).each(function (key, value) {
        var tr_class = value.tr_class !== "" ? "class='" + value.tr_class + "'" : "";
        row += "<tr " + tr_class + ">";
        row += "<td class='sr_no'>" + start + "</td>";
        if (table_ob.body.operations > 0) {
            if (value.operations.length > 0) {
                row += "<td style='display:" + operations + "' class='checkboxes custom_checkbox " + hidden + "'>" +
                        "<div class='checkbox primary'>" +
                        "<input disabled class='wait' type='checkbox' name=ids[] id='checkboxes_" + value.id + "' value='" + value.id + "'/>" +
                        "<label for='checkboxes_" + value.id + "'></label>" +
                        "</div>" +
                        "</td>";
            } else {
                row += "<td style='display:" + operations + "'></td>";
            }
            row += "<td class='operations' style='display:" + operations + "'>";
            row += getButtons(value.operations);
            row += "</td>";
        }
        $(value.col).each(function (key, cols) {
            cols.value = cols.value.replace("<","&lt;");
            cols.value = cols.value.replace(">","&gt;");
            if (search !== "" && search_filter.hasOwnProperty(cols.field)) {
                if (search_filter[cols.field].hasOwnProperty("selected")) {
                    search = search.toLowerCase();
                    var regEx = new RegExp(search, "ig");
                    var replaceWith = "<mark>" + search + "</mark>";
                    cols.value = cols.value.replace(regEx, replaceWith);
                }
            }
            if (cols.value !== "") {
                cols.value = cols.value.replace("\n", "<br>");
            }

            if (cols.hasOwnProperty("extra")) {
                if (cols.extra !== "") {
                    cols.value = getExtraInfo(cols.extra, cols.value);
                }
            }
            row += "<td class='" + cols.align + " " + cols.transform + "'>" + cols.value + "</td>";
        });
        row += "</tr>";
        start++;
    });
    return row;
}

function getData(json_ob) {
    var data = "";
    $(json_ob).each(function (key, value) {
        data += "data-" + value.title + "='" + value.value + "'";
    });
    return data;
}

function printPagination(json_ob) {
    json_ob.start = JSON.parse(json_ob.start);
    json_ob.end = JSON.parse(json_ob.end);
    json_ob.current_page = JSON.parse(json_ob.current_page);
    var pagination = "<div class='row no_print'>";
    pagination += "<div class='col-md-12'>";
    pagination += "<ul class='pagination'>";
    pagination += "<li><a style='background-color:#FFF;'>Pages <span class='badge'>" + json_ob.total_pages + "</span></a></li>";
    if (json_ob.current_page !== 0) {
        pagination += "<li><a id='first' href='#' data-page='0'>first</a></li>";
    }

    if (json_ob.start !== 0) {
        pagination += "<li><a id='previous_set' data-toggle='tooltip' title='Go to previous set of pages' href='#' data-page='" + (json_ob.start - 1) + "'><i class='fa fa-angle-double-left'></i></a></li>";
    }

    if (json_ob.current_page !== 0) {
        pagination += "<li><a id='previous_page' data-toggle='tooltip' title='Go to previous page' href='#' data-page='" + (json_ob.current_page - 1) + "'><i class='fa fa-angle-left'></i></a></li>";
    }

    for (var i = json_ob.start; i < json_ob.end; i++) {
        var active = json_ob.current_page === i ? " class='active'" : "";
        var data = json_ob.current_page !== i ? " data-page='" + i + "'" : "";
        pagination += "<li " + active + "><a href='#' " + data + ">" + (i + 1) + "</a></li>";
    }

    if (json_ob.current_page !== (json_ob.total_pages - 1)) {
        pagination += "<li><a id='next_page' data-toggle='tooltip' title='Go to next page' href='#' data-page='" + (json_ob.current_page + 1) + "'><i class='fa fa-angle-right'></i></a></li>";
    }
    if (json_ob.end < json_ob.total_pages) {
        pagination += "<li><a id='next_set' data-toggle='tooltip' title='Go to next set of pages' href='#' data-page='" + json_ob.end + "'><i class='fa fa-angle-double-right'></i></a></li>";
    }

    if (json_ob.current_page !== json_ob.total_pages - 1) {
        pagination += "<li><a id='last' href='#' data-page='" + (json_ob.total_pages - 1) + "'>last</a></li>";
    }
    pagination += "</ul>";
    pagination += "</div>";
    pagination += "</div>";
    $("#main_container").append(pagination);
}

function getHelp(data, value) {
    switch (data) {
        case "min":
            return "Minimum " + value + " characters required";
            break;
        case "max":
            return "Maximum " + value + " characters allowed";
            break;
        case "exactly":
            return "Exactly " + value + " characters required";
            break;
        case "required":
            return "This field is compulsory";
            break;
        default :
            return "";
            break;
    }
}

function openSelectionBox(field) {
    var json_ob = {};
    var filter, field_name = "";
    switch (field.data("filter")) {
        case "multi":
            filter = "multi";
            field_name = field.closest("th").find("a").text();
            field = field.data("field");
            json_ob.filter = multi_filter[field];
            break;
        case "header":
            filter = field_name = "header";
            field = "";
            json_ob.filter = header_filter;
            break;
        case "search":
            filter = field_name = "search";
            field = "";
            json_ob.filter = search_filter;
            break;
    }

    json_ob.field = field;
    json_ob.field_name = field_name;
    json_ob.filername = filter;

    json_ob.field_name = "Filter : " + json_ob.field_name;

    var filter_box = "";
    var values = "", selected;
    var count = 0, total = 0;

    $.each(json_ob.filter, function (index, ele) {
        if (!ele.hasOwnProperty("not_show")) {
            selected = "";
            if (ele.hasOwnProperty("selected")) {
                selected = "checked";
                count++;
            }
            total++;
            values += "<div class='checkbox primary'>" +
                    "<input type='checkbox' name='" + json_ob.filername + "[]' id='" + json_ob.filername + "_" + ele.id + "' value='" + ele.id + "' " + selected + ">" +
                    "<label class='text-capitalize' for='" + json_ob.filername + "_" + ele.id + "'>" + ele.name +
                    "</label>" +
                    "</div>";
        }
    });
    selected = count === total ? "checked" : "";
    values = "<div class='checkbox primary'>" +
            "<input type='checkbox' data-select_all='filter_all' id='" + json_ob.filername + "_all' " + selected + ">" +
            "<label class='text-capitalize' for='" + json_ob.filername + "_all'><strong>select all</strong>" +
            "</label>" +
            "</div><hr>" + values;
    filter_box += "<div class='modal primary fade' id='filter_select' tabindex='-1' role='dialog'>" +
            "<div class='modal-dialog modal-sm' role='document'>" +
            "<div class='modal-content'>" +
            "<div class='modal-header'>" +
            "<h4 class='modal-title'>" + json_ob.field_name + "</h4>" +
            "</div>" +
            "<div class='modal-body'>" +
            "<form id='" + json_ob.filername + "_form' data-function='validateFilter'>" +
            values +
            "</form></div>" +
            "<div class='modal-footer'>" +
            "<button type='submit' form='" + json_ob.filername + "_form' class='btn btn-primary' data-apply='" + json_ob.field + "'>Apply</button>" +
            "<button type='button' class='btn btn-default' data-dismiss='modal' data-destroy='destroy'>Close</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";

    if ($("#filter_select").length === 0) {
        $("#modal_area").append(filter_box);
    } else {
        $("#filter_select").replaceWith(filter_box);
    }

    $('#filter_select').modal({backdrop: 'static', keyboard: false}, 'show');
    $(".modal").draggable({
        handle: ".modal-header"
    });
}

function prepareAdvancedSearch() {

    var group_buttons = "<div class='btn-group btn-group-xs external_group'>" +
            "<button type='button' class='btn btn-default group_and_condition'>AND</button>" +
            "<button type='button' class='btn btn-default group_or_condition'>OR</button>" +
            "</div>";

    var move_up_down = "<div class='input-group-btn'>";

    var and_or = "<button type='button' class='btn btn-default and_condition'>AND</button>" +
            "<button type='button' class='btn btn-default or_condition'>OR</button>" +
            "</div>";

    var search_input = "<input data-filter_value='' autofocus='autofocus' autocomplete='off' type='text' class='form-control' placeholder='Enter value' value='' spellcheck='false'>";
    var search_fields = "";

    search_fields += "<div class='btn-group filter_field'>" +
            "<button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" +
            "select field" +
            "</button>" +
            "<ul id='search_fields' class='dropdown-menu'>";

    $.each(form_data.fields, function (field, field_array) {
        if (!field_array.hasOwnProperty("hide_table")) {
            if (field_array.type !== "date" && field_array.type !== "datetime") {
                search_fields += "<li><a href='#' data-search_fields='" + field + "'><i class='fa fa-check-circle' data-hide=hide></i> " +
                        field_array.title +
                        "</a></li>";
            }
        }
    });

    search_fields += "</ul></div>";

    if (text_filters_select === "") {

        text_filters_select += "<div class='btn-group filter_select' data-filter_type='text'>" +
                "<button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" +
                "select filter" +
                "</button>" +
                "<ul class='dropdown-menu'>";

        for (var i = 0; i < text_filters.length; i++) {
            text_filters_select += "<li><a href='#' data-filter_condition='" + text_filters[i] + "'><i class='fa fa-check-circle' data-hide=hide></i> " + text_filters[i] + "</a></li>";
        }

        text_filters_select += "</ul></div>";
    }

    if (digit_filters_select === "") {

        digit_filters_select += "<div class='btn-group filter_select'  data-filter_type='digit'>" +
                "<button class='btn btn-default dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" +
                "select filter" +
                "</button>" +
                "<ul class='dropdown-menu'>";

        for (var i = 0; i < digit_filters.length; i++) {
            digit_filters_select += "<li><a href='#' data-filter_condition='" + digit_filters[i] + "'><i class='fa fa-check-circle' data-hide=hide></i> " + digit_filters[i] + "</a></li>";
        }

        digit_filters_select += "</ul></div>";
    }

    var remove_asearch = "";
    var a_search_conditions = "<fieldset>" +
            "<legend>" + group_buttons + "</legend>" +
            "<div class='input-group'>" + move_up_down + search_fields + text_filters_select + "</div>" + search_input + "<div class='input-group-btn'>" + and_or + "</div>" +
            "</fieldset>";

    var search_tooltip = "";

    if (asearch !== "") {
        a_search_conditions = "";
        remove_asearch = "<button type='button' data-remove_asearch='asearch' class='text-center btn btn-danger'>remove search</button>";

        $.each(asearch, function (i, group) {
            var group_join = $(group_buttons);
            if (group.join !== "") {
                if (group.join.toLowerCase() === "or") {
                    group_join.find(".group_or_condition").addClass("btn-primary").removeClass("btn-default");
                } else if (group.join.toLowerCase() === "and") {
                    group_join.find(".group_and_condition").addClass("btn-primary").removeClass("btn-default");
                }
            }
            a_search_conditions += "<fieldset>" +
                    "<legend><div class='btn-group btn-group-xs external_group'>" + group_join.html() + "</div></legend>";
            search_tooltip += "(";
            $.each(group.condition, function (j, condition) {
                var temp = "<div class='input-group'>" + move_up_down + search_fields + text_filters_select + "</div>" + search_input + "<div class='input-group-btn'>" + and_or + "</div>";
                temp = $(temp);
                var field = temp.find("[data-search_fields=" + condition.field + "]");
                field.find("i").attr("data-hide", "show");
                field.closest(".btn-group").find(".btn").text(form_data.fields[condition.field].title);
                var filter_select = temp.find(".filter_select");
                var type = form_data.fields[condition.field]["type"];
                if (type === "tel" || type === "number") {
                    if (filter_select.data("filter_type") !== "digit") {
                        filter_select.replaceWith(digit_filters_select);
                    }
                }
                filter_select = temp.find(".filter_select");
                filter_select.find("[data-filter_condition='" + condition.condition + "'] i").attr("data-hide", "show");
                filter_select.closest(".btn-group").find(".btn").text(condition.condition);
                temp.find("[data-filter_value]").attr("value", condition.value);
                var join = "";
                if (condition.hasOwnProperty("join")) {
                    if (condition.join.toLowerCase() === "or") {
                        join = " OR <br>";
                        temp.find(".or_condition").addClass("btn-primary").removeClass("btn-default");
                    } else {
                        join = " AND <br>";
                        temp.find(".and_condition").addClass("btn-primary").removeClass("btn-default");
                    }
                }
                a_search_conditions += "<div class='input-group'>" + temp.html() + "</div>";
                search_tooltip += form_data.fields[condition.field].title + " <span class='text-lowercase'>" + condition.condition.toLowerCase() + "</span> ' <span class='text-lowercase'>" + condition.value.toLowerCase() + "</span> '" + join;
            });
            search_tooltip += ")";
            if (group.join !== "") {
                search_tooltip += "<br>" + group.join.toUpperCase() + "<br>";
            }
            a_search_conditions += "</fieldset>";
        });

        $("[data-a_search]").tooltip('hide')
                .attr('title', search_tooltip)
                .attr('data-original-title', search_tooltip)
                .tooltip('fixTitle');

    }

    var search_box = "";
    search_box += "<div class='modal primary fade' id='advanced_search' tabindex='-1' role='dialog'>" +
            "<div class='modal-dialog modal-lg' role='document'>" +
            "<div class='modal-content'>" +
            "<div class='modal-header'>" +
            "<h4 class='modal-title'>Advanced Search</h4>" +
            "</div>" +
            "<div class='modal-body'>" +
            "<form id='a_search_form'>" +
            a_search_conditions +
            "</form>" +
            "</div>" +
            "<div class='modal-footer'>" +
            "<button type='button' form='a_search_form' class='a_search_submit btn btn-primary'>Search</button>" +
            remove_asearch +
            "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";
    if ($("#advanced_search").length === 0) {
        $("#modal_area").append(search_box);
    } else {
        $("#advanced_search").replaceWith(search_box);
    }
}

function openAdvancedSearch() {
    checkASearchGUI();
    $('#advanced_search').modal({backdrop: 'static', keyboard: false}, 'show');
    $(".modal").draggable({
        handle: ".modal-header"
    });
}

function dateConfiguration() {
    if (Object.keys(date_fields).length > 0) {
        var start_date = "", end_date = "";
        if (Object.keys(datebox).length > 0) {
            $(".date_checkbox").prop("checked", false);
            $("#date_dropdown>.btn").removeClass("btn-default").addClass("btn-danger");
            $("[data-date").addClass("btn-default").removeClass("btn-danger");
            $.each(datebox, function (key, filter) {
                if (filter.hasOwnProperty("start_date")) {
                    start_date = filter.start_date;
                }
                if (filter.hasOwnProperty("end_date")) {
                    end_date = filter.end_date;
                }
                $(".date_checkbox#date-search_" + key).prop("checked", true);
                $("[data-date=" + filter.date_filter + "]").addClass("btn-danger").removeClass("btn-default");
                if (filter.date_filter === "custom_date") {
                    $("#start_date").closest(".date").addClass("danger date_selected");
                    $("#end_date").closest(".date").css("display", "none").removeClass("danger date_selected");
                } else if (filter.date_filter === "custom_range") {
                    $("#start_date").closest(".date").addClass("danger date_selected");
                    $("#end_date").closest(".date").css("display", "table").addClass("danger date_selected");
                } else {
                    $("#start_date").closest(".date").removeClass("danger date_selected");
                    $("#end_date").closest(".date").removeClass("danger date_selected");
                }
            });
            if ($("[data-date=remove_search]").length === 0) {
                var remove_date_search = "<button data-date='remove_search' type='button' class='btn btn-danger'>remove date search</button>";
                $(".date_tags").append(remove_date_search);
            }
        } else {
            $("#date_dropdown>.btn").removeClass("btn-danger").addClass("btn-default");
        }

        var today = new Date();
        var set_date = new Date();
        today.setDate(today.getDate() + 1);
        var icons = {
            time: 'fa fa-time',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'fa fa-map-marker',
            clear: 'fa fa-trash',
            close: 'fa fa-remove'
        };
        var date_settings = {
            format: 'DD-MM-Y',
            ignoreReadonly: true,
            showClose: true,
            maxDate: today,
            showTodayButton: true,
            useCurrent: true,
            defaultDate: set_date,
            disabledDates: [today],
            toolbarPlacement: 'top',
            icons: icons
        };
        if (start_date !== "") {
            date_settings.defaultDate = start_date;
        }
        if ($('#start_date').length === 1) {
            $('#start_date').datetimepicker(date_settings);
        }

        date_settings.useCurrent = false;
        if (end_date !== "") {
            date_settings.defaultDate = end_date;
        } else {
            date_settings.defaultDate = set_date;
        }
        if ($('#end_date').length === 1) {
            $('#end_date').datetimepicker(date_settings);
        }

        $(document).on("dp.change", "#start_date", function (e) {
            if (!!$('#end_date').data("DateTimePicker") !== false) {
                $('#end_date').data("DateTimePicker").minDate(e.date);
            }
        });
        $(document).on("dp.change", "#end_date", function (e) {
            if (!!$('#start_date').data("DateTimePicker") !== false) {
                $('#start_date').data("DateTimePicker").maxDate(e.date);
            }
        });
    }
}

function openHelpModal() {
    $.ajax({
        url: "../security/shortcuts.txt",
        dataType: "text",
        success: function (data) {
            var lines = data.split('\n');
            var pre_help = "";
            for (var i = 0; i < lines.length; i++) {
                var help = lines[i].split(':');

                if (pre_help === help[0]) {
                    help[0] = "&nbsp;&nbsp;:&nbsp;&nbsp;";
                } else {
                    pre_help = help[0];
                    help[0] = help[0] + "&nbsp;&nbsp;:&nbsp;&nbsp;";
                }
                lines[i] = "<div class='form-group'>" +
                        "<label class='text-capitalize text-right col-sm-4'>" + help[0] + "</label>" +
                        "<div class='col-sm-8'>" + help[1] + "</div>" +
                        "</div>";
            }
            //var htmlLines = '<p>' + lines.join('</p><p>') + '</p>';
            var htmlLines = lines.join("");
            htmlLines = "<form class='form-horizontal' role='form'>" + htmlLines + "</form>";

            var help_modal = "<div id='help_modal' class='modal fade' role='dialog'>" +
                    "<div class='modal-dialog '>" +
                    "<div class='modal-content'>" +
                    "<div class='modal-header'>" +
                    "<h4 class='modal-title text-capitalize'>shortcuts</h4>" +
                    "</div>" +
                    "<div class='modal-body'>" +
                    htmlLines +
                    "</div>" +
                    "<div class='modal-footer'>" +
                    "<button type='button' class='btn btn-default cancel_operation' data-dismiss='modal' data-destroy='modal'>close</button>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>";

            $("#modal_area").append(help_modal);

            processing(false);
            $('#help_modal').modal({backdrop: 'static', keyboard: false}, 'show');
            $(".modal").draggable({
                handle: ".modal-header"
            });

            if ($(".modal.in").length > 0) {
                var zindex = JSON.parse($(".modal.in:last").css("z-index"));
                $('#help_modal').css("z-index", zindex + 1);
            }

            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
        }
    });
}
