<?php
/*
* Wechslerein
*
* (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

    $title = "Wechslerein - Startseite";

    include 'objects.php';
    include '../API/functions.php';

    $api = new API();
    $langAPI = new languageAPI();

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
    <link rel="stylesheet" href="/styles/index.css">
</head>

<?php printNavBarDesktop(); ?>

<body>

    <?php $api -> getErrors(); ?>

    <div class="item-list">
        <?php //print items ?>

        <div class="item" id="add">
            <div class="add-item">
                <i class="fa-solid fa-plus"></i>
                <p> <?php echo $langAPI -> getPhrase(".panel.item.add"); ?> </p>
            </div>
        </div>

        <div class="item" id="configure">
            <div class="add-item">
                <i class="fa-solid fa-screwdriver-wrench"></i>
                <p> <?php echo $langAPI -> getPhrase(".panel.item.config"); ?> </p>
            </div>
        </div>
</body>

<script>
    $("#add").hover(function() {
        $(this).css("cursor", "pointer");
    });
    $("#add").click(function() {
        window.location.href = "modules/add.php";
    });

    $("#configure").hover(function() {
        $(this).css("cursor", "pointer");
    });
    $("#configure").click(function() {
        window.location.href = "modules/configure.php";
    });
</script>

</html>