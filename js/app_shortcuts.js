/* global shortcut */

$(document).ready(function () {    
    
    shortcut.add("Ctrl+F1", function () {
        if ($(".modal.in").length > 0) {
            $(".modal.in [data-dismiss=modal]").click();
        }
        openHelpModal();
    });
    
    shortcut.add("Alt+P", function () {
        $("#get_pdf").click();
    });
    
    shortcut.add("Alt+E", function () {
        $("#get_excel").click();
    });
    
    shortcut.add("Ctrl+3", function () {
        if ($(".modal.in[id*=insert]").length === 0) {
            destroyModal($(".modal[id*=edit]"));
            $("[data-modal*=insert]").click();
        }
    });
    shortcut.add("F1", function () {
        if ($(".modal.in").length > 0) {
            $(".modal.in [data-dismiss=modal]").click();
        }
        $(".profile_operation").click();
    });
    shortcut.add("F2", function () {
        if ($(".modal.in").length > 0) {
            $(".modal.in [data-dismiss=modal]").click();
        }
        $("#profile_menu .password_operation").click();
    });
    shortcut.add("F3", function () {
        if ($(".modal.in").length > 0) {
            $(".modal.in [data-dismiss=modal]").click();
        }
        $(".logout_operation").click();
    });
    shortcut.add("ESC", function () {
        if ($(".modal.in").length > 0) {
            $(".modal.in:last [data-dismiss=modal]").click();
        } else {
            $("[data-remove_search]").click();
        }
        if ($(":focus").closest("#table_form").length === 0) {
            $(":focus").blur();
            focusFirstElement();
        }
        $(".open").removeClass("open");
        $("#hovered_menu").removeAttr("id");
        $("#hovered_submenu").removeAttr("id");
    });
    shortcut.add("Ctrl+Alt+Left", function () {
        focusOtherButton("previous");
    });
    shortcut.add("Ctrl+Alt+Right", function () {
        focusOtherButton("next");
    });
    shortcut.add("Ctrl+Up", function () {
        var opened = $(".navbar-nav.navbar-right>li.dropdown.open");
        if (opened.length === 0) {
            focusOtherRow("previous");
        }

    });
    shortcut.add("Ctrl+Down", function () {
        var opened = $(".navbar-nav.navbar-right>li.dropdown.open");
        if (opened.length === 0) {
            focusOtherRow("next");
        }
    });
    shortcut.add("Ctrl+1", function () {
        $("#categories").click();
    });
    shortcut.add("Ctrl+2", function () {
        $("#per_page").click();
    });
    shortcut.add("Ctrl+Alt+Home", function () {
        $("#first").click();
    });
    shortcut.add("Ctrl+Alt+End", function () {
        $("#last").click();
    });
    shortcut.add("Ctrl+Page_up", function () {
        $("#next_set").click();
    });
    shortcut.add("Ctrl+Page_down", function () {
        $("#previous_set").click();
    });
    shortcut.add("Ctrl+Delete", function () {
        openOperationModal("delete");
    });
    shortcut.add("Ctrl+Insert", function () {
        openOperationModal("edit");
    });
    shortcut.add("Ctrl+O", function () {
        var hide = $(".categories").css("display");
        if (hide !== "none") {
            var display = $(".operations").css("display") === "table-cell" ? "none" : "table-cell";
            toggleOperations(display, "");
        }
    });
    shortcut.add("Ctrl+H", function () {
        var hide = $(".categories").css("display") === "block" ? "none" : "block";
        var display = hide === "none" ? "none" : "table-cell";
        toggleOperations(display, hide);
    }, {
        'propagate': false
    });
    shortcut.add("Ctrl+S", function () {
        openAdvancedSearch();
    });
    shortcut.add("Ctrl+F", function () {
        if ($(".modal.in").length > 0) {
            $(".modal.in [data-dismiss=modal]").click();
        }
        $("#search").focus();
    });
    shortcut.add("Alt+A", function () {
        $("[data-a_search]").click();
    });
//    shortcut.add("Alt+S", function () {
//        $(".modal").each(function (index, ele) {
//            ele = $(ele);
//            if (ele.attr("id").indexOf("insert") !== -1) {
//                ele.modal("hide");
//            } else {
//                destroyModal(ele);
//            }
//        });
//        $("#search").focus();
//    });
    shortcut.add("Ctrl+Up", function () {
        hoverOtherSubMenu("up");
    });
    shortcut.add("Ctrl+Down", function () {
        hoverOtherSubMenu("down");
    });
    shortcut.add("Ctrl+Left", function () {
        if ($(".modal.in").length === 0) {
            hoverOtherMenu("left");
            var target = ".navbar-nav.navbar-right>li";
            var opened = $(target + ".dropdown.open");
            if (opened.length !== 0) {
                hoverOtherSubMenu("down");
            }
        }
    });
    shortcut.add("Ctrl+Right", function () {
        if ($(".modal.in").length === 0) {
            hoverOtherMenu("right");

            var target = ".navbar-nav.navbar-right>li";
            var opened = $(target + ".dropdown.open");
            if (opened.length !== 0) {
                hoverOtherSubMenu("down");
            }
        }
    });

    shortcut.add("Alt+Right", function () {
        setSortFocus("right");
    }, {
        'propagate': false
    });

    shortcut.add("Alt+Delete", function () {
        var focused = $("[data-sort]:focus");
        if (focused.length !== 0) {
            focused.closest("th").find("[data-remove_sort]").click();
        }
    });

    shortcut.add("Alt+Backspace", function () {
        var focused = $("[data-sort]:focus");
        if (focused.length !== 0) {
            console.log(focused.closest("th").find("[data-remove_filter]"));
            focused.closest("th").find("[data-remove_filter]").click();
        }
    });

    shortcut.add("Alt+Insert", function () {
        var focused = $("[data-sort]:focus");
        if (focused.length !== 0) {
            focused.closest("th").find("[data-filter]").click();
        }
    });

    shortcut.add("Alt+Left", function () {
        setSortFocus("left");
    }, {
        'propagate': false
    });

    shortcut.add("Ctrl+M", function () {
        if ($("#profile_menu>li").hasClass("open")) {
            $("#profile_menu>li").removeClass("open");
            focusFirstElement();
        } else {
            $("#profile_menu>li").addClass("open");
            $("#profile_menu>li>ul a:first").focus();
        }

    });

    shortcut.add("Enter", function () {
        if ($(".navbar li.dropdown#hovered_menu.open>ul>li>a#hovered_submenu").length !== 0) {
            var href = $(".navbar li.dropdown#hovered_menu.open>ul>li>a#hovered_submenu").attr("href");
            window.location = href;
        }
    }, {
        'propagate': true
    });
});

function setSortFocus(direction) {
    var first = $("[data-sort]:first");
    var last = $("[data-sort]:last");
    var focused = $("[data-sort]:focus");
    if (focused.length === 0) {
        if (direction === "right") {
            first.focus();
        } else {
            last.focus();
        }
    } else {
        var other;
        if (direction === "right") {
            if (focused.is(last)) {
                other = first;
            } else {
                other = focused.closest("th").next().find($("[data-sort]"));
            }
        } else {
            if (focused.is(first)) {
                other = last;
            } else {
                other = focused.closest("th").prev().find($("[data-sort]"));
            }
        }
        other.focus();
    }
}

function focusOtherButton(direction) {
    var modal = $(".modal.in");
    var modal_footer = $(".modal.in .modal-footer");
    if (modal.length > 0) {
        var focused_button = modal_footer.find("button:focus");
        var last_button = modal_footer.find("button:not(:visible:disabled):last");
        var first_button = modal_footer.find("button:not(:visible:disabled):first");

        switch (direction) {
            case "next":
                if (focused_button.length > 0) {
                    if (!focused_button.is(last_button)) {
                        focusOtherActiveElement(focused_button, direction);
                    } else {
                        first_button.focus();
                    }
                } else {
                    last_button.focus();
                }
                break;
            case "previous":
                if (focused_button.length > 0) {
                    if (!focused_button.is(first_button)) {
                        focusOtherActiveElement(focused_button, direction);
                    } else {
                        last_button.focus();
                    }
                } else {
                    last_button.focus();
                }
                break;
            default:
                break;

        }
    } else {
        if (direction === "next") {
            $("#next_page").click();
        } else {
            $("#previous_page").click();
        }
    }
}

function focusOtherActiveElement(ele, direction) {
    var other_ele, not_found;
    var i = 0;
    do {
        switch (direction) {
            case "next":
            case "down":
                other_ele = ele.next();
                break;
            case "previous":
            case "up":
                other_ele = ele.prev();
                break;
        }

        if (other_ele.prop("disabled") === true || !other_ele.is(":visible")) {
            not_found = true;
            ele = other_ele;
        } else {
            not_found = false;
        }
        i++;
    } while (not_found || i === 20);

    other_ele.focus();
}

function focusOtherRow(direction) {
    var table = $("#table_form").find("table"), focused_checkbox, first_checkbox, last_checkbox, all_checkbox;
    if ($(".modal.in").length === 0 && table.length === 1) {
        focused_checkbox = table.find(":checkbox:focus");
        all_checkbox = table.find("#all");
        first_checkbox = table.find("tbody :checkbox:first");
        last_checkbox = table.find("tbody :checkbox:last");
        if (focused_checkbox.length === 0) {
            all_checkbox.focus();
        } else {
            if (focused_checkbox.is(all_checkbox)) {
                if (direction === "previous") {
                    last_checkbox.focus();
                } else if (direction === "next") {
                    first_checkbox.focus();
                }
            } else {
                if (direction === "previous") {
                    if (focused_checkbox.is(first_checkbox)) {
                        all_checkbox.focus();
                    } else {
                        focused_checkbox.closest("tr").prev().find(":checkbox").focus();
                    }
                } else if (direction === "next") {
                    if (focused_checkbox.is(last_checkbox)) {
                        all_checkbox.focus();
                    } else {
                        focused_checkbox.closest("tr").next().find(":checkbox").focus();
                    }
                }
            }
        }
    }
}

function hoverOtherMenu(direction) {
    var target = ".navbar-nav.navbar-right>li";
    var active = $(target + ".active");

    var opened = $(target + ".dropdown.open");
    if (opened.length === 0) {
        opened = $(target + "#hovered_menu");
    }
    var first = $(target + ":first");
    var last = $(target + ":last");
    if (opened.length === 0) {
        if (active.hasClass("dropdown")) {
            active.addClass("open").attr("id", "hovered_menu");
        } else {
            active.attr("id", "hovered_menu");
        }
    } else
    {
        $(".navbar li.dropdown.open").removeClass("open").removeAttr("id");
        $("#hovered_submenu").removeAttr("id");
        $("#hovered_menu").removeAttr("id");

        if (direction === "right") {
            var next;
            if (opened.is(last)) {
                next = first;
            } else {
                next = opened.next();
            }

            if (next.hasClass("dropdown")) {
                next.addClass("open").attr("id", "hovered_menu");
            } else {
                next.attr("id", "hovered_menu");
                next.find("a").focus();
            }
        } else if (direction === "left") {
            var prev;
            if (opened.is(first)) {
                prev = last;
            } else {
                prev = opened.prev();
            }
            if (prev.hasClass("dropdown")) {
                prev.addClass("open").attr("id", "hovered_menu");
            } else {
                prev.attr("id", "hovered_menu");
                prev.find("a").focus();
            }
        }
    }
}

function hoverOtherSubMenu(direction) {
    var active = $(".navbar li.dropdown#hovered_menu>ul>li.active>a");
    var hovered = $(".navbar li.dropdown#hovered_menu>ul>li>a#hovered_submenu");
    var first = $(".navbar li.dropdown#hovered_menu>ul>li:not(.active):first>a");
    var last = $(".navbar li.dropdown#hovered_menu>ul>li:not(.active):last>a");
    if (hovered.length === 0) {
        if (direction === "down") {
            first.focus().attr("id", "hovered_submenu");
        } else if (direction === "down") {
            last.focus().attr("id", "hovered_submenu");
        }
    } else {
        if (direction === "down") {
            if (hovered !== first) {
                hovered.removeAttr("id");
                var next;
                if (hovered.is(last)) {
                    next = first;
                } else {
                    next = hovered.closest("li").next().find("a");
                }
                if (next.is(active)) {
                    next = next.closest("li").next().find("a");
                }
                next.focus().attr("id", "hovered_submenu");
            }
        } else if (direction === "up") {
            if (hovered !== last) {
                hovered.removeAttr("id");
                var prev;
                if (hovered.is(first)) {
                    prev = last;
                } else {
                    prev = hovered.closest("li").prev().find("a");
                }
                if (prev.is(active)) {
                    prev = prev.closest("li").prev().find("a");
                }
                prev.focus().attr("id", "hovered_submenu");
            }
        }
    }
}

function openOperationModal(operation) {
    var table = $("#table_form").find("table"), focused_checkbox;
    if ($(".modal.in").length === 0 && table.length === 1) {
        focused_checkbox = table.find("tbody :checkbox:focus");
        if (focused_checkbox.length === 1) {
            focused_checkbox.closest("tr").find("." + operation + "_operation").click();
        }
    }
}