<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/23/2017
 * Time: 4:28 PM
 */

class OpenDirectory
{
    public static function getFileList($dir)
    {
        // array to hold return value
        $retrievedFiles = array();

        // add trailing slash if missing
        if (substr($dir, -1) != "/") $dir .= "/";

        // open pointer to directory and read list of files
        $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
        while (false !== ($entry = $d->read())) {
            // skip hidden files
            if ($entry[0] == ".") continue;
            if (is_dir("$dir$entry")) {
                $retrievedFiles[] = array(
                    "name" => "$dir$entry/",
                    "type" => filetype("$dir$entry"),
                    "size" => 0,
                    "lastmod" => filemtime("$dir$entry")
                );
            } elseif (is_readable("$dir$entry")) {
                $file_parts = pathinfo("$dir$entry");
                if ($file_parts['extension'] == "xlsx") {
                    $name = preg_replace("/\..+/", "", $entry);
                    $size = floor(filesize("$dir$entry") / 1024);
                    $retrievedFiles[] = array(
                        "name" => "$name",
                        "type" => mime_content_type("$dir$entry"),
                        "size" => $size . 'Kb',
                        "lastmod" => filemtime("$dir$entry")
                    );
                }
            }
        }
        $d->close();

        return $retrievedFiles;
    }
}