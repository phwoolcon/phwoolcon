<?php
namespace Phwoolcon\Model;

use Phalcon\Di;
use Phwoolcon\Events;
use Phwoolcon\Exception\OrderException;
use Phwoolcon\Model;

/**
 * Class Order
 * @package Phwoolcon\Model
 *
 * @property Di     $_dependencyInjector
 * @property string $status
 * @method string getStatus()
 * @method string getTradeId()
 * @method Order setStatus(string $status)
 */
class Order extends Model
{
    const STATUS_CANCELED = 'canceled';
    const STATUS_COMPLETE = 'complete';
    const STATUS_FAILED = 'failed';
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';

    const CALLBACK_STATUS_DONE = 'done';
    const CALLBACK_STATUS_FAILED = 'failed';
    const CALLBACK_STATUS_TRIED = 'tried';

    protected $_table = 'orders';
    protected $keyFields = [
        'product_name',
        'user_id',
        'amount',
    ];

    protected $protectedFieldsOnPreparation = [
        'id',
        'txn_id',
        'created_at',
        'completed_at',
        'status',
    ];

    protected $orderData;

    /**
     * @return $this
     * @codeCoverageIgnore
     */
    public function generateDistributedId()
    {
        return $this->generateOrderId('NA');
    }

    public function generateOrderId($prefix = '')
    {
        $orderId = $prefix . (date('Y') - 2004) . date('md') . substr(time(), -5) . substr(microtime(), 2, 3) .
            static::$_distributedOptions['node_id'] . mt_rand(100, 999);
        $hasOrderId = $this->findFirst([
            'id = :id:',
            'bind' => [
                'id' => $orderId,
            ],
        ]);
        // @codeCoverageIgnoreStart
        if ($hasOrderId) {
            return $this->generateOrderId($prefix);
        }
        // @codeCoverageIgnoreEnd
        $this->setId($orderId);
        return $this;
    }

    public function getByTradeId($tradeId, $clientId)
    {
        return $this->findFirst([
            'trade_id = :tradeId: AND client_id = :clientId:',
            'bind' => compact('tradeId', 'clientId'),
        ]);
    }

    public function getKeyFields()
    {
        $fields = array_values($this->keyFields);
        return array_combine($fields, $fields);
    }

    /**
     * @param string $key
     * @return mixed|OrderData
     */
    public function getOrderData($key = null)
    {
        if ($this->orderData === null) {
            if ($existingOrderData = $this->__get('order_data')) {
                $this->orderData = $existingOrderData;
            } else {
                $this->orderData = $this->_dependencyInjector->get(OrderData::class);
                $this->__set('order_data', $this->orderData);
            }
        }
        $data = $this->orderData->getData('data');
        return $key ? fnGet($data, $key) : $this->orderData;
    }

    public function getProtectedFieldsOnPreparation()
    {
        return $this->protectedFieldsOnPreparation;
    }

    public function initialize()
    {
        $class = OrderData::class;
        $this->_dependencyInjector->has($class) and $class = $this->_dependencyInjector->getRaw($class);
        $this->hasOne('id', $class, 'order_id', ['alias' => 'order_data']);
        parent::initialize();
    }

    public static function prepareOrder($data)
    {
        /* @var Order $order */
        $order = Di::getDefault()->get(static::class);
        // Load existing order if any
        $existingOrder = $order->getByTradeId(fnGet($data, 'trade_id'), fnGet($data, 'client_id'));
        if (isset($existingOrder->id)) {
            $order = $existingOrder;
            $status = $order->getStatus();
            if ($status != static::STATUS_PENDING) {
                $failureMessages = [
                    static::STATUS_PROCESSING => 'Order is under processing, please do not submit repeatedly',
                    static::STATUS_COMPLETE => 'Order has been completed, please do not submit repeatedly',
                    static::STATUS_CANCELED => 'Order has been canceled, please do not submit repeatedly',
                    static::STATUS_FAILED => 'Order has been failed, please do not submit repeatedly',
                ];
                $message = isset($failureMessages[$status]) ? $failureMessages[$status] :
                    $failureMessages[static::STATUS_PROCESSING];
                throw new OrderException(__($message), OrderException::ERROR_CODE_ORDER_PROCESSING);
            }
        }

        // Fire before_prepare_order_data event
        $data = Events::fire('order:before_prepare_order_data', $order, $data) ?: $data;

        // Filter protected fields
        foreach ($order->getProtectedFieldsOnPreparation() as $field) {
            unset($data[$field]);
        }

        // Remove objects in $data
        $objectKeys = [];
        foreach ($data as $k => $v) {
            is_object($v) and $objectKeys[] = $k;
        }
        // @codeCoverageIgnoreStart
        foreach ($objectKeys as $key) {
            unset($data[$key]);
        }
        // @codeCoverageIgnoreEnd

        // Verify order data
        $amount = $data['amount'] = fnGet($data, 'amount') * 1;
        if ($amount <= 0) {
            throw new OrderException(__('Invalid order amount'), OrderException::ERROR_CODE_BAD_PARAMETERS);
        }
        $cashToPay = fnGet($data, 'cash_to_pay', $amount);
        if ($cashToPay < 0) {
            throw new OrderException(__('Invalid order cash to pay'), OrderException::ERROR_CODE_BAD_PARAMETERS);
        }
        $data['cash_to_pay'] = $cashToPay;

        // Set order attributes
        $keyFields = $order->getKeyFields();
        foreach ($order->toArray() as $attribute => $oldValue) {
            $newValue = fnGet($data, $attribute);
            if (isset($keyFields[$attribute]) && $oldValue && $oldValue != $newValue) {
                throw new OrderException(
                    __('Order crucial attribute [%attribute%] changed', compact('attribute')),
                    OrderException::ERROR_CODE_KEY_PARAMETERS_CHANGED
                );
            }
            $newValue === null or $order->setData($attribute, $newValue);
        }

        // Fire after_prepare_order_data event
        $data = Events::fire('order:after_prepare_order_data', $order, $data) ?: $data;
        // Generate order id
        $order->getId() or $order->generateOrderId(fnGet($data, 'order_prefix'));
        unset($data['order_prefix']);
        $order->setOrderData($data);
        $order->updateStatus(static::STATUS_PENDING, __('Order initialized'));
        return $order;
    }

    public function setOrderData($key, $value = null)
    {
        $orderData = $this->getOrderData();
        $data = $orderData->getData('data') ?: [];
        if (is_array($key)) {
            $data = $key;
        } else {
            if (is_scalar($key)) {
                if ($value === null) {
                    unset($data[$key]);
                } else {
                    $data[$key] = $value;
                }
            }
        }

        $orderData->setData('data', $data);
        return $this;
    }

    /**
     * @param array $keyFields
     * @return $this
     * @codeCoverageIgnore
     */
    public function setKeyFields($keyFields)
    {
        $this->keyFields = $keyFields;
        return $this;
    }

    /**
     * @param array $protectedFieldsOnPreparation
     * @return $this
     * @codeCoverageIgnore
     */
    public function setProtectedFieldsOnPreparation($protectedFieldsOnPreparation)
    {
        $this->protectedFieldsOnPreparation = $protectedFieldsOnPreparation;
        return $this;
    }

    public function updateStatus($status, $comment)
    {
        $this->setStatus($status);
        $orderData = $this->getOrderData();
        $statusHistory = $orderData->getData('status_history') ?: [];
        $time = explode(' ', microtime());
        $statusHistory[$time[1] . substr($time[0], 1)] = [
            'status' => $status,
            'comment' => $comment,
        ];
        $orderData->setData('status_history', $statusHistory);
        return $this;
    }
}
