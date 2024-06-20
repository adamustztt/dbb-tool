<?php


namespace Tool\ShanTaoTool\Mq;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * mq服务
 * Class MqService
 * @package Tool\ShanTaoTool\Mq
 */
class MqService
{
    /**
     * @var string 地址
     */
    private static $host;

    /**
     * @var string 端口
     */
    private static $port;

    /**
     * @var string 账号
     */
    private static $userName;

    /**
     * @var string 密码
     */
    private static $userPassword;

    /**
     * 设置mq连接属性
     * @param string $host  连接地址
     * @param string $port  连接端口
     * @param string $userName 账号
     * @param string $userPassword 密码
     */
    public static function setMqAttributes($host, $port, $userName, $userPassword)
    {
        self::$host=$host;
        self::$port=$port;
        self::$userName=$userName;
        self::$userPassword=$userPassword;
    }
    /**
     * 获取mq连接
     * @return AMQPStreamConnection
     */
    public static function getMqConnection()
    {
        self::$host=env("RABBITMQ_HOST");
        self::$port=env("RABBITMQ_PORT");
        self::$userName=env("RABBITMQ_USER");
        self::$userPassword=env("RABBITMQ_PASSWORD");
        //连接mq
        $connection = new AMQPStreamConnection(self::$host,self::$port,self::$userName,self::$userPassword);
        return $connection;
    }

    /**
     * 推送日志消息到mq(提前设置好交换机和队列)
     * @param string $message 消息
     * @param string $routeKey 路由键
     */
    public static function pushLogMessage($message,$routeKey)
    {
        $connection = self::getMqConnection();
        //创建channel
        $channel = $connection->channel();

        //声明队列(前提mq上面的交换机logExchange已经创建)
//        $channel->queue_declare($queueName);
//        //将交换机和队列绑定
//        $channel->queue_bind($queueName,"logExchange");

        //创建mq消息
        $msg = new AMQPMessage($message);
        //推送消息到mq
        $channel->basic_publish($msg,"logExchange",$routeKey);

        //发送成功之后关闭channel和connection
        $channel->close();
        $connection->close();
    }

    /**
     * 推送消息到mq(提前设置好交换机和队列)
     * @param string $message 消息
     * @param string $exchange 交换机
     * @param string $routeKey 路由键
     */
    public static function pushMessage($message,$exchange,$routeKey)
    {
        $connection = self::getMqConnection();
        //创建channel
        $channel = $connection->channel();

        //创建mq消息
        $msg = new AMQPMessage($message);
        //推送消息到mq
        $channel->basic_publish($msg,$exchange,$routeKey);

        //发送成功之后关闭channel和connection
        $channel->close();
        $connection->close();
    }

}