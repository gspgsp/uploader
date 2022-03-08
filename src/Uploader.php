<?php

namespace Gsp\Uploader;

use Gsp\Uploader\Exceptions\Exception;
use Gsp\Uploader\Exceptions\InvalidParamException;
use Gsp\Uploader\Exceptions\ServerDisposeException;
use Gsp\Uploader\Services\OssServer;

class Uploader
{
    protected $config;

    /**
     * 服务列表
     * @var array
     */
    protected $servers = [
        'oss' => OssServer::class,
    ];

    public function setConfig(array $config): Uploader
    {
        $this->config = $config;
        return $this;
    }

    /**
     * 上传处理
     * @param string $file
     * @param string $service
     * @return string 文件
     * @throws InvalidParamException
     */
    public function upload($file, string $service='oss'): string
    {
        if (!is_file($file)) {
            throw new InvalidParamException('invalid file param');
        }
        if (!in_array($service, ['oss', 'local'])) {
            throw new ServerDisposeException('service dones not exists' . $service);
        }
        try {
            $serverInstance = new $this->servers[$service];
            return $serverInstance->config($this->config[$service])->upload($file);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }
}

