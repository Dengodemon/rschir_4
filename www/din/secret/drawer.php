<html lang="en">
<head>
<title>Hello world page</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
</head>
<body>
    <div class="fig">
    <?php
        $number = $_GET['num'];
        $shape = ($number >> 5) & 3; // 00-круг 01-прямоуг 10-квадр 11-треуг
        $r =      ($number >> 4) & 1;
        $g =    ($number >> 3) & 1;
        $b =     ($number >> 2) & 1;
        $size =    (($number >> 0) & 3) + 1; // 00-мал 01-сред 10-бол 11-огр
        $size *= 50;
        // HEX цвет
        $color = '"#'
            . ($r == 1    ? 'ff' : "00")
            . ($g == 1  ? 'ff' : "00")
            . ($b == 1   ? 'ff' : "00") . '"';
        $radius = ($size / 2);
        if ($shape == 0) {
            $shape_tag = "circle "
            // Размер
            . " cx=" . ($radius + 10) . " cy=" . ($radius + 10)
            // Радиус
            . " r=" . $radius . " ";
            echo '<svg>';
            echo '<' . $shape_tag . ' fill=' . $color . '  />';
            echo '</svg>';
        }
        else if ($shape==1) {
            $shape_tag = "rect "
            // Размер
            . "width=" . ($size * 2) . " height=" . ($size);
            echo '<svg>';
            echo '<' . $shape_tag . ' fill=' . $color . ' />';
            echo '</svg>';
        }
        else if ($shape==2) {
            $shape_tag = "rect "
            // Размер
            . "width=" . ($size) . " height=" . ($size);
            echo '<svg>';
            echo '<' . $shape_tag . ' fill=' . $color . ' />';
            echo '</svg>';
        }
        else if ($shape==3) {
            $side = $size;
            $shape_tag = "polygon points='"
                // Точки
                . ($side / 2 + 5) . ",10"
                . " 10," . ($side) . " "
                . ($side) . "," . ($side) . "'";
            echo '<svg>';
            echo '<' . $shape_tag . ' fill=' . $color . ' />';
            echo '</svg>';
        }
    ?>
    </div>
</body>
</html>
