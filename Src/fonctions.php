<?php
function Captcha(){
    $numbers=range(0,9);
    shuffle($numbers);

    $highlightednumbers=$numbers[array_rand($numbers)];
    $_SESSION['captcha']=$highlightednumbers;

    $l = '<div style="display: flex; gap=10px;">';
    foreach($numbers as $number){
        if($number==$highlightednumbers){
            $l.="<span style='font-weight: bold; color:red'>$number</span>";

        }else{
            $l.="<span>$number</span>";
        }

    }
    $l.="</div>";
    return $l;
}