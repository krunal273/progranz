/* global current_page */

function getExtraInfo(extra, value) {
    if (extra.image !== "") {
        return value = "<div class='pop-up' style='position:absolute'><i data-src='" + extra.image + "' class='hidden fa fa-spinner fa-pulse fa-3x fa-fw'></i></div><span class='course_name'>" + value + "</span> <i class='fa fa-picture-o course_small pull-right'></i>";//<img class='thumbnail course_small pull-right' src='" + extra.image + "'> //
    } else {
        return value += "";
    }
}

//$(document).on('shown.bs.modal', '#insertcourse.modal, #editcourse.modal', function () {
//    var typeahead = "<div class='form-group'>" +
//            "<div class='col-sm-12'>" +
//            "<input autofocus='autofocus' autocomplete='off' type='text' data-required='required' class='typeahead form-control text-capitalize col1'  name='col1' placeholder='Add tag' value='' spellcheck='false'>" +
//            "</div>" +
//            "</div>";
//    $("#col3").closest(".form-group").after(typeahead);
//    configTypeahead1();
//});

function configTypeahead1() {
    var ta_items = new Bloodhound({
        datumTokenizer: function (d) {
            var arr = ["name"];
            var filters = [];
            for (var j = 0; j < arr.length; j++) {
                var filter1 = Bloodhound.tokenizers.whitespace(d[arr[j]]);
                $.each(filter1, function (k, v) {
                    i = 0;
                    while ((i + 1) < v.length) {
                        filter1.push(v.substr(i, v.length));
                        i++;
                    }
                });
                filters = filters.concat(filter1);
            }
            return filters;
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: {
            url: '../classes/tag.php?ta&get_tags',
            cache: false
        },
        remote: {
            url: '../classes/tag.php?get_tags=%QUERY&ta',
            wildcard: '%QUERY'
        }
    });

    var typeahead_object1 = {
        hint: true,
        highlight: true,
        minLength: 1
    };

    var typeahead_object2 = {
        limit: 10,
        name: 'items',
        display: 'name',
        displayKey: 'name',
        valueKey: 'id',
        source: ta_items,
        templates: {
            empty: [
                '<div class="empty_message">No item found</div>'
            ].join('\n'),
            suggestion: Handlebars.compile("<div>{{name}}</div>")
        }
    };
    $('.typeahead').typeahead(typeahead_object1, typeahead_object2);
}

$(document).ready(function () {
    $(document).on('mouseover', '.course_small', function (e) {
        var popup = $(this).closest("td").find('div.pop-up');
        popup.show();
        if (popup.find("img").length === 0) {
            var image = "<img class='thumbnail'>";
            popup.append(image);
            var i_tag = popup.find('i');
            i_tag.addClass("hidden");
            var url = i_tag.data("src");
            $.ajax({
                url: url,
                cache: true,
                processData: false
            }).always(function () {
                popup.find('img').attr("src", url);
                popup.show();
            });

        }
    });

    $(document).on('mouseleave', '.course_small', function () {
        $('div.pop-up').hide();
    });

    $(document).on('click', '.rate_course', function () {
        var modal_button = $(this);
        var title = $("#col1").val();
        var message = $("#col2").val();
        var course_id = $(this).data("course_id");
        var rating = $(this).data("rating");
        $.ajax({
            url: "../classes/" + current_page,
            beforeSend: function () {
                processing(true);
            },
            data: {
                rate_course: "",
                title: title,
                message: message,
                course_id: course_id,
                rating: rating
            },
            type: "POST",
            success: function (response) {
                var json_ob = parseJSON(response);
                if (json_ob !== false) {
                    showAlert(json_ob);
                    if (json_ob.type === "success") {
                        destroyModal(modal_button.closest(".modal"));
                        $("[data-course_id=" + course_id + "]").closest(".panel").find(".course_ratings").html(getStar(json_ob.rating));
                    }
                }
            },
            error: function (response) {
                showAJAXError(response);
            }
        });
    });

    $(document).on('click', '.rating', function () {
        var id = $(this).closest(".panel").find("[data-course_id]").data("course_id");
        var rating = $(this).index() + 1;
        var modal = "<div class='modal primary fade' tabindex='-1' role='dialog' id='rating_modal'>" +
                "<div class='modal-dialog' role='document'>" +
                "<div class='modal-content'>" +
                "<div class='modal-header'>" +
                "<h4 class='modal-title'>Course rating</h4>" +
                "</div>" +
                "<div class='modal-body'>" +
                "<form method='post' class='form-horizontal' novalidate='' role='form' >" +
                "<div class='form-group'>" +
                "<label class=' text-capitalize control-label col-sm-3 control-label' for='col1' >" +
                "title</label>" +
                "<div class='col-sm-9'>" +
                "<input autofocus='autofocus' autocomplete='off' type='text' data-required='required' class='form-control ' id='col1' name='col1' placeholder='Enter title' value='' spellcheck='false'>" +
                "</div>" +
                "</div>" +
                "<div class='form-group'>" +
                "<label class=' text-capitalize control-label col-sm-3 control-label' for='col2'>" +
                "review</label>" +
                "<div class='col-sm-9'>" +
                "<textarea autofocus='autofocus' autocomplete='off' data-required='required' class='form-control ' id='col2' name='col2' placeholder='Enter review' value='' spellcheck='false'></textarea>" +
                "</div>" +
                "</div>" +
                "</form>" +
                "</div>" +
                "<div class='modal-footer'>" +
                "<button type='button' class='btn btn-primary rate_course' data-course_id='" + id + "' data-rating='" + rating + "'>Rate</button>" +
                "<button type='button' class='btn btn-default' data-dismiss='modal' data-destroy='modal'>Close</button>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";

        $("#modal_area").append(modal);
        $('#rating_modal').modal({backdrop: 'static', keyboard: false}, 'show');
        $(".modal").draggable({
            handle: ".modal-header"
        });

        if ($(".modal.in").length > 0) {
            var zindex = JSON.parse($(".modal.in:last").css("z-index"));
            $('#rating_modal').css("z-index", zindex + 1);
        }
    });

    $(document).on('mouseover', '.rating', function () {
        var index = $(this).index();

        var parent = $(this).closest(".pull-right");
        parent.find(".rating:lt(" + index + ")").addClass("rating_selected");

        $(this).addClass("rating_selected");

        for (var i = 0; i <= index; i++) {
            if (parent.find(".rating").eq(i).hasClass("fa-star-o")) {
                parent.find(".rating").eq(i).addClass("fa-star").removeClass("fa-star-o").attr("data-revert_icon", "");
            }
        }

    });

    $(document).on('mouseleave', '.rating', function () {
        var parent = $(this).closest(".pull-right");
        parent.find(".rating").removeClass("rating_selected");
        $("[data-revert_icon]").addClass("fa-star-o").removeClass("fa-star");
    });

    $(document).on('mousemove', '.course_small', function (e) {
        var popupHeight = $(this).closest("td").find('div.pop-up').outerHeight(true);
        var offset = $(this).closest("table").offset();
        var relativeX = (e.pageX - offset.left);
        var relativeY = (e.pageY - offset.top);
        if (relativeY + popupHeight > screen.height) {
            relativeY -= popupHeight - 30;
        }
        var popup = $(this).closest("td").find('div.pop-up');
        popup.css('top', relativeY).css('left', relativeX + 30);
    });

});