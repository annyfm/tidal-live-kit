#!/usr/bin/env php
<?php
$here = __DIR__;

array_map("unlink", glob("$here/samples/*"));

$csv = fopen("$here/samples.csv", "r");
$headings = fgetcsv($csv);

while ($data = fgetcsv($csv)) {
    $row = array_combine($headings, $data);
    $from = $row["Sample Path"] . "/samples/" . $row["Original Bank"];
    $to = "$here/samples/" . $row["New Bank"];
    if (is_link($to)) {
        throw new Exception("$to exists");
    }
    symlink($from, $to);
}

fclose($csv);
