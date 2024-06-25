<?php
declare(strict_types=1);

namespace app\logic;

use think\facade\Config;
use think\facade\Filesystem;
use think\file\UploadedFile;

class UploadLogic extends BaseLogic
{
    private $resRelativePath = false;
    private $defaultRule = 'original';

    public function setResRelativePath()
    {
        $this->resRelativePath = true;
        return $this;
    }

    public function image(string $scene, UploadedFile $binary, $rule = null)
    {
        validate(['image' => 'fileExt:jpg,png'])
            ->check(['image' => $binary]);
        $path = Filesystem::putFile($scene, $binary, date('Y-m-d') . '/' . $this->getFileName($binary, $rule));

        return $this->resRelativePath ? $path : Config::get('filesystem.disks.local.url') . '/' . $path;
    }

    public function images(string $scene, array $binary, $rule = null)
    {
        $data = [];
        foreach ($binary as $image) {
            $data[] = $this->image($scene, $image, $rule);
        }
        return $data;
    }

    private function getFileName($binary, $rule)
    {
        $rule = $rule ?: $this->defaultRule;
        switch ($rule) {
            case 'md5':
                return $binary->md5() . '.' . $binary->getOriginalExtension();
            case 'sha1':
                return $binary->sha1() . '.' . $binary->getOriginalExtension();
            case 'random':
                return md5(microtime(true) . $binary->getPathname()) . '.' . $binary->getOriginalExtension();
            case 'original':
                return $binary->getOriginalName();
        }
    }
}