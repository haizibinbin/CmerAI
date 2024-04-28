<?php

namespace Bill\CmerAi;


use Bill\CmerAi\models\BizChatModel;
use Bill\CmerAi\models\ChatModel;
use Bill\CmerAi\models\EmbeddingModel;
use Bill\CmerAi\models\PutEmbeddingByCos;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


/**
 * 此类封装的是调用CmerAI的所有接口
 * CmerAI 接口文档：https://apihub.cmer.com/docs/aiccgpt.html
 */
class CmerAi
{
    /**
     * 头
     * @var string[]
     */
    protected $headers = [];

    /**
     * 请求域名
     * @var string
     */
    protected $host = 'https://api.cmer.com/v1/';


    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '../../');
        $dotenv->load();
        $this->headers['apikey'] = $_ENV['apikey'];
        $this->headers['X-CmerApi-Host'] = $_ENV['X_CmerApi_Host'];
    }


    /**
     * @param string $endpoint
     * @param string $method
     * @param array $body
     * @param array $query
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * 发起请求
     */
    public function http(string $endpoint, string $method, array $body = [], array $query = [])
    {
        $client = new Client([
            'base_uri' => $this->host,
            'timeout' => 300,
            'verify' => false
        ]);
        # 组装headers
        $options = [
            'headers' => $this->headers,
        ];
        # query：路径参数
        if ($query)
            $options['query'] = $query;
        # body：请求体参数
        if ($body)
            $options['json'] = $body;

        try {
            $response = $client->request($method, $endpoint, $options);
            return ['code' => $response->getStatusCode(), 'body' => $response->getBody()->getContents()];
        } catch (RequestException $exception) {
            return ['code' => 500, 'body' => $exception->getMessage()];
        }
    }


    /**
     * @param string $endpoint
     * @param string $method
     * @param array $body
     * @param array $query
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * 流式响应请求
     */
    public function http_stream(string $endpoint, string $method, array $body = [], array $query = [])
    {
        $client = new Client([
            'base_uri' => $this->host,
            'timeout' => 300,
            'verify' => false
        ]);
        # 组装headers
        $options = [
            'headers' => $this->headers,
        ];
        # body：请求体参数
        if ($body)
            $options['json'] = $body;
        # query：路径参数
        if ($query)
            $options['query'] = $query;

        $options['stream'] = true;

        try {
            $response = $client->request($method, $endpoint, $options);
            return ['code' => $response->getStatusCode(), 'body' => $response->getBody()];
        } catch (RequestException $exception) {
            return ['code' => 500, 'body' => $exception->getMessage()];
        }
    }


    /****************************************** 以下是CmerAI 的所有路由，函数名即路由地址 *****************************************/

    /**
     * @param ChatModel $model
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * 原生GPT聊天
     */
    public function openai_chat(ChatModel $model)
    {
        return $this->http(__FUNCTION__, 'POST', $model->toArray());
    }

    /**
     * @param ChatModel $model
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * 原生GPT流式聊天
     */
    public function openai_chat_stream(ChatModel $model)
    {
        return $this->http_stream(__FUNCTION__, 'POST', $model->toArray());
    }

    public function biz_openai_chat(BizChatModel $model)
    {
        return $this->http(__FUNCTION__, 'POST', $model->toArray());
    }

    public function biz_openai_chat_stream(BizChatModel $model)
    {
        return $this->http_stream(__FUNCTION__, 'POST', $model->toArray());
    }


    /**
     * @param EmbeddingModel $model
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * PUT向量
     */
    public function biz_openai_import_data(EmbeddingModel $model)
    {
        return $this->http(__FUNCTION__, 'POST', $model->toArray());
    }

    /**
     * @param EmbeddingModel $model
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * 查询向量
     */
    public function biz_openai_query_data(EmbeddingModel $model)
    {
        return $this->http(__FUNCTION__, 'POST', $model->toArray());
    }

    /**
     * 修改pinecone中的prompt_tag且更新向量
     */
    public function biz_update_prompt_tag(string $pinecone_id, string $prompt_tag)
    {
        return $this->http(__FUNCTION__, 'POST', ['pinecone_id' => $pinecone_id, 'prompt_tag' => $prompt_tag]);
    }

    /**
     * @param string $index_name
     * @param string $uuid
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * 删除向量
     */
    public function biz_openai_delete_data(string $index_name, string $uuid)
    {
        return $this->http(__FUNCTION__, 'GET', ['index_name' => $index_name, 'uuid' => $uuid]);
    }

    /**
     * @param PutEmbeddingByCos $model
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * 通过文件上传向量数据
     */
    public function put_embedding_by_cos(PutEmbeddingByCos $model)
    {
        return $this->http(__FUNCTION__, 'POST', $model->toArray());
    }

}
