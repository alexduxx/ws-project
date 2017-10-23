<?php

function escape($string) {
    return htmlentities($string, ENT_QUOTES, 'UTF-8'); //Will convert both double and single quotes.
}

 
