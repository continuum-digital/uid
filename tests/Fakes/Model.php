<?php

namespace Tests\Fakes;

use ContinuumDigital\Uid\Traits\HasUid;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    use HasUid;
}