<?php

$root = getcwd();
$dirs = array_values(array_diff(scandir($root), array(".", "..")));
echo "\n " . str_repeat("-", 77) . "\n";
echo " | " . str_pad("FOLDER", 50) . " | " . str_pad("ACTION", 20) . " |\n";
echo " " . str_repeat("-", 77) . "\n";
foreach ($dirs as $dir)
{
    $path = $root . "/" . $dir;
    if (is_dir($path))
    {
        chdir($path);
        if (is_dir($path . "/" . ".git"))
        {
            $msgs = array();
            ob_start();
            system("git status 2>&1", $return);
            $output = ob_get_clean();
            if(ob_get_length())
            {
                ob_end_clean();
            }
            if (strstr($output, "Changes not staged for commit"))
            {
                $msgs[] = "add";
            }
            if (strstr($output, "Changes to be commited"))
            {
                $msgs[] = "commit";
            }
            if (strstr($output, "Your branch is ahead"))
            {
                $msgs[] = "push";
            }
            if (strstr($output, "Your branch is behind"))
            {
                $msgs[] = "pull";
            }
            if (count($msgs))
            {
                $msg = join(", ", $msgs);
                echo " | " . str_pad($dir, 50) . " | " . str_pad($msg, 20) . " |\n";
                echo " " . str_repeat("-", 77) . "\n";
            }
        }
    }
}
