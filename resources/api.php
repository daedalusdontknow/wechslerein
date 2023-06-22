<?php
    /*
     * Wechslerein
     *
     * (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
     *
     * This source file is subject to the MIT license that is bundled
     * with this source code in the file LICENSE.
     */
    echo "API started running \n";

    //includes
    include_once "database.php";

    //variables
    const STATE_URL = [
        "Common" => "/v1/user/essinfo/common",
        "Home" => "/v1/user/essinfo/home",
        "SystemInfo" => "/v1/user/setting/systeminfo",
        "SettingBatt" => "/v1/user/setting/batt",
        "InstallerSettingBatt" => "/v1/installer/setting/batt",
        "InstallerSettingPv" => "/v1/installer/setting/pv",
        "InstallerSettingPcs" => "/v1/installer/setting/pcs",
    ];

    //API loop that runs every 20 seconds and updates the DATA file
    while (true) {
        sleep(30);
        echo "API ping at " . date("Y-m-d H:i:s") . "\n";

        $configFile = __DIR__ . "/../DATA/config.json";
        $dataFile = __DIR__ . "/../DATA/data.json";

        //check if config file exists, if not restart the script
        if (!file_exists($configFile)) {
            echo "config file not found \n";
            continue;
        }

        //read config file
        $config = json_decode(file_get_contents($configFile), true);

        //get the config values from the config file
        $ip = $config["ip"];
        $register_key = $config["installerKey"];
        $saveData = $config["recordData"];

        if ($ip == "" || $register_key == "") {
            echo "config file is empty \n";
            continue;
        }

        //gets the authKey
        $auth = auth($register_key, $ip);
        if ($auth["auth_key"] == "") {
            echo "authKey is empty \n";
            continue;
        }

        //loop through all state_urls and make a big list of all the DATA
        $data = [];
        foreach (STATE_URL as $key => $url) {
            $data[$key] = getRequest($url, $auth["auth_key"], $ip);
        }

        //if saveData is true, save the current DATA in dataFile to a sql database (database.php)
        if ($saveData) {
            SQL::writeData($data);
        }

        file_put_contents($dataFile, "");
        file_put_contents(
            $dataFile,
            "last updated:" . date("Y-m-d H:i:s") . ";" . json_encode($data)
        );
    }

    //get an auth key from the inverter to access the DATA
    function auth($key, $ip): mixed
    {
        $data = ["password" => $key];

        $payload = json_encode($data);
        $ch = curl_init("https://" . $ip . "/v1/login");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:application/json"]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Skip SSL Verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Skip SSL Verification

        $response = curl_exec($ch);
        $error_message = curl_error($ch);
        if (!empty($error_message)) {
            die("error: " . $error_message);
        }

        $responseEncoded = json_decode($response, true);

        curl_close($ch);

        if (curl_errno($ch)) {
            echo "Error: " . curl_error($ch);
            exit();
        }

        return $responseEncoded;
    }

    function getRequest(string $url, mixed $auth_key, mixed $ip)
    {
        $data = ["auth_key" => $auth_key];

        $options = [
            "http" => [
                "method" => "POST",
                "header" =>
                    "Content-Type: application/json\r\n" . "Host: " . $ip . "\r\n",
                "ignore_errors" => true,
                "content" => json_encode($data),
            ],
            "ssl" => ["verify_peer" => false, "verify_peer_name" => false],
        ];

        $requestedURL = "https://" . $ip . $url;
        $context = stream_context_create($options);
        $response = @file_get_contents($requestedURL, false, $context);

        if (!$response) {
            return Exception("Request filed");
        }

        return json_decode($response, true);
    }