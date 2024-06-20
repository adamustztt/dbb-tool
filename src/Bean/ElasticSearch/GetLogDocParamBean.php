<?php


namespace Tool\ShanTaoTool\Bean\ElasticSearch;


use Tool\ShanTaoTool\Bean\BaseBean;

class GetLogDocParamBean extends BaseBean
{
    /**
     * 索引名称
     * @var $index string
     */
    private $index;

    /**
     * 项目名称
     * @var $projectName string
     */
    private $projectName;

    /**
     * 请求路径
     * @var $requestPath string
     */
    private $requestPath;

    /**
     * 第几页
     * @var $page
     */
    private $page;

    /**
     * 每页数量
     * @var $pageSize
     */
    private $pageSize;

    /**
     * @var 参数
     */
    private $param;

    /**
     * @var string $uniqueTraceId 链路追踪ID
     */
    private $uniqueTraceId;

    /**
     * @var string 请求开始时间
     */
    private $requestStartTime;

    /**
     * @var string 请求结束时间
     */
    private $requestEndTime;

    /**
     * 返回错误码
     */
    private $requestResponseCode;

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
    public function getRequestStartTime()
    {
        return $this->requestStartTime;
    }

    /**
     * @param string $requestStartTime
     */
    public function setRequestStartTime($requestStartTime)
    {
        $this->requestStartTime = $requestStartTime;
    }

    /**
     * @return string
     */
    public function getRequestEndTime()
    {
        return $this->requestEndTime;
    }

    /**
     * @param string $requestEndTime
     */
    public function setRequestEndTime($requestEndTime)
    {
        $this->requestEndTime = $requestEndTime;
    }

    /**
     * @return string 链路追踪ID
     */
    public function getUniqueTraceId()
    {
        return $this->uniqueTraceId;
    }

    /**
     * 链路追踪ID
     * @param  $uniqueTraceId
     */
    public function setUniqueTraceId($uniqueTraceId)
    {
        $this->uniqueTraceId = $uniqueTraceId;
    }

    /**
     * @return
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @param  $param
     */
    public function setParam($param)
    {
        $this->param = $param;
    }

    /**
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param string $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * @param string $projectName
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
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
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return mixed
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @param mixed $pageSize
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
    }
}