<?php

namespace App\Exceptions\ProjectControl;

use Exception;

class BoqHasPlanException extends Exception
{
    public function __construct()
    {
        parent::__construct("Terdapat Plan pada Boq");
    }
}
