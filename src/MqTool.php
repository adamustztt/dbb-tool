<?php




use Tool\ShanTaoTool\Mq\MqService;

class MqTool
{
    /**
     * 推送日志消息到mq
     * @param $message \Tool\ShanTaoTool\消息
     * @param $routeKey \Tool\ShanTaoTool\路由键
     */
    public static function pushLogMessage($message,$routeKey)
    {
        MqService::pushLogMessage($message,$routeKey);
    }

    /**
     * 推送消息的mq
     * @param $message \Tool\ShanTaoTool\消息
     * @param $exchange \Tool\ShanTaoTool\交换机
     * @param $routeKey \Tool\ShanTaoTool\路由键
     */
    public static function pushMessage($message,$exchange,$routeKey)
    {
        MqService::pushMessage($message,$exchange,$routeKey);
    }
}