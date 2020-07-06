<div role='tabpanel' class='tab-pane fade' id='id-for-review'> <!-- container part2 material section start-->

    <div class='row'> 
        <h2 class='title-underblock custom text-center text-capitalize'>reviews</h2>

        <?php
        $query = "SELECT "
                . "user.name user, "
                . "review_table.rating AS rating, "
                . "DATE_FORMAT(review_table.date, '%d-%m-%Y %h:%i %p') AS date, "
                . "review_table.title AS title, "
                . "review_table.message AS message "
                . "FROM "
                . "review_master AS review_table "
                . "INNER JOIN "
                . "user_master AS user "
                . "ON "
                . "user.id = review_table.review_by "
                . "WHERE course_id = '{$_GET["id"]}' ";
        $reviews = $db_object->find_by_sql($query);
        foreach ($reviews as $review) {
            echo "<div class='col-md-4'>
            <div class='panel panel-primary'>
                <div class='panel-heading'>
                    <span>{$review["user"]}</span>
                    <span class='pull-right'>". getStar($review["rating"])."</span>
                </div>
                <div class='panel-body'>
                <div>{$review["title"]}</div>
                <div>{$review["message"]}</div>
                </div>
                <div class='panel-footer'>
                    <span>{$review["date"]}</span>
                </div>                
            </div>
        </div>";
        }
        
        function getStar($rating) {
                $star = "";
                $limit_low = floor($rating);
                $limit_upper = ceil($rating);

                for ($i = 1; $i <= $limit_low; $i++) {
                    $star .= "<i class='fa fa-star rating' aria-hidden='true'></i> ";
                }

                for ($i = $limit_low + 1; $i <= $limit_upper; $i++) {
                    $star .= "<i class='fa fa-star-half rating' aria-hidden='true'></i> ";
                }

                for ($i = $limit_upper + 1; $i <= 5; $i++) {
                    $star .= "<i class='fa fa-star-o rating' aria-hidden='true'></i> ";
                }
                return $star;
            }
        ?>

    </div> 

</div> <!-- container part2 material section end-->