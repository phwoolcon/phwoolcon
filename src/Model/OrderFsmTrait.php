<?php
namespace Phwoolcon\Model;

use Phalcon\Di;
use Phwoolcon\Events;
use Phwoolcon\Exception\OrderException;
use Phwoolcon\Fsm\StateMachine;

trait OrderFsmTrait
{
    /**
     * @var StateMachine
     */
    protected $fsm;
    protected $fsmTransitions = [
        Order::STATUS_PENDING => [
            'prepare' => Order::STATUS_PENDING,
            'confirm' => Order::STATUS_PROCESSING,
            'complete' => Order::STATUS_COMPLETE,
            'cancel' => Order::STATUS_CANCELING,
            'fail' => Order::STATUS_FAILED,
        ],
        Order::STATUS_PROCESSING => [
            'complete' => Order::STATUS_COMPLETE,
            'cancel' => Order::STATUS_CANCELING,
            'fail' => Order::STATUS_FAILED,
        ],
        Order::STATUS_CANCELING => [
            'complete' => Order::STATUS_COMPLETE,
            'confirm_cancel' => Order::STATUS_CANCELED,
        ],
    ];

    public function canCancel()
    {
        return $this->getFsm()->canDoAction('cancel');
    }

    public function canComplete()
    {
        return $this->getFsm()->canDoAction('complete');
    }

    public function canConfirm()
    {
        return $this->getFsm()->canDoAction('confirm');
    }

    public function canConfirmCancel()
    {
        return $this->getFsm()->canDoAction('confirm_cancel');
    }

    public function canFail()
    {
        return $this->getFsm()->canDoAction('fail');
    }

    public function canPrepare()
    {
        return $this->getFsm()->canDoAction('prepare');
    }

    public function complete($comment = null)
    {
        if ($this->canComplete()) {
            throw new OrderException(__('Order has been completed'), OrderException::ERROR_CODE_ORDER_COMPLETED);
        }
        $status = $this->getFsm()->doAction('complete');
        $this->resetCallbackStatus()
            ->setData('completed_at', time())
            ->setData('cash_paid', $this->getData('cash_to_pay'))
            ->setData('cash_to_pay', 0)
            ->updateStatus($status, $comment ?: __('Order complete'))
            ->refreshFsmHistory();
    }

    /**
     * @return StateMachine
     */
    public function getFsm()
    {
        if (!$this->fsm) {
            $this->fsm = StateMachine::create($this->fsmTransitions, $this->getFsmHistory());
        }
        return $this->fsm;
    }

    public function getFsmHistory()
    {
        return $this->getOrderData('fsm_history');
    }

    /**
     * @return array
     */
    public function getFsmTransitions()
    {
        return $this->fsmTransitions;
    }

    public static function prepare($data)
    {
        /* @var Order $order */
        $order = Di::getDefault()->get(Order::class);
        foreach ($order->requiredFieldsOnPreparation as $field) {
            if (empty($data[$field])) {
                throw new OrderException(__('Invalid %field%', [
                    'field' => $field,
                ]), OrderException::ERROR_CODE_BAD_PARAMETERS);
            }
        }
        // Load existing order if any
        if ($existingOrder = $order->getByTradeId($data['trade_id'], $data['client_id'])) {
            $order = $existingOrder;
            if (!$order->canPrepare()) {
                throw new OrderException(__('Order "%trade_id%" is %status%, please do not submit repeatedly', [
                    'trade_id' => $data['trade_id'],
                    'status' => $order->getStatus(),
                ]), OrderException::ERROR_CODE_ORDER_PROCESSING);
            }
        }

        // Fire before_prepare_order_data event
        $data = Events::fire('order:before_prepare_order_data', $order, $data) ?: $data;

        // Filter protected fields
        foreach ($order->protectedFieldsOnPreparation as $field) {
            unset($data[$field]);
        }

        // Remove objects in $data
        foreach ($data as $k => $v) {
            // @codeCoverageIgnoreStart
            if (is_object($v)) {
                unset($data[$k]);
            };
            // @codeCoverageIgnoreEnd
        }

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
        $order->setOrderData($data)
            ->updateStatus($order->getFsm()->getCurrentState(), __('Order initialized'))
            ->refreshFsmHistory();
        return $order;
    }

    public function refreshFsmHistory()
    {
        $this->setOrderData('fsm_history', $this->getFsm()->getHistory());
        return $this;
    }

    /**
     * @return Order
     */
    public function resetCallbackStatus()
    {
        $this->setData('callback_status', '');
        return $this;
    }

    /**
     * @param array $fsmTransitions
     * @return $this
     */
    public function setFsmTransitions(array $fsmTransitions)
    {
        $this->fsmTransitions = $fsmTransitions;
        return $this;
    }
}
