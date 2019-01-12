<?php

    // Get POST data
    $code = file_get_contents('php://input');

    // Create Container
    $container = exec('docker create --cap-drop=ALL --cpus=1 --memory=16m --net=none --pids-limit=20 --security-opt=no-new-privileges --interactive gbs3');

    // Save Code to Script File
    file_put_contents('/scripts/' . $container . '.gbs', $code);  

    // Copy Script into Container
    exec('docker cp /scripts/' . $container . '.gbs ' . $container . ':script.gbs');

    // Delete Script File
    unlink('/scripts/' . $container . '.gbs');

    // Schedule Remove of Container (remove www-data from: etc\at.deny)
    exec('echo "sleep 5;docker container rm ' . $container . ' --force" | at now');

    // Start Container 
    passthru('docker start --attach --interactive ' . $container);

?>
