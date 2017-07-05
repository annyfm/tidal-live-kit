#!/usr/bin/env php
<?php
$here = __DIR__;

array_map("unlink", glob("$here/samples/*"));

$csv = fopen("$here/samples.csv", "r");
$headings = fgetcsv($csv);

while ($data = fgetcsv($csv)) {
    $row = array_combine($headings, $data);
    $from = $row["Project Path"] . "/samples/" . $row["Original Bank"];
    $from = str_replace("~", $_SERVER["HOME"], $from);
    $to = "$here/samples/" . $row["New Bank"];
    if (is_link($to)) {
        throw new Exception("$to exists");
    }
    symlink($from, $to);
}

fclose($csv);
