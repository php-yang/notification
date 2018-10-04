<?php

namespace Yang\Notification\Tests;

use PHPUnit\Framework\TestCase;
use Yang\Notification\Center;
use Yang\Notification\IReceiver;

/**
 * Class NotificationTest
 * @package Yang\Notification\Tests
 */
class NotificationTest extends TestCase implements IReceiver
{
    const TEST_NOTIFICATION = 'TEST_NOTIFICATION';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $dataString;

    public function setUp()
    {
        Center::register($this::TEST_NOTIFICATION, $this);

        parent::setUp();
    }

    public function tearDown()
    {
        Center::unregister($this::TEST_NOTIFICATION, $this);
        unset($this->type, $this->dataString);

        parent::tearDown();
    }

    public function testNotification()
    {
        $data = array(
            'name' => 'pengzhile',
            'age' => 100,
            'extra' => array('haha' => 'hehe'),
        );

        Center::occur($this::TEST_NOTIFICATION, $data);
        $this->assertEquals($this->type, $this::TEST_NOTIFICATION);
        $this->assertEquals($this->dataString, serialize($data));

        Center::unregister($this::TEST_NOTIFICATION, $this);
        Center::occur($this::TEST_NOTIFICATION, 'hello world!');
        $this->assertEquals($this->type, $this::TEST_NOTIFICATION);
        $this->assertEquals($this->dataString, serialize($data));

        Center::register($this::TEST_NOTIFICATION, $this);
        Center::occur($this::TEST_NOTIFICATION, 'hello there!');
        $this->assertEquals($this->type, $this::TEST_NOTIFICATION);
        $this->assertEquals($this->dataString, serialize('hello there!'));
    }

    /**
     * @inheritdoc
     */
    public function onNotification($type, $data)
    {
        $this->type = $type;
        $this->dataString = serialize($data);
    }
}
