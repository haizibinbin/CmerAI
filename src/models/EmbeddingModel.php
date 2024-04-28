<?php

namespace Hbb\CmerAi\models;


/**
 * 训练文案库接口的请求参数, 添加向量，修改向量，查询
 * 路由：
 * /v1/biz_openai_import_data
 * /v1/biz_openai_query_data
 */
class EmbeddingModel extends BaseModel
{
    /**
     * @var string
     * 文案库 必填
     */
    public string $index_name;

    /**
     * @var string
     * 训练的文案 必填
     */
    public string $text;

    /**
     * @var string
     * 文案的唯一标识
     */
    public string $uuid = '';


    /**
     * @var string
     * 自定义的文案关键词，为了增强检索用的
     */
    public string $tag = '';

    /**
     * @var int 切片大小，默认1000token切一段
     */
    public int $chunk_size=1000;


    /**
     * @var string 使用AI来增强检索的指令，如果不为空，AI会使用此指令，先对文案总结。
     */
    public string $prompt = '';


    /**
     * @var array
     * 元数据：就是自定义的字段；
     * 插入向量库时，可以自定义字段值，方便在检索向量的时候，增加精准过滤。
     */
    public array $meta = [];

    /**
     * @var array
     * 元数据筛选过滤，在查询的时候，如果有值，会在语意检索的基础上，添加这个精准过滤条件。
     */
    public array $meta_filter = [];

    public function __construct(string $index_name, string $text)
    {
        $this->index_name = $index_name;
        $this->text = $text;
    }

}
