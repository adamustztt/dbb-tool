<?php


namespace Tool\ShanTaoTool\ElasticSearch;

use function Complex\sec;
use Elasticsearch\ClientBuilder;
use Tool\ShanTaoTool\Bean\ElasticSearch\GetLogDocParamBean;
use Tool\ShanTaoTool\Exception\ElasticSearchException;

/**
 * es操作类
 * Class ElasticSerach
 * @package Tool\ShanTaoTool\ElasticSearch
 */
class ElasticSerach
{
    /**
     * @var $client \Elasticsearch\Client
     */
    static $client;

    /**
     * 获取es客户端
     */
    public static function getElasticSearchClient()
    {
        $host = env("ES_HOST");
        $port = env("ES_PORT");
        $user = env("ES_USER");
        $password = env("ES_PASSWORD");
        $hosts = ["{$host}:{$port}"];
        $clientBuilder = ClientBuilder::create();
        //设置es地址
        $clientBuilder->setHosts($hosts);
        //设置账号密码
        $clientBuilder->setBasicAuthentication($user,$password);
        //设置尝试次数
        $clientBuilder->setRetries(2);
        $client = $clientBuilder->build();
        self::$client = $client;
    }

    /**
     * 创建索引
     * @param $index 索引名称
     * @param $mapping 索引结构
     */
    public static function createIndex($index,$mapping=[])
    {
        if(!$index){
            throw new ElasticSearchException("索引不能为空");
        }
        $param = [
            "index"=>$index
        ];
        if($mapping){
            $param["body"]["mappings"] = $mapping;
        }
        return self::$client->indices()->create($param);
    }

    /**
     * 索引中写入文档
     * @param $index   索引名称
     * @param $data    文档数据
     * @param $id    文档ID
     */
    public static function createDoc($index, array $data,$id=0)
    {
        if(!$index){
            throw new ElasticSearchException("索引不能为空");
        }
        if(!$data){
            throw new ElasticSearchException("文档不能为空");
        }
        $params = [
            "index"=>$index,
            "body"=>$data
        ];
        if($id){
            $params["id"] = $id;
        }
        return self::$client->index($params);
    }

    /**
     * 批量写入文档
     * @param $index 索引名称
     * @param array $datas 文档数据
     */
    public static function batchCreateDoc($index, array $datas)
    {
        if(!$index){
            throw new ElasticSearchException("索引不能为空");
        }
        if(!$datas){
            throw new ElasticSearchException("文档不能为空");
        }
        if(count($datas)>100){
            throw new ElasticSearchException("文档数量不能大于100");
        }
        $params = [
            "index"=>$index,
            "body"=>[]
        ];
        foreach ($datas as $data){
            $params['body'][] = [
                'index' => [
                    '_index' => $index,
                ]
            ];
            $params['body'][] = $data;
        }

        return self::$client->bulk($params);
    }

    /**
     * 根据索引和文档ID获取文档
     * @param $index 索引名称
     * @param $id 文档ID
     */
    public static function getDoc($index, $id)
    {
        if(!$index){
            throw new ElasticSearchException("索引不能为空");
        }
        if(!$id){
            throw new ElasticSearchException("文档id不能为空");
        }
        $params = [
            "index"=>$index,
            "id"=>$id
        ];
        return self::$client->get($params);
    }

    /**
     * 更新文档信息
     * @param $index 索引名称
     * @param $id 文档ID
     * @param array $data 更新内容
     */
    public static function updateDoc($index, $id, array $data)
    {
        if(!$index){
            throw new ElasticSearchException("索引不能为空");
        }
        if(!$id){
            throw new ElasticSearchException("文档id不能为空");
        }
        if(!$data){
            throw new ElasticSearchException("更新内容不能为空");
        }
        $params = [
            "index"=>$index,
            "id"=>$id,
            "body"=>[
                "doc"=>$data
            ]
        ];
        return self::$client->update($params);
    }

    /**
     * 删除文档
     * @param $index 索引名称
     * @param $id 文档ID
     */
    public static function deleteDoc($index, $id)
    {
        if(!$index){
            throw new ElasticSearchException("索引不能为空");
        }
        if(!$id){
            throw new ElasticSearchException("文档id不能为空");
        }
        $params = [
            "index"=>$index,
            "id"=>$id
        ];
        return self::$client->delete($params);
    }

    /**
     * 根据索引和项目名称获取数据
     * @param GetLogDocParamBean $getLogDocParamBean
     * @return array
     * @throws ElasticSearchException
     */
    public static function getLogDoc(GetLogDocParamBean $getLogDocParamBean)
    {
        if(!$getLogDocParamBean->getIndex()){
            throw new ElasticSearchException("索引不能为空");
        }
        if(!$getLogDocParamBean->getProjectName()){
            throw new ElasticSearchException("项目名称不能为空");
        }
        $param = [
            "index"=>$getLogDocParamBean->getIndex(),
            "body"=>[
                "track_total_hits"=>true,
                "query"=>[
                    "bool"=>[
                        "must"=>[
                            [
                                "match"=>[
                                    "request_project_name"=>$getLogDocParamBean->getProjectName()
                                ]
                            ]
                        ]

                    ]

                ],
                "sort"=>[
                    [
                        "request_id"=>[
                            "order"=>"desc"
                        ]
                    ]
                ]
            ]
        ];
        //判断是否存在路径
        if($getLogDocParamBean->getRequestPath()){
            $param["body"]["query"]["bool"]["must"][] = [
                "match"=>[
                    "request_path_md5"=>md5($getLogDocParamBean->getRequestPath())
                ]
            ];
        }
        //判断是否存在参数
        if($getLogDocParamBean->getParam()){

            //判断参数是否用逗号隔开
            $searchParams = explode(",",$getLogDocParamBean->getParam());
            foreach ($searchParams as $searchParam){
                $param["body"]["query"]["bool"]["must"][] = [
                    "match"=>[
                        "request_param"=>$searchParam
                    ]
                ];
            }
//            $param["body"]["query"]["bool"]["must"][] = [
//                "match"=>[
//                    "request_param"=>$getLogDocParamBean->getParam()
//                ]
//            ];
        }

        //判断是否存在链路追踪ID
        if($getLogDocParamBean->getUniqueTraceId()){
            $param["body"]["query"]["bool"]["must"][] = [
                "match"=>[
                    "unique_trace_id"=>$getLogDocParamBean->getUniqueTraceId()
                ]
            ];
        }

        //判断是否存在请求时间
        if ($getLogDocParamBean->getRequestStartTime()){
            $param["body"]["query"]["bool"]["must"][] = [
                "range"=>[
                    "request_id"=>[
                        "gte"=>strtotime($getLogDocParamBean->getRequestStartTime())*1000,
                        "lte"=>strtotime($getLogDocParamBean->getRequestEndTime())*1000
                    ]
                ]
            ];
        }

        //判断是否存在返回code码
        if (is_numeric($getLogDocParamBean->getRequestResponseCode())){
            $param["body"]["query"]["bool"]["must"][] = [
                "match"=>[
                    "request_response_code"=>md5($getLogDocParamBean->getRequestResponseCode())
                ]
            ];
        }

        //判断是否存在页数
        $page = $getLogDocParamBean->getPage();
        $pageSize = $getLogDocParamBean->getPageSize();
        if($page){
            $param["size"] = $pageSize;
            $param["from"] = ($page-1)*$pageSize;
        }
        return self::$client->search($param);
    }

    /**
     * 根据traceId获取链路数据
     * @param string $uniqueTraceId
     * @param string $index
     * @return array
     * @throws ElasticSearchException
     */
    public static function getTraceLogDoc(string $uniqueTraceId,$index)
    {
        $param = [
            "index"=>$index,
            "body"=>[
                "query"=>[
                    "bool"=>[
                        "must"=>[
                            [
                                "match"=>[
                                    "unique_trace_id"=>$uniqueTraceId
                                ]
                            ]
                        ]

                    ]

                ],
                "sort"=>[
                    [
                        "request_id"=>[
                            "order"=>"asc"
                        ]
                    ]
                ]
            ]
        ];
        return self::$client->search($param);
    }

    /**
     * 删除索引
     * @param string $index
     */
    public static function deleteIndex($index)
    {
        if(!$index){
            throw new ElasticSearchException("索引不能为空");
        }
        $params = [
            "index"=>$index
        ];
        return self::$client->indices()->delete($params);
    }
}