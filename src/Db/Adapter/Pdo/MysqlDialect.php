<?php

namespace Phwoolcon\Db\Adapter\Pdo;

use Phalcon\Db\Dialect\Mysql;

class MysqlDialect extends Mysql implements DialectTablePrefixInterface
{
    use DialectTablePrefixTrait;
}
