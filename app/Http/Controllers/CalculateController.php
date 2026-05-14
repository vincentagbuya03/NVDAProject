<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculateController extends Controller
{

    public function sum (){
        $a = 3;
        $b = 5;
        return "Sum = ".$a + $b;
    }

    public function subtract (){
        $a = 3;
        $b = 5;
        return "Difference = ".$a - $b;
    }

    public function multiply (){
        $a = 3;
        $b = 5;
        return "product  = ".$a * $b;
    }

    public function divide (){
        $a = 3;
        $b = 5;
        return "Qoutient = ".$a / $b;
    }
    public function reminder (){
        $a = 3;
        $b = 5;
        return "Reminder = ".$a % $b;
    }
}
