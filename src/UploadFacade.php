<?php
/**
 * Created by PhpStorm.
 * User: gsp
 * Date: 2022/3/7
 * Time: 16:05
 */

namespace Gsp\Uploader;

/**
 * @method static Uploader setConfig(array $config)
 * @method static string upload($file, string $service='oss')
 *
 * @see \Gsp\Uploader\Uploader
 */

use Illuminate\Support\Facades\Facade;
class UploadFacade extends Facade
{
    /**
     * 获取组件的注册名称。
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Uploader::class;
    }
}
