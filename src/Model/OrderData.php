<?php
namespace Phwoolcon\Model;

use Phwoolcon\Model;

/**
 * Class OrderData
 * @package Phwoolcon\Model
 */
class OrderData extends Model
{
    protected $_table = 'order_data';
    protected $_pk = 'order_id';
    protected $_jsonFields = ['request_data', 'data', 'status_history'];
    public $data;
}
