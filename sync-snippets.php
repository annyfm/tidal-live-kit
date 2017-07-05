#!/usr/bin/env php
<?php
$here = __DIR__;

array_map("unlink", glob("$here/snippets/haskell-mode/*"));

$csv = fopen("$here/samples.csv", "r");
$headings = fgetcsv($csv);

$projects = [];

while ($data = fgetcsv($csv)) {
    $row = array_combine($headings, $data);
    $projects[] = $row["Project Path"];
}

fclose($csv);

$projects = array_unique($projects);

foreach ($projects as $project) {
    $snippetsDir = "$project/snippets";
    if (is_dir($snippetsDir)) {
        $files = glob("$snippetsDir/*");
        foreach ($files as $file) {
            $to = "$here/snippets/haskell-mode/" . basename($file);
            if (is_link($to)) {
                throw new Exception("$to exists");
            }
            symlink($file, $to);
        }
    }
    else {
        printf("WARNING: Snippets path %s not found", $snippetsDir);
    }
}