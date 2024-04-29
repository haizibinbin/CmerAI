# CmerAI PHP SDK


> 作者：BILL  
> CmerAI PHP SDK 是为了方便PHP开发者调用CmerAI提供的API接口而开发的SDK工具包。  
> 接口文档：https://apihub.cmer.com/docs/aiccgpt.html  
> 务必要浏览接口文档，此SDK是对文档上的路由请求做了封装


## 安装

```shell
composer require hbb/cmer-ai
```

## 在 `composer.json` 文件的同级目录下配置环境变量到`.env`文件

```shell
apikey=XXXXXXXXXX
X_CmerApi_Host=XXXXXXXXXX
```

## 快速开始

```php
<?php
require_once 'vendor/autoload.php';


$messages = [
    ['role' => 'user', 'content' => '写100字的文案']
];

# 请求体 - 负责组装请求参数
$body = new \Hbb\CmerAi\models\ChatModel($messages);

# 更换默认参数
$body->model = 'gpt-3.5-turbo-0125';  # 默认gpt-3.5-turbo-1106

# 请求启动器 - 负责发起请求
$cmerai = new \Hbb\CmerAi\CmerAi();

# 发起请求，函数名：openai_chat 对应接口文档中的路由: /v1/openai/chat
$res = $cmerai->openai_chat($body);
var_dump($res);

# 流式响应
$res_stream = $cmerai->openai_chat_stream($body);
if ($res_stream['code'] == 200)
{
    $stream = $res_stream['body'];
    // 从流中逐行读取数据
    while (!$stream->eof()) {
        echo $stream->read(1024); // 读取流中的数据
    }
    // 关闭流
    $stream->close();
}

```

