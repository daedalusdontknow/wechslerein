<?php
/*
* Wechslerein
*
* (c) 2023 Philipp Gonitianer (aka. daedalusdontknow)
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

    echo "Upgrade started...";

    $files = glob('../styles/*');
    foreach($files as $file){
        if(is_file($file))
            unlink($file);
    }
    $files = glob('../panel/*');
    foreach($files as $file){
        if(is_file($file))
            unlink($file);
    }
    $files = glob('../media/*');
    foreach($files as $file){
        if(is_file($file))
            unlink($file);
    }
    $files = glob('../API/*');
    foreach($files as $file){
        if($file == "../API/upgrade.php")
            continue;
        if(is_file($file))
            unlink($file);
    }

    echo "Files deleted...";
    echo "Downloading new files...";

    //get the latest release from github and download it to the root directory of the project (https://github.com/daedalusdontknow/wechslerein/archive/refs/heads/main.zip)
    $url = "https://github.com/daedalusdontknow/wechslerein/archive/refs/heads/main.zip";
    $zip_file = "main.zip";
    $zip_resource = fopen($zip_file, "w");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FILE, $zip_resource);
    $page = curl_exec($ch);
    if(!$page) {
        echo "Error :- ".curl_error($ch);
    }
    curl_close($ch);
    fclose($zip_resource);

    echo "Download finished...";
    echo "Unzipping files...";

    //unzip the downloaded file
    $zip = new ZipArchive;
    $res = $zip->open($zip_file);
    if ($res === TRUE) {
        $zip->extractTo('../');
        $zip->close();
        echo 'File unzipped';
    } else {
        echo 'failed';
    }

    //delete the downloaded zip file
    unlink($zip_file);

    //rename the new files
    rename("../wechslerein-main", "../wechslerein");

    echo "Upgrade finished!";