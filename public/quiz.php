<?php
include_once '../includes/config.php';
include_once '../includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="../css/cropper.min.css" rel="stylesheet"/>
        <?php include_once '../includes/head.php'; ?>
        <?php
        include_once '../includes/css.php';

//        if (isset($_GET['admin'])) 
        {
            ?>

            <style>

                .image_operations .btn{
                    margin-right: 0px !important;
                }

                .image_operations{
                    margin-top: 15px;
                }

                .pop-up {
                    display: none;
                    position: absolute;
                    height: 200px !important;
                    width: 200px !important;
                    z-index:1032;
                }

                .pop-up .thumbnail{                    
                    width: 200px !important;
                    margin-bottom: 0px;
                    -webkit-box-shadow: 0px 1px 8px 2px rgba(136,136,138,1);
                    -moz-box-shadow: 0px 1px 8px 2px rgba(136,136,138,1);
                    box-shadow: 0px 1px 8px 2px rgba(136,136,138,1);
                }

                .course_small{
                    height: 20px;
                    width: 20px;
                    display: inline;
                    vertical-align: middle;
                    margin-bottom: 0px;
                    padding: 0px;
                    float: right;
                    line-height: 20px;
                    cursor: pointer;
                }
                .course_name{
                    line-height: 20px;
                }

                blockquote{
                    border-left: 5px solid #464596;
                }
                .h h2{
                    text-align: center;
                }
                .inline {
                    display: inline;
                }
                .panel-heading i{
                    padding-right: 5px;
                }
                .panel-footer i{
                    position: relative;
                    top: 5px;
                    padding-right: 5px;
                }
                .panel-footer a{
                    text-decoration: none;
                    color: black;
                    font-weight: 300;
                }

                .panel-body img{
                    height: 200px;
                    width: 100%;
                }

                .typeahead_tags{
                    margin-top: 20px;
                    margin-bottom: 20px;
                }

                .twitter-typeahead{
                    display: inline !important;
                }

                .search{
                    min-height: 80px;
                    border: 1px solid rgb(51, 122, 183);
                    border-radius: 4px;
                }

                #searcharea{
                    padding: 5px !important;
                }

                i{
                    padding-left:4px;
                }

                .btn{
                    /*margin: 2px 3px;*/
                }

                .tt-query {
                    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                }

                .tt-hint {
                    color: #999
                }

                .tt-menu {    
                    margin-top: 4px;
                    padding: 4px 0;
                    background-color: #fff;
                    border: 1px solid #ccc;
                    border: 1px solid rgba(0, 0, 0, 0.2);
                    -webkit-border-radius: 4px;
                    -moz-border-radius: 4px;
                    border-radius: 4px;
                    -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
                    -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
                    box-shadow: 0 5px 10px rgba(0,0,0,.2);
                }

                .tt-suggestion {
                    padding: 3px 20px;
                    line-height: 24px;
                }

                .tt-suggestion.tt-cursor,.tt-suggestion:hover {
                    color: #fff;
                    background-color: #0097cf;

                }

                .tt-suggestion p {
                    margin: 0;
                }

                .rating_selected{
                    color: red !important;
                }

                .rating{
                    cursor: pointer;
                }


            </style>
            <?php
        }
        ?>
    </head>
    <body>
        <?php
        include_once '../includes/menu_top.php';
        if (!isset($_GET['admin'])) {
            ?>
            <div class="container" id="main_container">
                <div class='row'  id='quiz'>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="container-fluid" id="main_container"></div>
            <?php
        }
        ?>


        <?php include_once '../includes/js.php'; ?>
        <script src="../js/cropper.min.js" type="text/javascript"></script>    
        <script src="../js/courses.js" type="text/javascript"></script>    

        <script>

            var page = 0;
            $(document).ready(function () {

<?php
if (!isset($_GET['admin'])) {
    ?>
                    getDetailedQuiz("");

                    $(document).on("click", "[data-remove_search_simple]", function () {
                        var filters = {
                            remove_search: $(this).data("remove_search_simple")
                        };
                        getDetailedQuiz(filters);
                    });

<?php } else {
    ?>
                    getGUI("");
<?php }
?>
            });

            function getDetailedQuiz(filters, page) {

                var is_searched = filters.hasOwnProperty("search") || filters.hasOwnProperty("remove_search");
                if (filters !== "") {
                    filters = JSON.stringify(filters);
                }

                $.ajax({
                    url: "../classes/" + current_page,
                    beforeSend: function () {
                        processing(true);
                    },
                    data: {
                        operation: "gui",
                        filters: filters
                    },
                    type: "GET",
                    success: function (response) {
                        var json_ob = parseJSON(response);
                        if (json_ob !== false) {
                            json_ob.is_searched = is_searched;
                            printQuiz(json_ob);
                        }
                    },
                    error: function (response) {
                        showAJAXError(response);
                    }
                });
            }

            function printQuiz(json_ob) {
//                console.log(json_ob);
                search_filter = json_ob.search_filter;
                hide = json_ob.hide;
                operations = json_ob.table.operations;
                json_ob.taskbars.right_taskbar.col_width = "col-md-11";
                json_ob.taskbars.right_taskbar.searchbox.simple = true;
                var searchbox = "<div class='searchbox row'>" + printRightTaskbar(json_ob.taskbars.right_taskbar) + "<div class='col-md-1'><button class='btn btn-primary grid_operation'><i class='fa fa-th'></i></button></div></div>";

                if ($(".searchbox").length === 0) {
                    $("#quiz").before(searchbox);
                } else {
                    $(".searchbox").replaceWith(searchbox);
                }

                $(".wait").removeAttr("disabled").removeClass("wait");

                var quiz = "";
                if (json_ob.table.hasOwnProperty("body")) {
                    var table_body = json_ob.table.body;
                    quiz += "<div class='table-responsive'>";
                    quiz += "<table class='table table-bordered'>";
                    quiz += "<thead><tr><th class='sr_no'>#</th><th>Quiz</th><th class='sr_no'>Time</th><th class='sr_no'></th></tr></thead>";

                    quiz += "<tbody>";
                    for (var i = 0; i < table_body.row.length; i++) {
                        var id = table_body.row[i].id;
                        var title = table_body.row[i].col[0].value;
                        var time = table_body.row[i].col[1].value;
                        quiz += "<tr><td class='sr_no'>" + (i + 1) + "</td><td>" + title + "</td><td class='sr_no'>" + time + "</td><td><button type='button' data-id='"+id+"' class='btn btn-primary start_quiz btn-xs'>start</button></td></tr>";
                    }
                    quiz += "</tbody>";
                    quiz += "</table></div>";
                }
                quiz += "</div>";

                quiz = "<div class='col-md-8'>" + quiz + "</div>";

                $("#quiz").html(quiz);


//                if (json_ob.hasOwnProperty("pagination")) {
//                    var current_page = JSON.parse(json_ob.pagination.current_page);
//                    var total_pages = JSON.parse(json_ob.pagination.total_pages);
//
//                    if (current_page !== total_pages - 1) {
//                        var pagination = "<div><button class='btn btn-primary btn-sm text-center'  data-more_course='" + (current_page + 1) + "'>Load More</button></div>";
//                        if ($("[data-more_course]").length === 0) {
//                            $("#courses").after(pagination);
//                        } else {
//                            $("[data-more_course]").replaceWith(pagination);
//                        }
//                    } else {
//                        $("[data-more_course]").remove();
//                    }
//                } else {
//                    $("[data-more_course]").remove();
//                }
            }

            function getStar(rating) {
                var star = "";
                var limit_low = Math.floor(rating);
                var limit_upper = Math.ceil(rating);

                for (var i = 1; i <= limit_low; i++) {
                    star += "<i class='fa fa-star rating' aria-hidden='true'></i>";
                }

                for (var i = limit_low + 1; i <= limit_upper; i++) {
                    star += "<i class='fa fa-star-half rating' aria-hidden='true'></i>";
                }

                for (var i = limit_upper + 1; i <= 5; i++) {
                    star += "<i class='fa fa-star-o rating' aria-hidden='true'></i>";
                }
//                "<i class='pull-right fa fa-star-o' aria-hidden='true'></i>" +
//                            "<i class='pull-right fa fa-star-half' aria-hidden='true'></i>" +
                return star;
            }

            var tags = new Bloodhound({
                datumTokenizer: function (data) {
                    var filter = Bloodhound.tokenizers.whitespace(data.name);
                    $.each(filter, function (k, v) {
                        i = 0;
                        while ((i + 1) < v.length) {
                            filter.push(v.substr(i, v.length));
                            i++;
                        }
                    });
                    return filter;
                },
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: {
                    url: '../classes/tag.php?get_tags',
                    cache: false
                },
//            remote: {
//                url: '../classes/tag.php?get_tags=%QUERY',
//                wildcard: '%QUERY'
//            }
            });

            tags.clearPrefetchCache();
            tags.initialize(true);

            $('#tags .typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                limit: 25,
                name: 'tags',
                display: 'name',
                displayKey: 'name',
                valueKey: 'id',
                source: tags,
                templates: {
                    empty: [
                        '<div class="empty-message">No Tag Found</div>'
                    ].join('\n'),
                    suggestion: Handlebars.compile("<div class='text-capitalize'>{{name}}</div>")
                }
            });

            $('#tags .typeahead').typeahead('val', "");

            $('#tags .typeahead').on('typeahead:select', function (evt, item) {
                var button = "<button id='" + item.id + "' type='button' class='tag_button btn btn-info btn-xs text-capitalize'>" + item.name + "<i class='fa fa-close'></i></button>";
                if ($("#" + item.id).length === 0) {
                    $("#searcharea").append(button);
                }
                checkClear();
                $('#tags .typeahead').typeahead('val', "");
                getDetailedCourse("");
            });

            function checkClear() {
                if ($(".tag_button").length !== 0) {
                    if ($(".clear_tag_button").length === 0) {
                        var button = "<button type='button' class='clear_tag_button btn btn-danger btn-xs text-capitalize'>clear all</button>";
                        $("#searcharea").prepend(button);
                    }
                } else {
                    $(".clear_tag_button").remove();
                }
            }

            function searchValidateSimple() {
                if ($("#search").val().trim().length !== 0) {
                    var filters = {
                        search: $("#search").val().trim()
                    };
                    getDetailedCourse(filters, page);
                } else {
                    $("#search").val("");
                    var json_ob = {type: "danger", message: "Please provide search"};
                    showAlert(json_ob);
                }
            }

            $(document).on("click", ".grid_operation", function () {
                if (window.location.search === "") {
                    window.location.href = window.location.pathname + "?admin";
                } else {
                    window.location.href = window.location.href.substr(0, window.location.href.indexOf("?"));
                }

            });

            $(document).on("click", ".start_quiz", function () {
                var page = $(location).attr('href').split("?")[0];
                page = page.split("/");
                page = page[page.length - 1];
                page = page.replace("#", "");
                var id = $(this).attr("data-id");
                window.location.href = $(location).attr('href').replace(page,"start_quiz.php?id="+id);
            });
        </script>
    </body>
</html>