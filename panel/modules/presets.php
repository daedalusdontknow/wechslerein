<?php
/*
* Wechslerein
*
* (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

$title = "Wechslerein - Settings";

include '../objects.php';
include '../../API/functions.php';

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
    <link rel="stylesheet" href="/styles/module.css">
</head>

<?php printNavBarDesktop(); ?>

<body>
    <div class="item-list">
        <div class="item">
            <div class="headerContainer">
                <h1> <?php echo $langAPI -> getPhrase(".presets.1.title"); ?> </h1>
            </div>

            <img src="/media/presets/preset1.png" alt="Presets" class="image" width="65%">
            <br>
            <a href="/API/presets.php?preset=1" class="button"> <?php echo $langAPI -> getPhrase(".presets.add"); ?> </a>
        </div>
    </div>