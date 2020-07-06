<div class="container-fluid"> <!-- container fluid start-->

    <div class="row no_margin">

        <?php include_once '../includes2/vertical_menu.php'; ?>   <!-- ===vertical menu bar === -->

        <!-- ===content part start=== -->
        <div id="id-for-addclass" class="col-md-10 col-lg-10 col-sm-9 col-xs-12"> <!-- container part2 start-->

            <div class="arrow-right hidden-lg hidden-md hidden-sm"> <!-- right arrow start-->
                <button class="btn btn-default button-small" data-toggle="tooltip"  data-placement="right" title="Open"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
            </div>  <!-- right arrow end-->
            <br/>

            <div class="row"> <!-- container part2 content section start-->

                <?php 
                if ($result !== NULL) {
                    include_once "../courses/{$folder}/{$current_topic}";
                }
                ?>

            </div> <!-- container part2 content section end-->

            <div class='divider line'><span><i class='fa fa-skyatlas'></i></span></div>

            <div class="row"> <!-- container part2 material , question-answer , quiz section start-->

                <h2 class="title-underblock custom  text-center text-capitalize main-title">this section is for material section,blog section,quiz section</h2>

                <div> <!--nav tabs section start-->

                    <ul class="nav nav-tabs" role="tablist">  <!-- Nav tabs start-->
                        <li role="presentation" class="active"><a href="#id-for-material" aria-controls="home" role="tab" data-toggle="tab">Material</a></li>
                        <li role="presentation"><a href="#id-for-blog" aria-controls="profile" role="tab" data-toggle="tab">Blog</a></li>
                        <li role="presentation"><a href="#id-for-review" aria-controls="profile" role="tab" data-toggle="tab">Course Reviews</a></li>
                    </ul> <!-- Nav tabs end-->

                    <div class="tab-content">  <!-- Tab panes start-->
                        <?php include_once '../includes2/material.php'; ?>
                        <?php include_once '../includes2/queans.php'; ?>
                        <?php include_once '../includes2/course_reviews.php'; ?>
                    </div>  <!-- Tab panes end-->

                </div> <!--nav tabs section end-->

            </div>  <!-- container part2 material , question-answer , quiz section end-->


            <div class="clearfix"></div>

            <!-- ===footer for xs device start=== -->
            <div id="footer-for-xs" class="visible-xs"> <!--footer for xs device start-->
                <div class='divider line'><span><i class='fa fa-skyatlas'></i></span></div>
                <?php include '../includes/footer.php'; ?>
            </div> <!--footer for xs device end-->
            <!-- ===footer for xs device end=== -->

        </div> <!-- container part2 end-->
        <!-- ===content part start=== -->
    </div>
</div><!-- container fluid end-->



<!-- ===footer for lg ,md ,sm device start=== -->
<div id="footer-for-lg-md-sm" class="hidden-xs"> <!--footer for lg ,md ,sm  device start-->

    <div class='divider line'><span><i class='fa fa-skyatlas'></i></span></div>
                <?php include '../includes/footer.php'; ?>
</div> <!--footer for lg ,md ,sm  device start-->
<!-- ===footer for lg ,md ,sm device end=== -->
