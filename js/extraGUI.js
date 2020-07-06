function showTabs(json_ob, modal_id) {
    var tab_li = "", tab_content = "";
    var active;
    var submit_button = "";
    if ($("#" + modal_id).length === 0) {
        for (var i = 0; i < json_ob.length; i++) {
            if (json_ob.active_tab === json_ob[i].title) {
                active = "class='active'";
            } else {
                active = "";
            }
            tab_li += "<li " + active + "><a data-color='" + json_ob[i].color + "' data-toggle='tab' href='#" + json_ob[i].title + "'>" + json_ob[i].title + "</a></li>";

            if (json_ob.active_tab === json_ob[i].title) {
                active = " in active ";
            } else {
                active = "";
            }
            tab_content += "<div id='" + json_ob[i].title + "' class='tab-pane fade" + active + "'>";
            json_ob[i].modal_id = json_ob[i].title;
            tab_content += getForm(json_ob[i]);
            tab_content += "</div>";

            if (json_ob.active_tab === json_ob[i].title) {
                submit_button += "<button type='submit' class='btn outline gradient btn-" + json_ob[i].color + " ' form='form_" + json_ob[i].title + "'>" + json_ob[i].title + "</button>";
            }
        }

        var modal = "<div id='" + modal_id + "' class='modal fade' role='dialog'>" +
                "<div class='modal-dialog'>" +
                "<!-- Modal content-->" +
                "<div class='modal-content'>" +
                "<div class='modal-header'>" +
                "<ul class='nav nav-tabs nav-justified'>";

        modal += tab_li;
        modal += "</ul>" +
                "</div>" +
                "<div class='modal-body'>";
        modal += "<div class='tab-content'>";
        modal += tab_content;
        modal += "</div>";
        modal += "</div>" +
                "<div class='modal-footer'>" +
                submit_button +
                "<button type='button' class='btn outline gradient btn-default' data-dismiss='modal'>Cancel</button>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";
        $("#modal_area").append(modal);
    } else {
        setActiveTab($('#' + modal_id), json_ob.active_tab);
    }
    $('#' + modal_id).modal({backdrop: 'static', keyboard: false}, 'show');
    $(".modal").draggable({
        handle: ".modal-header"
    });
}

function setActiveTab(tab_parent, active) {
    tab_parent.find("li").removeClass("active");
    tab_parent.find(".tab-pane").removeClass("active").removeClass("in");
    tab_parent.find("a[href='#" + active + "']").closest("li").addClass("active");
    tab_parent.find(".tab-pane[id=" + active + "]").addClass("active in");
    var color = tab_parent.find("a[href='#" + active + "']").data("color");
    var modal_button = tab_parent.find(".modal-footer").find("button[type=submit]:first");
    modal_button.text(active);
    modal_button.attr("form", "form_" + active);
    modal_button.removeClass("btn-primary");
    modal_button.removeClass("btn-success");
    modal_button.removeClass("btn-info");
    modal_button.removeClass("btn-warning");
    modal_button.removeClass("btn-danger");
    modal_button.addClass("btn-" + color);
}

$(document).ready(function () {
    $(document).on("click", "[data-toggle=tab]", function () {
        resetForm($(this).find(".form"), true);
        var active = $(this).text();
        setActiveTab($(this).closest(".modal"), active);
    });
});