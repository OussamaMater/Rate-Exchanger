<?php

use Oussamamater\RateExchanger\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function getFixture($filename)
{
    return file_get_contents(__DIR__.'/fixtures/'.$filename);
}
