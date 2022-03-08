# oss图片上传的composer包

## 运行环境要求

- laravel 5.6+
- PHP 7.4+
- 必须laravel，因为调用了laravel的helper函数

### 开发过程
1). 新建uploader文件：

```shell
mkdir uploader
```

2). 配置composer文件：

```shell
cd uploader
composer init # 按提示选择
```
3). 得到如下目录文件
```shell
├── composer.json  
├── src				# 软件代码
├── vendor          # 当前包需要的依赖，上传到远程仓库的时候，在.gitignore里忽略掉
```
4). 在src里面加入业务代码
```shell
├── configs          #配置文件夹
    ├────── uploader.php #配置文件
├── src				 # 软件代码
    ├──────Uploader.php、UploadFacade.php、UploadServiceProvider.php
    ├── Services     # 业务处理
```
5).一般上面的几个文件就是我们需要的，但是如果需要测试的话还需要建一个tests文件夹，可以通过phpunit测试，也可以直接建一个如：uploaderTest.php的文件
```php
require_once __DIR__.'/../vendor/autoload.php';

use Gsp\Uploader\Uploader;

$obj = new Uploader();
$obj->setConfig();
```
如果是通过phpunit测试的话，需要在根目录下建一个phpunit.xml文件
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit backupGlobals="false"
         backupStaticAttributes="false"
         bootstrap="vendor/autoload.php"
         colors="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         processIsolation="false"
         stopOnFailure="false"
>
    <testsuites>
        <testsuite name="Prettus Repository Test Suite">
            <directory suffix=".php">./tests/</directory>
        </testsuite>
    </testsuites>
</phpunit>

```
6).由于需要提交到git，所以要通过.gitignore 忽略掉一些文件
```text
/.idea
.DS_Store
/vendor
/tests
composer.lock
phpunit.xml
```
7).本地项目测试使用
```text

$ cd laravel9
$ vagrant@homestead:~/code/helxilfie-edu/laravel9$ composer config repositories.uploader path ../../uploader
$ vagrant@homestead:~/code/helxilfie-edu/laravel9$ composer require gsp/uploader:*

效果就是在laravel9项目的composer.json里面会有如下仓库：
"repositories": {
        "uploader": {
            "type": "path",
            "url": "../../uploader"
        }
    }
```
8).如果测试完了，就可以推到github上了

### 使用
```text
1.composer require gsp/uploader
2.php artisan vendor:publish
3.配置config/uploader.php
```
```php
<?php

/**
 * Created by PhpStorm.
 * User: gsp
 * Date: 2022/3/3
 * Time: 14:43
 */

namespace App\Http\Controllers\V1\Auth;

use Illuminate\Http\Request;
use Gsp\Uploader\Uploader;
use Gsp\Uploader\UploadFacade;

class LoginController
{

    public function login(Request $request)
    {
        $config   = config('uploader');

        // 通过 aliases[别名] 调用，因为这个别名指向的是facade，所以调用的时候通过 :: 符号调用
//        $res = app('Uploader')::setConfig($config)->upload($request->file('file'));

        //通过 provider 调用
//        $res = app(Uploader::class)->setConfig($config)->upload($request->file('file'));

        //通过 facade调用
//        $res = UploadFacade::setConfig($config)->upload($request->file('file'));

        //通过 实例化对象 调用
        $uploader = new Uploader();
        $uploader->setConfig($config);

        $res = $uploader->upload($request->file('file'));

        return response()->json(['code' => 1000, 'url' => $res]);
    }
}
```

