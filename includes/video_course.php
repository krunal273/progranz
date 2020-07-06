<div class="container-fluid">
    <div class="row mt_20">
        <div class="col-md-10 col-md-offset-1">
            <div class="container-fluid">
                <div class="row">
                    <?php
                    $video_gui = "";
                    $prev_video = "";
                    $next_video = "";
                    $current_found = false;
                    foreach ($video_list as $id => $video) {
                        $active = $id == $_GET["video"] ? "active" : "";
                        $video_link = " href='#' ";
                        if ($active === "") {
                            $video_link = "href='http://progranz.local/public/course_detail.php?id={$_GET['id']}&type={$_GET['type']}&video={$id}'";
                            
                            if ($current_found === false) {
                                $prev_video = "href='http://progranz.local/public/course_detail.php?id={$_GET['id']}&type={$_GET['type']}&video={$id}'";
                            }
                            if ($current_found === true && $next_video === "") {
                                $next_video = "href='http://progranz.local/public/course_detail.php?id={$_GET['id']}&type={$_GET['type']}&video={$id}'";
                            }
                        } else {
                            $current_found = true;
                        }

                        $ThisFileInfo = $getID3->analyze($video_path . $video["video"]);
                        getid3_lib::CopyTagsToComments($ThisFileInfo);
                        $play_time = $ThisFileInfo['playtime_string'];
                        $video_gui .= "<a {$video_link} class='list-group-item {$active}'>
                                    <h4 class='list-group-item-heading'>{$video["title"]}<span class='label label-info hidden-xs'>{$play_time}</span></h4>
                                    <p class='list-group-item-text hidden-xs'>{$video["description"]}</p>
                                </a>";
                    }
                    ?>
                    <div class="col-md-1">
                        <h3><a class="btn btn-primary <?php echo $prev_video==="" ? "disabled" : ""; ?>" <?php echo $prev_video; ?>><i class="fa fa-arrow-left"></i></a></h3>
                    </div>
                    <div class="col-md-10 text-center">
                        <h3><?php echo $video_list[$_GET['video']]["title"] ?></h3>
                    </div>
                    <div class="col-md-1">
                        <h3><a class="btn btn-primary <?php echo $next_video==="" ? "disabled" : ""; ?>" <?php echo $next_video; ?>><i class="fa fa-arrow-right"></i></a></h3>
                    </div>
                </div>

                <div id="video" class="row">
                    <video controls>
                        <source src = '<?php echo $video_file; ?>' type = 'video/mp4'>
                    </video>
                </div>
                <div class="row">
                    <ul class="nav nav-tabs">
                        <li class="active col-xs-offset-5"><a data-toggle="tab" href="#list">List</a></li>
                        <li><a data-toggle="tab" href="#discuss">Discuss</a></li>
                        <li role="presentation"><a href="#id-for-review" aria-controls="profile" role="tab" data-toggle="tab">Course Reviews</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="list" class="tab-pane fade in active">
                            <div class='list-group'>
                                <?php
                                echo $video_gui;
                                ?>

                            </div>
                        </div>
                        <div id="discuss" class="tab-pane fade">
                            <div id="disqus_thread"></div>
                            <script>

                                /**
                                 *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                                 *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
                                /*
                                 var disqus_config = function () {
                                 this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                                 this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                                 };
                                 */
                                (function () { // DON'T EDIT BELOW THIS LINE
                                    var d = document, s = d.createElement('script');
                                    s.src = 'https://progranz-prakarsh-in-1.disqus.com/embed.js';
                                    s.setAttribute('data-timestamp', +new Date());
                                    (d.head || d.body).appendChild(s);
                                })();
                            </script>
                            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                        </div>
                        <?php include_once '../includes2/course_reviews.php'; ?>
                    </div>


                </div>
            </div>
        </div>


    </div>
</div>
<?php include_once '../includes/footer.php'; ?>