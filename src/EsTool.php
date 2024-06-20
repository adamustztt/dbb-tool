<?php




use Tool\ShanTaoTool\Bean\ElasticSearch\CreateLogDocParamBean;
use Tool\ShanTaoTool\Bean\ElasticSearch\GetLogDocParamBean;
use Tool\ShanTaoTool\ElasticSearch\ElasticSerach;
use Tool\ShanTaoTool\Exception\ElasticSearchException;

class EsTool
{
    /**
     * 写入请求日志
     * @param CreateLogDocParamBean $createLogDocParamBean
     */
    public static function createLogDoc(CreateLogDocParamBean $createLogDocParamBean)
    {
        //获取当前索引,以天为单位
        $index = date("Y-m-d");
        //1.创建索引,存在在报错
        ElasticSerach::getElasticSearchClient();
        try{
            $mapping = [
                "properties"=>[
                    "request_id"=>[
                        "type"=>"int",
                        "fielddata"=>true
                    ],
                    "request_path"=>[
                        "type"=>"string"
                    ],
                    "request_path_md5"=>[
                        "type"=>"string"
                    ],
                    "request_param"=>[
                        "type"=>"string"
                    ],
                    "request_response"=>[
                        "type"=>"string"
                    ],
                    "request_sql_log"=>[
                        "type"=>"string"
                    ],
                    "request_log"=>[
                        "type"=>"string"
                    ],
                    "request_project_name"=>[
                        "type"=>"string"
                    ],
                    "createdAt"=>[
                        "type"=>"date",
                        "format"=>"yyyy-MM-dd HH:mm:ss"
                    ],
                    "updatedAt"=>[
                        "type"=>"date",
                        "format"=>"yyyy-MM-dd HH:mm:ss"
                    ],
                    "request_response_code"=>[
                        "type"=>"string"
                    ]
                ]
            ];
            ElasticSerach::createIndex($index,$mapping);
        }catch (\Exception $exception){}
        //2.写入文档
        $responseDatas = is_bool($createLogDocParamBean->getRequestResponse())?"":$createLogDocParamBean->getRequestResponse();
        $doc = [
            "request_path"=>$createLogDocParamBean->getRequestPath(),
            "request_path_md5"=>md5($createLogDocParamBean->getRequestPath()),
            "request_param"=>$createLogDocParamBean->getRequestParam(),
            "request_response"=>$responseDatas,
            "request_sql_log"=>$createLogDocParamBean->getRequestSqlLog(),
            "request_log"=>$createLogDocParamBean->getRequestLog(),
            "request_project_name"=>$createLogDocParamBean->getRequestProjectName(),
            "created_at"=>is_numeric($createLogDocParamBean->getCreatedAt())?date("Y-m-d H:i:s",$createLogDocParamBean->getCreatedAt()):$createLogDocParamBean->getCreatedAt(),
            "updated_at"=>is_numeric($createLogDocParamBean->getUpdatedAt())?date("Y-m-d H:i:s",$createLogDocParamBean->getUpdatedAt()):$createLogDocParamBean->getUpdatedAt(),
            "request_id"=>$createLogDocParamBean->getRequestId(),
            "request_time"=>is_numeric($createLogDocParamBean->getUpdatedAt())?($createLogDocParamBean->getUpdatedAt()-$createLogDocParamBean->getCreatedAt())*1000:0,
            "unique_trace_id"=>$createLogDocParamBean->getUniqueTraceId()?$createLogDocParamBean->getUniqueTraceId():"",
            "request_response_code"=>is_numeric($createLogDocParamBean->getRequestResponseCode())?md5($createLogDocParamBean->getRequestResponseCode()):md5(200)
        ];
        return ElasticSerach::createDoc($index,$doc);
    }

    /**
     * 根据索引和项目名称获取日志数据
     * @param GetLogDocParamBean $getLogDocParamBean
     * @return array
     * @throws \Tool\ShanTaoTool\Exception
     */
    public static function getLogDoc(GetLogDocParamBean $getLogDocParamBean)
    {
        ElasticSerach::getElasticSearchClient();
        return ElasticSerach::getLogDoc($getLogDocParamBean);
    }


    /**
     * 根据索引和链路ID获取链路数据
     * @param string $traceId 链路ID
     * @param string $index 索引
     * @return array
     * @throws \Tool\ShanTaoTool\Exception
     */
    public static function getTraceLogDoc(string $traceId,$index)
    {
        ElasticSerach::getElasticSearchClient();
        return ElasticSerach::getTraceLogDoc($traceId,$index);
    }

    /**
     * 删除索引
     * @param string $index
     */
    public static function deleteIndex(string $index)
    {
        ElasticSerach::getElasticSearchClient();
        return ElasticSerach::deleteIndex($index);
    }
}