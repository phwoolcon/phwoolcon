<?php
namespace Phwoolcon\Tests\Integration;

use Phwoolcon\Db;
use Phwoolcon\Exception\OrderException;
use Phwoolcon\Model\Order;
use Phwoolcon\Model\OrderData;
use Phwoolcon\Tests\Helper\TestCase;
use Phwoolcon\Tests\Helper\TestOrderModel;
use Phwoolcon\Tests\Helper\TestOrderDataModel;

class OrderModelTest extends TestCase
{

    /**
     * @return TestOrderModel
     */
    protected function getOrderModelInstance()
    {
        return $this->di->get(Order::class);
    }

    /**
     * @return TestOrderModel
     */
    protected function getTestOrder()
    {
        $order = $this->getOrderModelInstance();
        if ($tmp = $order->getByTradeId($tradeId = 'TEST-TRADE-ID', 'test_client')) {
            $order = $tmp;
        } else {
            $order = Order::prepareOrder([
                'order_prefix' => 'TEST',
                'amount' => '1',
                'trade_id' => $tradeId,
                'product_name' => 'Test product',
                'user_identifier' => 'Test User',
                'client_id' => 'test_client',
                'payment_agent' => 'alipay',
                'payment_method' => 'mobile_web',
                'currency' => 'CNY',
                'amount_in_currency' => '1',
            ]);
            $this->assertTrue($order->save(), $order->getStringMessages());
        }
        return $order;
    }

    public function setUp()
    {
        parent::setUp();
        Db::clearMetadata();
        $this->di->set(Order::class, TestOrderModel::class);
        $this->di->set(OrderData::class, TestOrderDataModel::class);
        $this->getOrderModelInstance()->delete();
    }

    public function testCreateOrder()
    {
        $tradeId = md5(microtime());

        // Fail if trade_id not set
        $e = null;
        try {
            Order::prepareOrder([
                'order_prefix' => 'TEST',
                'amount' => '1',
                'product_name' => 'Test product',
                'user_identifier' => 'Test User',
                'client_id' => 'test_client',
                'payment_agent' => 'alipay',
                'payment_method' => 'mobile_web',
                'currency' => 'CNY',
                'amount_in_currency' => '1',
            ]);
        } catch (OrderException $e) {
        }
        $this->assertInstanceOf(OrderException::class, $e);
        $this->assertEquals($e::ERROR_CODE_BAD_PARAMETERS, $e->getCode());

        // Fail if client_id not set
        $e = null;
        try {
            Order::prepareOrder([
                'order_prefix' => 'TEST',
                'amount' => '1',
                'trade_id' => $tradeId,
                'product_name' => 'Test product',
                'user_identifier' => 'Test User',
                'payment_agent' => 'alipay',
                'payment_method' => 'mobile_web',
                'currency' => 'CNY',
                'amount_in_currency' => '1',
            ]);
        } catch (OrderException $e) {
        }
        $this->assertInstanceOf(OrderException::class, $e);
        $this->assertEquals($e::ERROR_CODE_BAD_PARAMETERS, $e->getCode());

        // Fail if amount <= 0
        $e = null;
        try {
            Order::prepareOrder([
                'order_prefix' => 'TEST',
                'amount' => '0',
                'trade_id' => $tradeId,
                'product_name' => 'Test product',
                'user_identifier' => 'Test User',
                'client_id' => 'test_client',
                'payment_agent' => 'alipay',
                'payment_method' => 'mobile_web',
                'currency' => 'CNY',
                'amount_in_currency' => '1',
            ]);
        } catch (OrderException $e) {
        }
        $this->assertInstanceOf(OrderException::class, $e);
        $this->assertEquals($e::ERROR_CODE_BAD_PARAMETERS, $e->getCode());

        // Fail if cash_to_pay < 0
        $e = null;
        try {
            Order::prepareOrder([
                'order_prefix' => 'TEST',
                'amount' => '1',
                'cash_to_pay' => '-1',
                'trade_id' => $tradeId,
                'product_name' => 'Test product',
                'user_identifier' => 'Test User',
                'client_id' => 'test_client',
                'payment_agent' => 'alipay',
                'payment_method' => 'mobile_web',
                'currency' => 'CNY',
                'amount_in_currency' => '1',
            ]);
        } catch (OrderException $e) {
        }
        $this->assertInstanceOf(OrderException::class, $e);
        $this->assertEquals($e::ERROR_CODE_BAD_PARAMETERS, $e->getCode());

        // Success
        $order = Order::prepareOrder([
            'order_prefix' => 'TEST',
            'amount' => '1',
            'trade_id' => $tradeId,
            'product_name' => 'Test product',
            'user_identifier' => 'Test User',
            'client_id' => 'test_client',
            'payment_agent' => 'alipay',
            'payment_method' => 'mobile_web',
            'currency' => 'CNY',
            'amount_in_currency' => '1',
        ]);
        $this->assertTrue($order->save(), $order->getStringMessages());
        $this->assertEquals($tradeId, $order->getTradeId());
        $this->assertEquals($order->getId(), $order->getOrderData()->getId());
    }

    public function testSetAndGetOrderData()
    {
        $order = $this->getTestOrder();

        // Test set string data
        $key = 'foo';
        $value = 'bar';
        $order->setOrderData($key, $value);
        $this->assertTrue($order->save(), $order->getStringMessages());
        $order = $this->getTestOrder();
        $this->assertEquals($value, $order->getOrderData($key));

        // Test set null data (remove data)
        $order->setOrderData($key, null);
        $this->assertTrue($order->save(), $order->getStringMessages());
        $order = $this->getTestOrder();
        $this->assertNull($order->getOrderData($key));
    }

    public function testPrepareExistingOrder()
    {
        $order = $this->getTestOrder();

        // Success if crucial attributes are not changed and status is pending
        $order = Order::prepareOrder([
            'order_prefix' => 'TEST',
            'amount' => '1',
            'trade_id' => $order->getTradeId(),
            'product_name' => 'Test product',
            'user_identifier' => 'Test User',
            'client_id' => 'test_client',
            'payment_agent' => 'alipay',
            'payment_method' => 'mobile_web',
            'currency' => 'CNY',
            'amount_in_currency' => '1',
        ]);

        // Fail if crucial attributes are changed
        $e = null;
        try {
            Order::prepareOrder([
                'order_prefix' => 'TEST',
                'amount' => '2',
                'trade_id' => $order->getTradeId(),
                'product_name' => 'Test product',
                'user_identifier' => 'Test User',
                'client_id' => 'test_client',
                'payment_agent' => 'alipay',
                'payment_method' => 'mobile_web',
                'currency' => 'CNY',
                'amount_in_currency' => '1',
            ]);
        } catch (OrderException $e) {
        }
        $this->assertInstanceOf(OrderException::class, $e);
        $this->assertEquals($e::ERROR_CODE_KEY_PARAMETERS_CHANGED, $e->getCode());

        $order->updateStatus(Order::STATUS_COMPLETE, 'Mark Order Complete');
        $this->assertTrue($order->save(), $order->getStringMessages());

        // Fail if status is not pending
        $e = null;
        try {
            Order::prepareOrder([
                'order_prefix' => 'TEST',
                'amount' => '1',
                'trade_id' => $order->getTradeId(),
                'product_name' => 'Test product',
                'user_identifier' => 'Test User',
                'client_id' => 'test_client',
                'payment_agent' => 'alipay',
                'payment_method' => 'mobile_web',
                'currency' => 'CNY',
                'amount_in_currency' => '1',
            ]);
        } catch (OrderException $e) {
        }
        $this->assertInstanceOf(OrderException::class, $e);
        $this->assertEquals($e::ERROR_CODE_ORDER_PROCESSING, $e->getCode());
    }
}
