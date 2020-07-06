$(document).ready(function () {

    /*vertical menu bar toggle start*/
    /*left arrow click start*/
    $(".arrow-left").on('click', function () {
        $(".col-md-2.col-lg-2.col-sm-3.pricing-table-container").hide('slow');
        $(".arrow-right").show('slow'); //show right arrow when right  arrow click
    });
    /*left arrow click end*/

    /*right arrow click start*/
    $(".arrow-right").on('click', function () {
        $(".col-md-2.col-lg-2.col-sm-3.pricing-table-container").show('slow');
        $(this).hide('slow'); //hide right arrow when right  arrow click
    });

    /*collapse button click start*/
    $("button.navbar-toggle").on('click', function () {
        $("nav.navbar").css("z-index", "1");
        $(".arrow-left").click();
    });
    /*collapse button click end*/
    /*vertical menu bar toggle end*/



    /*arrow left click start*/
    $(".arrow-left").on('click', function () {
        $("#id-for-addclass").removeClass('col-md-10 col-lg-10 col-sm-9').addClass('col-md-12 col-lg-12 col-sm-12');
    });
    /*arrow left click end*/
    /*arrow right click start*/
    $(".arrow-right").on('click', function () {
        $("#id-for-addclass").addClass('col-md-10 col-lg-10 col-sm-9').removeClass('col-md-12 col-lg-12 col-sm-12');
    });
    /*arrow right click end*/


    /*window load event start*/
    $(window).load(function () {

        /*add class to the li first*/
        $("ul.nav.nav-tabs li").first().addClass('col-lg-offset-5 col-md-offset-4 col-sm-offset-3 col-xs-offset-3');
        /*add class to the li end*/

    });
    /*window load event end*/

    /*hide the list start*/
    /*window load event if statement for the right arrow start*/
    $(window).load(function () {
        if (window.matchMedia('(max-width: 767px)').matches) {
            $(".arrow-left").click();
        }
    });
    /*window load event if statement for the right arrow end*/
    /*window resize function for right arrow start*/
    $(window).resize(function () {

        if (window.matchMedia('(max-width: 767px)').matches) {
            $(".arrow-left").click();

        } else {
            $(".arrow-right").click();
        }
    });
    /*window resize function for right arrow end*/
    /*hide the list end*/

    /*remove focus effect start **/
    $(".btn-group.btn-group-justified button.btn-info.dim").mouseup(function () {
        $(this).blur();
    });
    /*remove focus effect end*/


    /*textarea for question answer start*/

    /*click on textarea start*/
    $("#id-for-blog .input-group #textarea-for-que").on('click', function () {
        $(this).attr("rows", "3").css("height", "89px");           // 1 row height is 39px and increase by 25px
        $("#id-for-blog .input-group button.btn.btn-primary").removeClass('hidden').css("margin-Top", "3px").css("margin-Left", "3px");
    });
    /*click on textarea end*/

    /*textarea clear area click on cancel start*/
    $("#id-for-blog .input-group button.btn.btn-primary:first").on('click', function () {
        $("#id-for-blog .input-group #textarea-for-que").attr("rows", "1").css("height", "39px").val('');
        $(this).addClass('hidden');
        $(this).next().addClass('hidden');
    });
    /*textarea clear area click on cancel end*/

    /*textarea for question answer end*/


    /*accordion of question answer start*/
    $("#accordion div.panel.panel-default").last().css("margin-bottom", "50px");
    /*accordion of question answer end*/


    /*textarea for comment answer start*/
    $("#button-for-post-cmt-answer").on('click', function () {
        $(this).next().removeClass('textarea-for-answer');
    });

    $("#button-for-cancel-cmt-answer").on('click', function () {
        $("#button-for-post-cmt-answer").next().addClass('textarea-for-answer');
    });
    /*textarea for comment answer end*/

    /*textarea for answer start*/
    $("#textarea-for-ans").on('click', function () {
        $(this).attr("rows", "3").css("height", "89px");
        $("#button-for-post-answer").removeClass("hidden");
        $("#button-for-post-answer-cancel").removeClass("hidden");
    });

    $("#button-for-post-answer-cancel").on('click', function () {
        $("#textarea-for-ans").attr("rows", "1").css("height", "39px");
        $("#button-for-post-answer").addClass("hidden");
        $(this).addClass("hidden");
    });
    /*textarea for answer end*/




});