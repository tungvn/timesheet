<?php

namespace App\Timesheets\Passport;

use App\Timesheets\Traits\HasUuid;
use Laravel\Passport\Client as PassportClient;

class Client extends PassportClient
{
    use HasUuid;
}
