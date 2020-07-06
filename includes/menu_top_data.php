<?php

$menu_top_data_left = ["inverse" => "",
    "menu" => [["name" => "home",
    "link" => "index.php"],
        ["name" => "user",
            "link" => [["name" => "usertype",
            "link" => "usertype.php"],
                ["name" => "user",
                    "link" => "user.php"],
            ]],
        ["name" => "courses",
            "link" => [["name" => "courses",
            "link" => "courses.php"],
                ["name" => "topics",
                    "link" => "course_topic.php"],
                ["name" => "category",
                    "link" => "category1.php"],
                ["name" => "tag",
                    "link" => "tag.php"],
                ["name" => "video",
                    "link" => "video.php"],
            ]],
        ["name" => "code compiler",
            "link" => "try.php"],
        ["name" => "quiz",
            "link" => [
                ["name" => "quiz",
                    "link" => "quiz.php"],
                ["name" => "quiz questions",
                    "link" => "quiz_question.php"],
                ["name" => "quiz answers",
                    "link" => "quiz_answer.php"]
            ]
        ],
        ["name" => "settings",
            "link" => [
                ["name" => "permission",
                    "link" => "permission.php"]
            ]
        ],
        ["name" => "developer",
            "link" => [
                ["name" => "per page",
                    "link" => "perpage.php"],
                ["name" => "modules",
                    "link" => "module.php"],
                ["name" => "operations",
                    "link" => "operation.php"],
                ["name" => "categories",
                    "link" => "category.php"],
                ["name" => "module operations",
                    "link" => "module_operation.php"]
            ]
        ]
//        ["name" => "material",
//            "link" => "../public/material.php"],
//        ["name" => "quiz",
//            "link" => "../public/quiz.php"],
    ],
];

if (isset($_SESSION['uid'])) {
    $menu_top_data_right = ["right" => "",
        "menu" => [["name" => $_SESSION['uname'],
        "icon" => "user",
        "link" => [["name" => "logout",
        "link" => "#",
        "class" => "logout_operation"],
        ]]
        ],
    ];
} else {
    $menu_top_data_right = ["right" => "",
        "menu" => [["name" => "login",
        "link" => "#",
        "icon" => "log-in",
        "class" => "modal-login"],
            ["name" => "sign up",
                "link" => "#",
                "icon" => "user",
                "class" => "modal-signup"]
        ],
    ];
}

//array(
//array("name" => "Home",
// "link" => "#"),
// array("divider" => ""),
// array("heading" => "Heading 1"),
// array("name" => "Content",
// "link" => "#"),
// array("name" => "Material",
// "link" => "#"),
// array("divider" => ""),
// array("name" => "Quiz",
// "link" => "#")))
?>