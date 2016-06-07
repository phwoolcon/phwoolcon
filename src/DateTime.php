<?php
namespace Phwoolcon;

use DateTime as PhpDateTime;

class DateTime extends PhpDateTime
{
    const RFC2616 = 'D, d M Y H:i:s T';
    const MYSQL_DATETIME = 'Y-m-d H:i:s';
}
