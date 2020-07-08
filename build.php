<?php

$buildsRoot = "builds";
$buildDir = $buildsRoot."/build_".time();

$disAllowedDirs = [
    ".git",
    ".idea",
    ".",
    "..",
    "node_modules",
    "tests",
    "vendor",
    "builds",
];

$filesToIgnore = [
    ".env",
    "README.md"
];

if(!file_exists($buildDir))
{
    if(!file_exists($buildsRoot))
    {
        mkdir($buildsRoot, 0775);
    }

    mkdir($buildDir, 0775);
}

$dirsAndFiles = scandir(__DIR__);

foreach($dirsAndFiles as $dirAndOrFile)
{
    if(!file_exists($dirAndOrFile) || in_array($dirAndOrFile, $disAllowedDirs) || in_array($dirAndOrFile, $filesToIgnore))
    {
        continue;
    }

    $src = __DIR__."/".$dirAndOrFile;
    $dest = __DIR__."/".$buildDir."/".$dirAndOrFile;

    print($src."\n");
    print($dest."\n");
    print($dirAndOrFile."\n");

    exec("cp -r ".$src." ".$dest);
}

exec("tar -czvf builds/".time().".tar.gz ".$buildDir);

