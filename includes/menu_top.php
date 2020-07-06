<?php

include_once 'menu_top_data.php';

$brand = isset($menu_top_data_left["brand"]) ? $menu_top_data_left["brand"]["name"] : "";
$brand_link = isset($menu_top_data_left["brand"]) ? $menu_top_data_left["brand"]["link"] : "";
$current_page = getCurrentPage();
$inverse = isset($menu_top_data_left["inverse"]) ? "navbar-inverse" : "navbar-default";

echo "<nav class='navbar {$inverse}'>
  <div class='container-fluid'>
    <div class='navbar-header'>
      <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#myNavbar'>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
        <span class='icon-bar'></span>
      </button>
      <a class='navbar-brand' href='{$brand_link}'>{$brand}</a>
    </div>
    <div class='collapse navbar-collapse' id='myNavbar'>";

printMainMenu($menu_top_data_left);

printMainMenu($menu_top_data_right);

echo "</div>
  </div>
</nav>";

function printMainMenu($menu) {
    $left = isset($menu["right"]) ? "navbar-right" : "";
    echo "<ul class='nav navbar-nav {$left}'>";
    printMenu($menu["menu"]);
    echo "</ul>";
}

function printMenu($menu_top_data) {
    global $current_page;

    foreach ($menu_top_data as $menu) {
        if (isset($menu["divider"])) {
            echo "<li role='separator' class='divider'></li>";
        } else if (isset($menu["heading"])) {
            echo "<li class='dropdown-header'>{$menu["heading"]}</li>";
        } else {
            $icon = isset($menu['icon']) ? "<span class='glyphicon glyphicon-{$menu['icon']}'></span> " : "";

            if (!is_array($menu["link"])) {
                $active_class = $menu["link"] === $current_page ? "class='active'" : "";
                $link_class = isset($menu["class"]) ? $menu["class"] : "";
                $page_link = $menu["link"] === $current_page ? "" : "href='{$menu["link"]}'";
                echo "<li {$active_class}><a class='{$link_class}' {$page_link}>{$icon}{$menu["name"]}</a></li>";
            } else {
                echo "<li class='dropdown'>
          <a class='dropdown-toggle' data-toggle='dropdown' href='#'>{$icon}{$menu["name"]} <span class='caret'></span></a>
          <ul class='dropdown-menu'>";
                printMenu($menu["link"]);
                echo "</ul>
        </li>";
            }
        }
    }
}
