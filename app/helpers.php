<?php
//function test()
//{
//    echo '<br>Text from first test function00 (file app/helpers.php)<br>';
//}

if (! function_exists('test')) {
    function test()
    {
        echo '! function_exists - test function01 (internal) (file app/helpers.php)';
    }
}
/*if (! function_exists('__')) {
    function __($key)
    {
       // echo '<br>__________________ function00 (file app/helpers.php)<br>';
        //return $key.'11';
    }
}*/
