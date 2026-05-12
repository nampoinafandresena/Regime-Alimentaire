<?php

if (!function_exists('getIMCCategory')) {
    function getIMCCategory($imc) {
        if($imc < 18.5) return "Insuffisant";
        if($imc < 25) return "Normal";
        if($imc < 30) return "Surpoids";
        return "Obésité";
    }
}