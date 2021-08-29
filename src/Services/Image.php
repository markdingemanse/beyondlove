<?php

namespace MarkDingemanse\Beyondlove\Services;

use Illuminate\Support\Collection;

class Image
{
    protected $blackList = [
        '.',
        '..',
        'blur.svg',
        'loader.gif',
        'mailgif.gif',
        'pomf.png',
        'umbrella.png'
    ];

    function recursiveRadomSelection(Collection $files)
    {
        $random = $files->random();

        return ($this->endsWith($random, '.jpg') | $this->endsWith($random, '.png')) ? $random : $this->recursiveRadomSelection($files);
    }

    function endsWith($haystack, $needle)
    {
        return (strlen($needle) === 0) ? true : (substr($haystack, -strlen($needle)) === $needle);
    }

    function blacklistFiles(Collection $files)
    {
        $blacklist = $this->getBlackList();

        return $files->filter(function ($file) use ($blacklist) {
            return !in_array($file, $blacklist);
        });
    }

    function getBlackList()
    {
        return $this->blackList;
    }

    function getPublicPath()
    {
        return public_path('/img');
    }

    public function buildFileName(string $extension): string
    {
        return "bgn" . time() . '.' . $extension;
    }
}
