<?php
/**
 * Created by PhpStorm.
 * User: gsp
 * Date: 2022/3/7
 * Time: 15:49
 */

namespace Gsp\Uploader;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class UploadServiceProvider extends LaravelServiceProvider
{
    protected $defer = true;

    /**
     * 服务引导方法
     *
     * @return void
     */
    public function boot(): void
    {
        //发布本地配置文件到项目的 config 目录中
        $this->publishes([
            __DIR__ . '/configs/uploader.php' => config_path('uploader.php'),
        ]);
    }

    /**
     * 注册服务
     */
    public function register(): void
    {
        //这里 singleton 直接对 类 进行IOC，也可以 直接取一个字符串
        $this->app->singleton(Uploader::class, function () {
            return new Uploader();
        });

        //这个可以不用在这里写，因为在composer.json里面已经定义了，并且定义的是Uploader
//        $this->app->alias(Uploader::class, 'uploader');

        //本地配置覆盖项目中的配置
        $this->mergeConfigFrom(
            __DIR__ . '/configs/uploader.php',
            'uploader'
        );
    }

    public function provides()
    {
//        return [Uploader::class, 'uploader'];
        return [Uploader::class, 'Uploader'];
    }
}