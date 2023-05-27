<?php
/*
* Wechslerein
*
* (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

$title = "Wechslerein - Live Editor";

include '../objects.php';
include '../../API/functions.php';

$api = new API();
$langAPI = new languageAPI();

$api -> setBeta();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" href="/media/icon.png" type="image/x-icon">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="/styles/main.css">
    <link rel="stylesheet" href="/styles/module.css">
</head>

<?php printNavBarDesktop(); ?>

<body>
    <?php $api->getErrors(); ?>

    <div class="moduleContainer">
        <div class="headerContainer">
            <h1> <?php echo $langAPI -> getPhrase(".module.liveEditor"); ?> </h1>
        </div>

        <div class="item-list">
            <div class="item">
                <div>
                    <textarea id="codeArea" name="text" cols="35" rows="4"></textarea>
                </div>
            </div>

            <div class="item">

                <div class="iframe"></div>

                <script>
                    //display live the html written in the textarea above
                    function update() {
                        const text = document.getElementById("codeArea").value;
                        document.querySelector(".iframe").innerHTML = text;
                        //if there is a script or a php tag, it will be executed
                        const scripts = document.querySelectorAll(".iframe script");
                        for (let i = 0; i < scripts.length; i++) {
                            eval(scripts[i].innerText);
                        }

                        const php = document.querySelectorAll(".iframe .php");
                    }

                    //update the iframe every 500ms
                    setInterval(update, 500);
                </script>
            </div>

    </div>
