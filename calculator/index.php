<?php
function cot($x) {
    return 1 / tan($x);
}

function calculate($val) {
    if (strlen($val) == 0) return 0;

    $val = "0+" . $val;
    $val = str_replace([' ', '--', '+-', '-+', '++'], ['', '+', '-', '-', '+'], $val);

    while (preg_match('/([a-z]+)\((-?\d+\.?\d*)\)/i', $val, $matches)) {
        $function = strtolower($matches[1]);
        $degrees = (double) $matches[2];
        $result = 0;

        switch ($function) {
            case 'sin':
                $result = sin(deg2rad($degrees));
                break;
            case 'cos':
                $result = cos(deg2rad($degrees));
                break;
            case 'tan':
                $result = tan(deg2rad($degrees));
                break;
            case 'cot':
                $result = cot(deg2rad($degrees));
                break;
            default:
                return "Unknown function: $function";
        }

        $val = preg_replace('/' . preg_quote($matches[0], '/') . '/', $result, $val, 1);
    }

    while (preg_match('/(-?\d+\.?\d*)([\/\*])(-?\d+\.?\d*)/', $val, $matches)) {
        $left = (double) $matches[1];
        $operator = $matches[2];
        $right = (double) $matches[3];
        $newVal = $operator === '*' ? $left * $right : ($right === 0 ? "division by zero" : $left / $right);
        if (is_string($newVal)) return $newVal;
        $val = preg_replace('/' . preg_quote($matches[0], '/') . '/', $newVal, $val, 1);
    }

    while (preg_match('/(-?\d+\.?\d*)([\+\-])(-?\d+\.?\d*)/', $val, $matches)) {
        $left = (double) $matches[1];
        $operator = $matches[2];
        $right = (double) $matches[3];
        $newVal = $operator === '+' ? $left + $right : $left - $right;
        $val = preg_replace('/' . preg_quote($matches[0], '/') . '/', $newVal, $val, 1);
    }

    return $val;
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