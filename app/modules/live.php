<?php
/*
 * Wechslerein
 *
 * (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
*/

$title = "Wechslerein";

include_once '../../assets/objects.php';
include_once '../../resources/functions.php';
?>
<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="icon" href="/assets/media/icon.png" type="image/x-icon">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="/assets/style/main.css">
        <link rel="stylesheet" href="/assets/style/modules.css">
    </head>

    <?php printNavBarDesktop(); ?>

    <body>
        <?php API::getErrors(); ?>

        <div class="moduleContainer">
            <div class="headerContainer">
                <h1> <?php echo languageAPI::getPhrase(".module.liveEditor"); ?> </h1>
            </div>

            <div class="item-list">
                <div class="item">
                    <div>
                        <textarea id="codeArea" name="text" style="background-color: #fff; border: 1px solid #4ee06a; border-radius: 4px; box-sizing: border-box; text-align: center; padding: 10px; margin: 0; width: 500%; height: 200px; resize: none;"></textarea>
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
        </div>
    </body>
</html>