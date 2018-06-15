<?php

namespace Phwoolcon\Db\Adapter\Pdo;

use Phalcon\Db\Dialect\Mysql as PhalconMysqlDialect;

class MysqlDialect extends PhalconMysqlDialect implements DialectTablePrefixInterface
{
    use DialectTablePrefixTrait;
}
