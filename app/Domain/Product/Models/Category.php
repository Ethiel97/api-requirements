<?php

namespace App\Domain\Product\Models;


enum Category: string
{
    case Insurance = 'insurance';
    case Vehicle = 'vehicle';
}
