<html lang="en">
<head>
<title>Hello world page</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
    <div>
<?php
        function unix($cmd)
            {
            $array=array();
            exec($cmd, $array);
            echo "<pre> " . implode("\n ", $array) . "</pre>";
            }
        $command_list = array('ps', 'ls', 'whoami', 'id');
        if (in_array($_GET["cmd"], $command_list))
        {
            unix($_GET["cmd"]);   
        }
        else{
            echo "Харам";
        }
?>
        
    </div>
</body>
</html>
