<?php 
    if (isset($_POST['num'])) {
        $num = $_POST['input'] . $_POST['num'];
    } else {
        $num = isset($_POST['input']) ? $_POST['input'] : "";
    }

    if (isset($_POST['op'])) {
        if (!empty($num)) {
            $num = $num . $_POST['op'];
        }
    }

    function evaluate($expr) {
        $expr = str_replace(' ', '', $expr);
        return parseExpression($expr);
    }
    
    function parseExpression($expr) {
        while (strpos($expr, '(') !== false) {
            $start = strrpos($expr, '(');
            $end = strpos($expr, ')', $start);
            if ($end === false) return "Ошибка: неверные скобки";
    
            $inner = substr($expr, $start + 1, $end - $start - 1);
            $value = parseExpression($inner);
            $expr = substr_replace($expr, $value, $start, $end - $start + 1);
        }
    
        $pattern = '/(-?\d+(\.\d+)?)([\+\-])(\d+(\.\d+)?)/';
        while (preg_match($pattern, $expr, $matches)) {
            $left = $matches[1];
            $op = $matches[3];
            $right = $matches[4];
            $result = ($op === '+') ? $left + $right : $left - $right;
            $expr = preg_replace($pattern, $result, $expr, 1);
        }
        $pattern = '/(-?\d+(\.\d+)?)([\*\/])(-?\d+(\.\d+)?)/';
        while (preg_match($pattern, $expr, $matches)) {
            $left = $matches[1];
            $op = $matches[3];
            $right = $matches[4];
            if ($op === '*' || $op === '/') {
                if ($op === '/' && $right == 0) return "Ошибка: деление на 0";
                $result = ($op === '*') ? $left * $right : $left / $right;
                $expr = preg_replace($pattern, $result, $expr, 1);
            }
        }
    
        return is_numeric($expr) ? $expr : "Ошибка";
    }
    if (isset($_POST['equal'])) {
        $allowed_chars = "0123456789+-*/().";
    
        $is_valid = true;
        for ($i = 0; $i < strlen($num); $i++) {
            if (strpos($allowed_chars, $num[$i]) === false) {
                $is_valid = false;
                break;
            }
        }
    
        if (!$is_valid) {
            $num = "Ошибка";
        } else {
            $num = evaluate($num);
        }
    }
    

    if (isset($_POST['clear'])) {
        $num = "";
    }

    if (isset($_POST['delete'])) {
        $num = substr($num, 0, -1);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <style>
        body {
            background-color: rgb(139, 139, 139);
        }
        .calc {
            margin: auto;
            background-color: black;
            border: 2px solid whitesmoke;
            width: 360px;
            height: 35rem;
            border-radius: 20px;
            box-shadow: 10px 10px 40px;
        }
        .main_input {
            background-color: black;
            border: 1px solid grey;
            height: 5rem;
            margin-top: 1.2rem;
            margin-left: 1px;
            width: 328px;
            color: white;
            font-weight: 300;
            font-size: 2rem;
            padding-left: 26px;
        }
        .numbtn {
            padding: 26px 30px;
            border-radius: 50px;
            width: 80px;
            height: 80px;
            font-weight: 600;
            font-size: x-large;
            color: white;
            background-color: rgb(63, 63, 63);
            border: black 1px solid;
            transition: 0.2s linear;
        }
        .numbtn:hover {
            background-color: rgba(129, 129, 129, 0.675);
        }
        .equal {
            padding: 26px 30px;
            border-radius: 50px;
            width: 80px;
            height: 80px;
            font-weight: 600;
            font-size: x-large;
            color: white;
            background-color: rgb(63, 63, 63);
            border: black 1px solid;
            transition: 0.2s linear;
        }
        .equal:hover {
            background-color: rgba(129, 129, 129, 0.675);
        }
        .calbtn_up {
            padding: 26px;
            border-radius: 50px;
            width: 80px;
            height: 80px;
            font-weight: 600;
            font-size: x-large;
            color: white;
            background-color: grey;
            border: black 1px solid;
            transition: 0.2s linear;
        }
        .calbtn_up:hover {
            background-color: rgba(191, 191, 191, 0.899);
        }
        .calbtn {
            color: white;
            padding: 26px;
            border-radius: 50px;
            width: 80px;
            height: 80px;
            font-weight: 600;
            font-size: x-large;
            border: black 1px solid;
        }
        .calbtn_right {
            padding: 26px;
            border-radius: 50px;
            width: 80px;
            height: 80px;
            font-weight: 600;
            font-size: x-large;
            color: white;
            background-color: orange;
            border: black 1px solid;
            transition: 0.2s linear;
        }
        .calbtn_right:hover {
            background-color: rgb(254, 200, 73);
        }
        .delete {
            color: white;
            padding: 26px;
            padding-left: 16px;
            border-radius: 50px;
            width: 80px;
            height: 80px;
            font-weight: 600;
            font-size: x-large;
            background-color: grey;
            border: black 1px solid;
        }
        .delete:hover {
            background-color: rgba(191, 191, 191, 0.899);
        }
        .clear {
            color: white;
            padding: 26px;
            padding-left: 20px;
            border-radius: 50px;
            width: 80px;
            height: 80px;
            font-weight: 600;
            font-size: x-large;
            background-color: orange;
            border: black 1px solid;
        }
        .clear:hover {
            background-color: rgb(254, 200, 73);
        }
        .wrap {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 3px;
        }
    </style>
</head>
<body>
    <div class="calc">
        <form action="" method="post">
            <input type="text" class="main_input" name="input" value="<?php echo @$num ?>"> <br> <br>
            <div class="wrap">
                
                <input type="submit" class="delete" name="delete" value="DEL">
                <input type="submit" class="calbtn_up" name="op" value="+">
                <input type="submit" class="calbtn_up" name="op" value="-">
                <input type="submit" class="calbtn_right" name="op" value="/"> <br>
                <input type="submit" class="numbtn" name="num" value="7">
            
                <input type="submit" class="numbtn" name="num" value="8">
                <input type="submit" class="numbtn" name="num" value="9">
                <input type="submit" class="calbtn_right" name="op" value="*"><br>
                <input type="submit" class="numbtn" name="num" value="4"> 
                <input type="submit" class="numbtn" name="num" value="5">
            
                <input type="submit" class="numbtn" name="num" value="6">
                <input type="submit" class="calbtn_right" name="num" value="("><br>
                <input type="submit" class="numbtn" name="num" value="1">
                <input type="submit" class="numbtn" name="num" value="2">
                <input type="submit" class="numbtn" name="num" value="3">
            
            
                <input type="submit" class="calbtn_right" name="num" value=")"><br>
                <input type="submit" class="numbtn" name="num" value="."> 
                <input type="submit" class="numbtn" name="num" value="0">
                <input type="submit" class="equal" name="equal" value="=">
                <input type="submit" class="clear" name="clear" value="AC">
            
            </div>
        </form>
    </div>
</body>
</html>