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
        <link rel="stylesheet" href="/assets/style/settings.css">
    </head>


    <?php printNavBarDesktop(); ?>

    <body>
        <?php API::getErrors(); ?>
        <div class="item-list">
            <div class="item">

                <div class = "headerContainer">
                    <h1> <?php echo languageAPI::getPhrase(".settings.inverterData"); ?> </h1>
                </div>

                <?php
                if (!API::configExists())
                {
                    $cIP = "";
                    $cKEY = "";
                }
                else
                {
                    $config = API::getConfig();

                    $cIP = $config["ip"];
                    $cKEY = $config["installerKey"];
                }
                ?>

                <form action="../../resources/save/config.php" method="post" id="inverterData">
                    <label for="ip">IP</label><br>
                    <input type="text" id="ip" name="ip" value="<?php echo $cIP; ?>"><br>
                    <label for="installerKey">Installer Key</label><br>
                    <input type="text" id="installerKey" name="installerKey" value="<?php echo $cKEY; ?>"><br><br>
                    <input type="submit" value="<?php echo languageAPI::getPhrase(".save"); ?>">
                </form>
            </div>


            <div class="item">
                <div class = "headerContainer">
                    <h1> <?php echo languageAPI::getPhrase(".settings"); ?> </h1>
                </div>

                <?php
                if (!API::configExists())
                {
                    $cRD = "";
                }
                else
                {
                    $config = API::getConfig();
                    $cRD = $config["recordData"] ? "checked" : "";
                }
                ?>

                <form action="../../resources/save/config.php" method="post">
                    <label for="recordData"> <?php echo languageAPI::getPhrase(".settings.recordData"); ?> </label><br>
                    <label class="slider">
                        <input type="checkbox" id="recordData" name="recordData" <?php echo $cRD ?>>
                        <span class="slider-round"></span>
                    </label><br><br>
                    <input type="hidden" type="checkbox" id="recordDataSave" name="recordDataSave" value="true" checked>
                    <input type="submit" value="<?php echo languageAPI::getPhrase(".save"); ?>">
                </form>
            </div>

            <div class="item">
                <div class = "headerContainer">
                    <h1><?php echo languageAPI::getPhrase(".settings.language"); ?></h1>
                </div>

                <form action="../../resources/save/config.php" method="post">
                    <label for="language"> <?php echo languageAPI::getPhrase(".settings.language"); ?> </label><br>
                    <select name="language" id="language">
                        <?php
                        $languages = languageAPI::getLanguages();
                        foreach ($languages as $language)
                        {
                            if (strtolower(substr($language, 0, 2)) == $_COOKIE["lang"])
                            {
                                echo "<option value='" . $language . "' selected>" . $language . "</option>";
                            }
                            else
                            {
                                echo "<option value='" . $language . "'>" . $language . "</option>";
                            }
                        }
                        ?>
                    </select><br><br>
                    <input type="submit" value="<?php echo languageAPI::getPhrase(".save"); ?>">
                </form>

            </div>

            <div class="item">
                <div class = "headerContainer">
                    <h1><?php echo languageAPI::getPhrase(".settings.update"); ?></h1>
                </div>

                <p><?php echo languageAPI::getPhrase(".settings.version.current"); ?></p>
                <form action="../API/config.php" method="post">
                    <input type="hidden" type="checkbox" id="secretUpdate" name="secretUpdate" value="true" checked>
                    <input type="submit" value="<?php echo languageAPI::getPhrase(".settings.update.check"); ?>">
                </form>
            </div>

            <div class="item">
                <div class = "headerContainer">
                    <h1><?php echo languageAPI::getPhrase(".settings.plugins"); ?></h1>
                </div>
            </div>

            <div class="item">
                <div class = "headerContainer">
                    <h1><?php echo languageAPI::getPhrase(".settings.removeSoftware"); ?></h1>
                </div>
            </div>
        </div>
    </body>
</html>