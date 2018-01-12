# ICF-PHP

## 框架目录结构
```
|-app                        //项目目录
    |common                  //全局的模块(可选)
        |-ctrl
        |-model
    |cache                   //缓存目录
    |-module_1               //项目各个模块目录
        |-ctrl               //控制器
        |-model              //模型(可选)
        |-tpl                //视图(可选)
        common.php           //模块的公共函数库(可选)
        config.php           //模块的配置目录(可选)
    |-module_2               //模块2
    .....
    common.php               //全局的函数库
|-icf                        //框架目录
    |-common                 //框架内置函数库
        |-common.php         //框架默认的函数库
    |-lib                    //框架类库
        |-db.php             //数据库驱动
        |-route.php          //路由实现
        |-view.php           //模板引擎
    |-config.php             //框架配置
    |-function.php           //框架核心函数
    |-index.php              //框架入口
    |-loader.php             //自动加载
|-index.php                  //启动框架
```

## 框架配置
```
<?php
return [
    //调试模式,会输出错误信息
    'debug' => true,                    
    //数据库配置
    'db' => [                           
        'type' => 'mysql',
        'server' => 'localhost',
        'port' => 3306,
        'db' => 'tmp',
        'user' => 'root',
        'pwd' => '',
        'prefix' => 'test_'
    ],
    //开启restful
    'rest' => true,                    
    //模块,控制器,操作 默认关键字
    'module_key' => 'm',
    'ctrl_key' => 'c',
    'action_key' => 'a',
    //路由表
    'route' => ['*' => [
        'debug/{test}' => 'index->debug'     // URL样式=>对应的控制器
        ]
    ],
    //模板后缀
    'tpl_suffix' => 'html',
    //是否记录日志
    'log' => true,
    //url 样式
    //0=module/ctrl/action/key1/value1/key2/value2
    //1=module.php?{$ctrl_key}=ctrl&{$action_key}=action&key1=value1
    //2=?{$module_key}=module&{$ctrl_key}=ctrl&{$action_key}=action&key1=value1
    'url_style' => 1
];
```
