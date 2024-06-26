# CmerAI PHP SDK


> 作者：BILL  
> CmerAI PHP SDK 是为了方便PHP开发者调用CmerAI提供的API接口而开发的SDK工具包。 
> 此库只有API的代码，没有任何业务逻辑。  
> 要了解API接口参数，请查看接口文档：https://apihub.cmer.com/docs/aiccgpt.html    
> 务必要浏览接口文档，此SDK是对文档上的路由请求做了封装  
> 此SDK适用于 laravel7


## 安装

```shell
composer require hbb/cmer-ai
```

## 快速开始

```php
<?php
require_once 'vendor/autoload.php';


$messages = [
    ['role' => 'user', 'content' => '写100字的文案']
];

# 请求体 - 负责组装请求参数
$payload = new \Hbb\CmerAi\models\ChatModel($messages);

# 更换默认参数
$payload->model = 'gpt-3.5-turbo-0125';  # 默认gpt-3.5-turbo-1106

# 配置网关授权参数
$apikey = 'xxxxxxxxxx';
$X_CmerApi_Host = 'xxxxxxxxxx';
# 网关授权参数配置OK

# 请求启动器 - 负责发起请求
$payload = new \Hbb\CmerAi\CmerAi($apikey, $X_CmerApi_Host);

# 发起请求，函数名：openai_chat 对应接口文档中的路由: /v1/openai/chat
$response = $cmerai->openai_chat($payload);
var_dump($response->getBody()->getContents());

# 流式响应
$response = $cmerai->openai_chat_stream($payload);
if ($response->getStatusCode() == 200)
{
    $body = $response->getBody();
    if ($body instanceof \GuzzleHttp\Psr7\Stream)
    {
        // 从流中逐行读取数据
        while (!$body->eof()) {
            echo $body->read(1024); // 读取流中的数据
        }
    }

}
```

