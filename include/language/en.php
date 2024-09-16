<?php

namespace RockGuard\include\language;

/*

   @team rockguard

    THIS ENG FILE

*/

function lang($word)
{

    static $arr = [

        // Navbar page
        'home'        =>  'Home',

        //
    ];

    return $arr[$word];
}
