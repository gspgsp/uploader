# oss图片上传的composer包

## 运行环境要求

- laravel 5.6+
- PHP 7.4+

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
### 使用
```text
composer require gsp/uploader
```

