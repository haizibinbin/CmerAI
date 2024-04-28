<?php

namespace Hbb\CmerAi\models;


/**
 * 通过文件上传向量数据，保存异步任务即可
 * 路由：/v1/put_embedding_by_cos
 */
class PutEmbeddingByCos extends BaseModel
{

    /**
     * @var string 任务ID
     */
    public string $uuid;

    public string $index_name;

    /**
     * @var string 文件的cos地址
     */
    public string $key;

    /**
     * @var string 任务完成后的异步回调地址
     */
    public string $callback;

    public int $chunk_size = 1000;

    public string $prompt = '';

    public function __construct(string $uuid, string $index_name, string $key, string $callback)
    {
        $this->uuid = $uuid;
        $this->index_name = $index_name;
        $this->key = $key;
        $this->callback = $callback;
    }

}
