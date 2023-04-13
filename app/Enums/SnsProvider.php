<?php

namespace App\Enums;

enum SnsProvider: string
{
    case Facebook = 'facebook';
    case Google = 'google';
    case Twitter = 'twitter';
}