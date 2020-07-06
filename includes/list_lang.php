<div class='container-fluid'>
    <div class='row'>
        <div class='col-sm-12'>
            <h2 class='title-underblock custom text-center text-capitalize'>below section is for content,question-answer(blog),material,quiz</h2>
            <div class='row pricing-row text-capitalize'>
                <div class='col-md-3 pricing-table-container'>
                    <div class='pricing-table'>
                        <h3>content</h3>
                        <header>
                            <div class='price custom'>
                                <span><i class='fa fa-newspaper-o fa-3x' aria-hidden='true'></i></span>
                            </div>
                        </header>
                        <ul class='pricing-list'>
                            <?php
                            $query = "SELECT "
                                    . "course_master.id as id, "
                                    . "course_master.name as name, "
                                    . "category1_master.name as type "
                                    . "FROM "
                                    . "course_master "
                                    . "INNER JOIN category1_master "
                                    . "ON "
                                    . "category1_master.id = course_master.category_id "
                                    . "LIMIT 5";
                            $result = $db_object->find_by_sql($query);

                            foreach ($result as $course) {
                                echo "<li><a href='../public/course_detail.php?id={$course['id']}&type={$course['type']}'>{$course['name']}</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class='col-md-3 pricing-table-container'>
                    <div class='pricing-table'>
                        <h3>blog</h3>
                        <header>
                            <div class='price custom'>
                                <span><i class='fa fa-pencil-square-o fa-3x' aria-hidden='true'></i></span>
                            </div>
                        </header>
                        <ul class='pricing-list'>
                            <li><a href='#'>html</a></li>
                            <li><a href='#'>css</a></li>
                            <li><a href='#'>jquery</a></li>
                            <li><a href='#'>bootstrap</a></li>
                            <li><a href='#'>php</a></li> 
                        </ul>
                    </div>
                </div>
                <div class='col-md-3 pricing-table-container'>
                    <div class='pricing-table'>
                        <h3>content</h3>
                        <header>
                            <div class='price custom'>
                                <span><i class='fa fa-newspaper-o fa-3x' aria-hidden='true'></i></span>
                            </div>
                        </header>
                        <ul class='pricing-list'>
                            <?php
                            $query = "SELECT "
                                    . "course_master.id as id, "
                                    . "course_master.name as name, "
                                    . "category1_master.name as type "
                                    . "FROM "
                                    . "course_master "
                                    . "INNER JOIN category1_master "
                                    . "ON "
                                    . "category1_master.id = course_master.category_id "
                                    . "LIMIT 5";
                            $result = $db_object->find_by_sql($query);

                            foreach ($result as $course) {
                                echo "<li><a href='../public/course_detail.php?id={$course['id']}&type={$course['type']}#id-for-material'>{$course['name']}</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class='col-md-3 pricing-table-container'>
                    <div class='pricing-table'>
                        <h3>material</h3>
                        <header>
                            <div class='price custom'>
                                <span><i class='fa fa-question-circle fa-3x' aria-hidden='true'></i></span>
                            </div>
                        </header>
                        <ul class='pricing-list'>
                            <li><a href='#'>html</a></li>
                            <li><a href='#'>css</a></li>
                            <li><a href='#'>jquery</a></li>
                            <li><a href='#'>bootstrap</a></li>
                            <li><a href='#'>php</a></li> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>