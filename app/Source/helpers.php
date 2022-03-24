<?php

use App\Source\Atom\Database;

function fragment(string $name)
{
    include __DIR__ . "/../fragments/$name.php";
}

function foot()
{
    fragment('footer');
}

function head()
{
    fragment('header');
}

function model(string $tableName)
{

    return new App\Source\Atom\Model($tableName);
}

function dd($value)
{
    die(var_dump($value));
}

function env($variableName)
{
   $contents=file_get_contents(__DIR__ . "/../../.env");
    preg_match("/$variableName=.*/",$contents,$matches);
    return explode("=",$matches[0])[1];

}