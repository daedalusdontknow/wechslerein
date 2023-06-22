<?php
    /*
     * Wechslerein
     *
     * (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
     *
     * This source file is subject to the MIT license that is bundled
     * with this source code in the file LICENSE.
     */

    $post = $_POST;

    if (!empty($post["ip"]) && !empty($post["installerKey"])) {
        inverterData($post["ip"], $post["installerKey"]);
    } elseif (isset($post["recordDataSave"])) {
        echo "<script> alert('test'); </script>";
        recordData($post["recordData"]);
    } elseif (!empty($post["language"])) {
        setLanguage($post["language"]);
    } elseif (!empty($post["secretUpdate"])) {
        checkVersion();
    } else {
        header("Location: ../../app/settings/?settings=failed");
    }

    function inverterData($ip, $key): void
    {
        //check if the folder DATA exists and if not create it
        if (!file_exists(__DIR__ . "/../DATA")) {
            mkdir(__DIR__ . "/../DATA");
        }

        //check if the file config.json exists and if not create it
        if (!file_exists(__DIR__ . "/../DATA/config.json")) {
            $config = [
                "ip" => $ip,
                "installerKey" => $key,
                "recordData" => false,
                "language" => "en",
            ];
        } else {
            //if the file exists, read it and change the values
            $config = json_decode(
                file_get_contents(__DIR__ . "/../DATA/config.json"),
                true
            );
            $config["ip"] = $ip;
            $config["installerKey"] = $key;
        }

        file_put_contents(__DIR__ . "/../DATA/config.json", json_encode($config));

        header("Location: ../../app/settings/?settings=success");
    }

    function recordData($recordData): void
    {
        $config = json_decode(
            file_get_contents(__DIR__ . "/../DATA/config.json"),
            true
        );
        if ($recordData == "on") {
            $recordData = true;
        } else {
            $recordData = false;
        }
        $config["recordData"] = $recordData;
        file_put_contents(__DIR__ . "/../DATA/config.json", json_encode($config));
        header("Location: ../../app/settings/?settings=success");
    }

    function setLanguage($language): void
    {
        $language = strtolower(substr($language, 0, 2));
        setcookie("lang", "", time() - 3600, "/");

        if (!file_exists(__DIR__ . "../DATA/config.json")) {
            $config = [
                "ip" => "",
                "installerKey" => "",
                "recordData" => false,
                "language" => $language,
            ];
        } else {
            $config = json_decode(
                file_get_contents(__DIR__ . "/../DATA/config.json"),
                true
            );
            $config["language"] = $language;
        }

        file_put_contents(__DIR__ . "/../DATA/config.json", json_encode($config));
        setcookie("lang", $language, time() + 120, "/");
        header("Location: ../../app/settings/?settings=success");
    }

    function checkVersion()
    {
        header("Location: ../../app/settings/?settings=failed");

        $domain = "";

        $ch = curl_init($domain);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:application/json"]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Skip SSL Verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Skip SSL Verification
        $result = curl_exec($ch);
        curl_close($ch);

        //if an error occurs, return the error
        if ($result === false) {
            return curl_error($ch);
        }

        include_once __DIR__ . "/../functions.php";
        $currentVersion = getVersion();

        //compare the two versions, versions are build up like this "B1.0.0", Where "B" stands for beta, "1" for the version, "0" for the subversion and "0" for the bugfix
        if ($result > $currentVersion) {
            echo "update";
        } else {
            echo "no update";
        }
    }