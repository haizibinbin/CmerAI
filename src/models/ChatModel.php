<?php

namespace Hbb\CmerAi\models;


/**
 * 原生GPT的请求参数
 */
class ChatModel extends BaseModel
{
    /**
     * @var string
     * 模型
     */
    public string $model = 'gpt-3.5-turbo-1106';

    /**
     * @var string
     * 模型供应商，默认微软
     */
    public string $supplier = 'azure';

    /**
     * @var array 消息列表
     */
    public array $messages;

    /**
     * @var int
     * 温度值；0-1，值越小回复越单一。
     */
    public float $temperature = 1;

    /**
     * @var array
     * 函数调用
     */
    public array $tools = [];

    /**
     * @var string
     * 三种情况：
     *  1. 不传参或者'auto',openai自动选择函数执行;
     *  2. 传参为: 'none', 禁止任何对象执行;
     *  3. {"type": "function", "function": {"name": "my_function"}} 传参为object，指定函数执行
     */
    public string $tool_choice = '';


    /**
     * @var int 限制最大输出token
     */
    public int $max_tokens = 0;

    /**
     * @var bool 是否开启调试模式？
     */
    public bool $debug = false;

    /**
     * @var bool 是否开启流式对话？暂时版本还不支持此参数，默认false即可
     */
//    public bool $stream = false;

    public function __construct(array $messages)
    {
        $this->messages = $messages;
    }

}
