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

include 'objects.php';
include '../API/functions.php';

$api = new API();
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
    <link rel="stylesheet" href="/styles/settings.css">
</head>

<?php printNavBarDesktop(); ?>

<body>

    <?php
    if (!$api->configExists()) {
        echo "<div class='error'>Die Konfigurationsdatei wurde nicht gefunden. Bitte richten Sie die Konfiguration in der Weboberfläche ein. </div>";
    }
    ?>

    <div class="item-list">
        <div class="item">

            <div class = "headerContainer">
                <h1>Inverter data</h1>
            </div>

            <?php
                if (!$api->configExists()) {
                    $cIP = "";
                    $cKEY = "";
                }
                else {
                    $config = $api->getConfig();

                    $cIP = $config["ip"];
                    $cKEY = $config["installerKey"];
                }
            ?>

            <form action="http://localhost/API/Config/config.php" method="post">
                <label for="ip">IP</label><br>
                <input type="text" id="ip" name="ip" value="<?php echo $cIP; ?>"><br>
                <label for="installerKey">Installer Key</label><br>
                <input type="text" id="installerKey" name="installerKey" value="<?php echo $cKEY; ?>"><br><br>
                <input type="submit" value="Submit">
            </form>
        </div>


        <div class="item">
            <div class = "headerContainer">
                <h1>Personal settings</h1>
            </div>

            <form action="http://localhost/API/Config/config.php" method="post">
                <label for="recordData">Record data</label><br>
                <label class="slider">
                    <input type="checkbox" id="recordData" name="recordData" value="true">
                    <span class="slider-round"></span>
                </label><br><br>
                <input type="submit" value="Submit">
            </form>
        </div>

        //update software
        <div class="item">
            <div class = "headerContainer">
                <h1>Update</h1>
            </div>

            <p>Current version:</p>
            <p>Latest version:</p>
            <a href="/API/upgrade.php" class="button">Update</a>

        </div>
