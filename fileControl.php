<?php

    $fileType = ['png', 'jpg', 'jpeg'];

    function convertFileSize($measure, $MEASURE_DATA_SI_SYSTEM){
        $conv = 0;
        switch($MEASURE_DATA_SI_SYSTEM){
            case 'B':   // Bytes
                $conv = 1;
                break;
            case "kB":  // kilobytes
                $conv = 1000;
                break;
            case "MB":  // Megabytes
                $conv = 1e6;
                break;
            case "GB":  // Gigabytes
                $conv = 1e9;
                break;
            case "TB":  // Terabytes
                $conv = 1e12;
                break;
            default:
                $conv = 1;
                break;
        }
        return floor($measure * $conv);
    }

    /**
     *  READ THE DOCUMENTATION BELOW
     * 
     *  fileControl.php function and variables
     * 
     *  f convertImageSize(int| float $measure, string $SI_DATA_MEASUREMENT_ABBR_SYSTEM) : int
     *      returns in Bytes.
     * 
     *    ex: * convertImageSize(512, "kB"); // 512000
     *        * convertImageSize(512);       // 512
     *         
     */