<?php
include_once '../includes/config.php';
include_once '../includes/functions.php';
include_once '../classes/_database.php';
$db = new Database();
checkLogin();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include_once '../includes/head.php'; ?>
        <?php include_once '../includes/css.php'; ?>
        <style>
            .checkbox label::before, .radio label::before{
                margin-left: -16px !important;
                margin-top: 2px;
            }

            .checkbox label, .radio label {
                padding-left: 25px;
            }

            .correct{
                border: 2px solid green;
            }

        </style>
    </head>
    <body>
        <?php include_once '../includes/menu_top.php'; ?>
        <div class="container-fluid" id="main_container">
            <?php
            $query = "SELECT "
                    . "quiz.name AS quiz_name, "
                    . "quiz.time, "
                    . "question.id, "
                    . "question.mark, "
                    . "question.name AS name "
                    . "FROM "
                    . "quiz_master quiz "
                    . "INNER JOIN quiz_question_master AS question "
                    . "ON "
                    . "quiz.id = question.quiz_id "
                    . "WHERE "
                    . "quiz.id = {$_GET['id']} ORDER BY question.id ";
            $questions = $db->find_by_sql($query);

            $quiz_gui = "";
            $total = 0;
            foreach ($questions as $i => $question) {
                $quiz_gui .= "<div class='well well-xs'>";
                $quiz_gui .= "<span class='question' data-question_id='{$question['id']}'>" . ($i + 1) . ". " . $question["name"] . "</span>";
                $quiz_gui .= "<span class='pull-right small marks' data-marks='".$question["mark"]."'>[" . $question["mark"] . "]</span>";
                $total += intval($question["mark"]);

                $answers_query = "SELECT * FROM quiz_answer_master WHERE quiz_question_id = {$question['id']}";
                $answers = $db->find_by_sql($answers_query);
                $quiz_gui .= "<ul class='list-unstyled'>";
                foreach ($answers as $j => $answer) {
                    $answer['answer'] = str_replace("<", "&lt;", $answer['answer']);
                    $answer['answer'] = str_replace(">", "&gt;", $answer['answer']);
                    $quiz_gui .= "<li>";
                    $quiz_gui .= "<div class='radio primary'><input class='' type='radio' name='answer_{$question['id']}[]' id='radios_{$answer['id']}' value='{$answer['id']}'><label for='radios_{$answer['id']}'>{$answer['answer']}</label></div>";
                    $quiz_gui .= "</li>";
                }
                $quiz_gui .= "</ul>";
                $quiz_gui .= "</div>";
            }

            if (count($questions) > 0) {
                $quiz_gui .= "<span><button type='button' class='btn btn-primary' id='complete'>Submit</button></span>";
                $quiz_gui .= "<span class='pull-right' id='result'></span>";
            }


            if (count($questions) > 0) {
                echo "<h3>";
                echo "<span>{$questions[0]['quiz_name']}</span>";
                echo "<span class='pull-right small'>Time : <span id='minute'>{$questions[0]['time']}</span>:<span id='second'>0</span> min</span>";
                echo "<span class='pull-right small'>Total Marks : <span id='total'>{$total} </span>Marks |&nbsp;</span>";
                echo "</h3>";
            } else {
                echo "<div class='well well-xs'>No questions available</div>";
            }
            echo $quiz_gui;
            ?>
        </div>
        <?php include_once '../includes/js.php'; ?>
        <script>
            var stop = false, minute, second, spent_minue = 0, spent_second = 0, result = 0;
            $(document).ready(function () {
                minute = JSON.parse($("#minute").html());
                second = JSON.parse($("#second").html());
                updateTime();
            });

            function updateTime() {
                setTimeout(function () {
                    if (second === 0) {
                        second = 59;
                        spent_second++;
                        minute--;
                        spent_minue++;
                    } else {
                        second--;
                        spent_second++;
                    }

                    if (minute === 0 && second === 0) {
                        stop = true;
                        disableTest();
                    }

                    $("#minute").html(minute);
                    $("#second").html(second);

                    if (!stop) {
                        updateTime();
                    }
                }, 1000);
            }

            function disableTest() {
                $(":radio").prop("disabled", true);
                stop = true;
                submitQuiz();
            }

            var q = [];
            var submitted = [];
            var marks = [];

            $(document).on("click", "#complete", function () {
                disableTest();
                $(this).prop("disabled", true);
            });

            function submitQuiz() {
                q = [];
                submitted = [];
                marks = [];
                $(".well").each(function (i, v) {
                    var question = $(v).find(".question").attr("data-question_id");
                    q.push(question);
//                    console.log("Q: " + question);
                    var answer = $("[name^=answer_" + question + "]:radio:checked");
                    if (answer.length > 0) {
//                        console.log("A: " + answer.val());
                        submitted.push(answer.val());
                    } else {
//                        console.log("not attempted");
                        submitted.push(-1);
                    }
                    marks.push($(v).find(".marks").attr("data-marks"));
                });
                getAnswers();
                console.log(marks);
            }
            ;

            function getAnswers() {
                $.ajax({
                    url: "../classes/quiz.php",
                    beforeSend: function () {
                        processing(true);
                    },
                    data: {
                        questions: q
                    },
                    type: "POST",
                    success: function (response) {
                        var json_ob = parseJSON(response);
                        if (json_ob !== false) {
                            for (var i = 0; i < q.length; i++) {
                                submitted[i] = JSON.parse(submitted[i]);
                                json_ob[i] = JSON.parse(json_ob[i]);
                                console.log(q[i] + ":" + json_ob[i] + ":" + submitted[i]);
                                if (submitted[i] !== -1) {
                                    if (submitted[i] === json_ob[i]) {
//                                        console.log("true");
//                                        console.log($("[name^=answer_" + q[i] + "][value=" + submitted[i] + "]").val());
                                        $("[name^=answer_" + q[i] + "][value=" + submitted[i] + "]").closest("div").removeClass("primary").addClass("success");
                                        result += JSON.parse(marks[i]);
                                    } else {
//                                        console.log("false");
                                        $("[name^=answer_" + q[i] + "][value=" + submitted[i] + "]").closest("div").removeClass("primary").addClass("danger");
                                    }
                                }

                                $("[name^=answer_" + q[i] + "][value=" + json_ob[i] + "]").closest("div").addClass("correct");
                            }
                            
                            var aler_ob = {type: "success", message: "Course completed in : " + (spent_minue - 1) + ":" + spent_second + " minutes"};
                            showAlert(aler_ob);
                            $("#result").text("Result : "+result);
                        }
                    },
                    error: function (response) {
                        showAJAXError(response);
                    }
                });
            }
        </script>
    </body>
</html>