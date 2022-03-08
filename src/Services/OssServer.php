<?php

namespace Gsp\Uploader\Services;

use Gsp\Uploader\Exceptions\HttpException;
use Gsp\Uploader\Exceptions\InvalidParamException;
use OSS\OssClient;

class OssServer
{
    protected $config;

    /**
     * 设置配置
     * @param array $config
     * @return OssServer
     * @throws InvalidParamException
     */
    public function config(array $config): OssServer
    {
        if (empty($config['accessKeyId']) || empty($config['accessKeySecret']) || empty($config['bucket']) || empty($config['endpoint'])) {
            throw new InvalidParamException('server param invalid');
        }
        $this->config = $config;
        return $this;
    }

    /**
     * OSS服务
     * @return OssClient
     * @throws \OSS\Core\OssException
     */
    public function getHttpClient()
    {
        return new OssClient($this->config['accessKeyId'], $this->config['accessKeySecret'], $this->config['endpoint']);
    }

    /**
     * 执行上传
     * @param string $file
     * @return string
     * @throws HttpException
     * @throws InvalidParamException
     */
    public function upload($file): string
    {
        if (!is_file($file)) {
            throw new InvalidParamException($file . ' is not a file');
        }

        try {
            $res = $this->getHttpClient()->uploadFile($this->config['bucket'], $this->getFileName($file), $file);
            return $res['oss-request-url'];
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 随机文件名
     * @param string $file
     * @return string
     */
    public function getFileName($file): string
    {
        $ext = $file->getClientOriginalExtension();
        return str_shuffle(md5(time())) . '.' . $ext;
    }
}
