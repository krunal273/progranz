<div role='tabpanel' class='tab-pane fade in active' id='id-for-material'> <!-- container part2 material section start-->

    <div class='row'> 
        <h2 class='title-underblock custom text-center text-capitalize'>material</h2>
        <h4 class='main-title'> below section is show the how many number of ppt ,pdf ,video is available</h4>
        <?php
        $material_path = "../docs/user_{$_SESSION['uid']}/course_{$_GET['id']}/";
        $files_bundle = getFiles($material_path);

        foreach ($files_bundle as $folder => $files_array) {
            if (is_array($files_array) && $folder !== "videos") {
                echo "<button type='button' class='btn btn-info dim material_button' data-target='fileExpand' data-type='{$folder}' data-path='{$material_path}'>{$folder}&nbsp;&nbsp;<span class='badge'>" . count($files_array) . "</span></button>";
            }
        }

        echo "<div class='collapse' id='fileExpand' data-type=''></div>";
        ?>
    </div> 

</div> <!-- container part2 material section end-->