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
    <link rel="stylesheet" href="/styles/settings.css">
</head>

<?php printNavBarDesktop(); ?>

<body>
    <?php $api -> getErrors(); ?>
    <div class="item-list">
        <div class="item">

            <div class = "headerContainer">
                <h1> <?php echo $langAPI -> getPhrase(".settings.inverterData"); ?> </h1>
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

            <form action="../API/config.php" method="post" id="inverterData">
                <label for="ip">IP</label><br>
                <input type="text" id="ip" name="ip" value="<?php echo $cIP; ?>"><br>
                <label for="installerKey">Installer Key</label><br>
                <input type="text" id="installerKey" name="installerKey" value="<?php echo $cKEY; ?>"><br><br>
                <input type="submit" value="<?php echo $langAPI -> getPhrase(".save"); ?>">
            </form>
        </div>


        <div class="item">
            <div class = "headerContainer">
                <h1> <?php echo $langAPI -> getPhrase(".settings"); ?> </h1>
            </div>

            <?php
                if (!$api->configExists()) {
                    $cRD = "";
                }
                else {
                    $config = $api->getConfig();
                    $cRD = $config["recordData"] ? "checked" : "";
                }
            ?>

            <form action="../API/config.php" method="post">
                <label for="recordData"> <?php echo $langAPI -> getPhrase(".settings.recordData"); ?> </label><br>
                <label class="slider">
                    <input type="checkbox" id="recordData" name="recordData" <?php echo $cRD ?>>
                    <span class="slider-round"></span>
                </label><br><br>
                <input type="hidden" type="checkbox" id="recordDataSave" name="recordDataSave" value="true" checked>
                <input type="submit" value="<?php echo $langAPI -> getPhrase(".save"); ?>">
            </form>
        </div>

        <div class="item">
            <div class = "headerContainer">
                <h1><?php echo $langAPI -> getPhrase(".settings.language"); ?></h1>
            </div>

            <form action="../API/config.php" method="post">
                <label for="language"> <?php echo $langAPI -> getPhrase(".settings.language"); ?> </label><br>
                <select name="language" id="language">
                    <?php
                        $languages = $langAPI->getLanguages();
                        foreach ($languages as $language) {
                            if (strtolower(substr($language, 0, 2)) == $_COOKIE["lang"]) {
                                echo "<option value='" . $language . "' selected>" . $language . "</option>";
                            }
                            else {
                                echo "<option value='" . $language . "'>" . $language . "</option>";
                            }
                        }
                    ?>
                </select><br><br>
                <input type="submit" value="<?php echo $langAPI -> getPhrase(".save"); ?>">
            </form>

        </div>

        <div class="item">
            <div class = "headerContainer">
                <h1><?php echo $langAPI -> getPhrase(".settings.update"); ?></h1>
            </div>

            <p><?php echo $langAPI -> getPhrase(".settings.version.current"); ?></p>
            <form action="../API/config.php" method="post">
                <input type="hidden" type="checkbox" id="secretUpdate" name="secretUpdate" value="true" checked>
                <input type="submit" value="<?php echo $langAPI -> getPhrase(".settings.update.check"); ?>">
            </form>
        </div>

        <div class="item">
            <div class = "headerContainer">
                <h1><?php echo $langAPI -> getPhrase(".settings.removeSoftware"); ?></h1>
            </div>
        </div>
