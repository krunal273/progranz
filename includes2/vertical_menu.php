<!-- ===vertical menu bar start=== -->
<div class='col-md-2 col-lg-2 col-sm-3  pricing-table-container'> <!-- container part1 start-->
    <div id='active-select' class='pricing-table'>  <!--vertical menu bar start -->
        <div class='arrow-left visible-xs'>
            <button class='btn btn-default button-small' data-toggle='tooltip' data-placement='top' title='Close'><i class='fa fa-chevron-left' aria-hidden='true'></i></button>
        </div>
        <h3 style='text-transform: uppercase;'><?php echo $title;?></h3>
        <ul class='pricing-list'>
            <?php
            $i = 0;
            if ($result !== NULL) {
                foreach ($topics as $topic) {
                    $active = "";
                    if (isset($_GET['topic'])) {
                        if ($_GET['topic'] === $topic["id"]) {
                            $active = " class='active2'";
                            $current_topic = $topic["filename"];
                        }
                    } else {
                        if ($i === 0) {
                            $active = " class='active2'";
                            $current_topic = $topic["filename"];
                        }
                    }
                    echo "<li {$active}><a href='../public/course_detail.php?id={$_GET['id']}&type={$_GET['type']}&topic={$topic['id']}'>{$topic["name"]}</a></li>";
                    $i++;
                }
            }
            ?>                           

        </ul>
    </div> <!--vertical menu bar end-->
</div> <!-- container part1 end-->
<!-- ===vertical menu bar end=== -->