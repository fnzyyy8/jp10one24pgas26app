<?php

namespace App\Exceptions\Project;

use Exception;

class ProjectHasBoqException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Terdapat BOQ pada Project'
        );
    }
}
