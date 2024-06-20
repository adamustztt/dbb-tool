<?php


namespace Tool\ShanTaoTool\Bean\ElasticSearch;


use Tool\ShanTaoTool\Bean\BaseBean;

class CreateLogDocParamBean extends BaseBean
{
    /**
     * 请求id
     * @var $requestId string
     */
    private $requestId;

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param string $requestId
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * 请求参数
     * @var $requestParams string
     */
    private $requestParam;

    /**
     * 请求路径
     * @var $requestPath string
     */
    private $requestPath;

    /**
     * 请求响应
     * @var $requestResponse string
     */
    private $requestResponse;

    /**
     * 自定义日志
     * @var $requestLog string
     */
    private $requestLog;

    /**
     * sql日志
     * @var $requestSqlLog string
     */
    private $requestSqlLog;

    /**
     * 请求的项目名称
     * @var $requestProjectName string
     */
    private $requestProjectName;

    /**
     * 请求开始时间
     * @var $createdAt string
     */
    private $createdAt;

    /**
     * 请求结束时间
     * @var $updatedAt string
     */
    private $updatedAt;

    /**
     * 链路追踪ID
     * @var string $uniqueTraceId
     */
    private $uniqueTraceId;

    /**
     * 返回的错误码
     */
    protected $requestResponseCode;

    /**
     * @return mixed
     */
    public function getRequestResponseCode()
    {
        return $this->requestResponseCode;
    }

    /**
     * @param mixed $requestResponseCode
     */
    public function setRequestResponseCode($requestResponseCode)
    {
        $this->requestResponseCode = $requestResponseCode;
    }


    /**
     * @return string
     */
    public function getUniqueTraceId()
    {
        return $this->uniqueTraceId;
    }

    /**
     * @param string $uniqueTraceId
     */
    public function setUniqueTraceId($uniqueTraceId)
    {
        $this->uniqueTraceId = $uniqueTraceId;
    }

    /**
     * @return string
     */
    public function getRequestParam()
    {
        return $this->requestParam;
    }

    /**
     * @param string $requestParams
     */
    public function setRequestParam($requestParam)
    {
        $this->requestParam = $requestParam;
    }

    /**
     * @return string
     */
    public function getRequestPath()
    {
        return $this->requestPath;
    }

    /**
     * @param string $requestPath
     */
    public function setRequestPath($requestPath)
    {
        $this->requestPath = $requestPath;
    }

    /**
     * @return string
     */
    public function getRequestResponse()
    {
        return $this->requestResponse;
    }

    /**
     * @param string $requestResponse
     */
    public function setRequestResponse($requestResponse)
    {
        $this->requestResponse = $requestResponse;
    }

    /**
     * @return string
     */
    public function getRequestLog()
    {
        return $this->requestLog;
    }

    /**
     * @param string $requestLog
     */
    public function setRequestLog($requestLog)
    {
        $this->requestLog = $requestLog;
    }

    /**
     * @return string
     */
    public function getRequestSqlLog()
    {
        return $this->requestSqlLog;
    }

    /**
     * @param string $requestSqlLog
     */
    public function setRequestSqlLog($requestSqlLog)
    {
        $this->requestSqlLog = $requestSqlLog;
    }

    /**
     * @return string
     */
    public function getRequestProjectName()
    {
        return $this->requestProjectName;
    }

    /**
     * @param string $requestProjectName
     */
    public function setRequestProjectName($requestProjectName)
    {
        $this->requestProjectName = $requestProjectName;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}