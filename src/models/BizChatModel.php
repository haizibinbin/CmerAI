<?php

namespace Bill\CmerAi\models;


/**
 * 训练了文案库的GPT的请求参数
 */
class BizChatModel extends ChatModel
{

    /**
     * @var string
     * 文案库
     */
    public string $index_name;

    /**
     * @var string 提示语
     * 注意此处提示语是AICC 文案库后台配置的指令，并不是定义的角色。
     */
    public string $prompt;

    /**
     * @var int
     * 限制命中向量的token
     */
    public int $em_token = 5000;

    /**
     * @var bool
     * 是否开启连网？如果开启，AI无法回答的问题，AI会自己去谷歌后回答。
     */
    public bool $is_online = false;

    /**
     * @var array
     * 要搜索哪些文案库，方便多文案库合并搜索
     * demo：['index_name1', 'index_name2']
     */
    public array $index_list = [];

    /**
     * @var array
     * 自定义字段精准过滤文案
     */
    public array $meta_filter = [];

    /**
     * @var bool 是否开启安全审核？
     */
    public bool $security_check = true;

    public function __construct(array $messages, string $index_name, string $prompt)
    {
        parent::__construct($messages);
        $this->index_name = $index_name;
        $this->prompt = $prompt;
    }
}
