<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-12-21
 * Time: 13:31
 */

namespace Inhere\Stc;

/**
 * Class Template
 * @package Inhere\Stc
 */
class Template extends Object
{
    /** @var array  */
    private $_config = [
        'suffix' => '.php', //文件后缀名
        'templateDir' => '../views/', //模板所在文件夹
        'compileDir' => '../runtime/cache/views/', //编译后存放的目录
        'suffixCompile' => '.php', //编译后文件后缀
        'isReCacheHtml' => false, //是否需要重新编译成静态html文件
        // 'isSupportPhp' => true, //是否支持php的语法
        'cacheTime' => 0, //缓存时间,单位秒
    ];
    /** @var string */
    private $_file; //待编译模板文件
    private $_valueMap = []; //键值对

    /** @var Compiler */
    private $_compiler; //编译器

    public function __construct($compiler, array $config = [])
    {
        $this->_compiler = $compiler;
        $this->_config = array_merge($this->_config, $config);
    }

    /**
     * @param string|array $name 键值 OR 键值对集合
     * @param null|mixed $value
     * @return string
     * @throws \Exception
     */
    public function assign($name, $value = null)
    {
        if (\is_array($name)) {
            $this->_valueMap = array_merge($this->_valueMap, $name);
        } elseif (\is_string($name)) {
            $this->_valueMap[$name] = $value;
        }

        return $this;
    }

    /**
     * show 展现视图
     * @param string $file 带编译缓存的文件
     * @return string
     * @throws \Throwable
     */
    public function render($file)
    {
        $this->_file = $file;

        if (!is_file($this->path())) {
            throw new \RuntimeException('Template file ' . $file . ' not exists!');
        }

        $compileFile = $this->_config['compileDir'] . md5($file) . $this->_config['suffixCompile'];
        $cacheFile = $this->_config['compileDir'] . md5($file) . '.html';

        //编译后文件不存在或者缓存时间已到期,重新编译,重新生成html静态缓存
        if (!is_file($compileFile) || $this->isRecompile($compileFile)) {
            $this->_compiler->compile($this->path(), $compileFile, $this->_valueMap);
            $this->_config['isReCacheHtml'] = true;
        }

        try {
            ob_start();
            $this->protectedIncludeScope($compileFile, $this->_valueMap);
            $output = ob_get_clean();
        } catch (\Throwable $e) { // PHP 7+
            ob_end_clean();
            throw $e;
        }

        if ($this->isReCacheHtml()) {
            file_put_contents($cacheFile, $output);
        }

        return $output;
    }

    /**
     * @param string $file
     * @param array $data
     */
    protected function protectedIncludeScope($file, array $data)
    {
        extract($data, EXTR_OVERWRITE);
        include $file;
    }

    /**
     * isRecompile 根据缓存时间判断是否需要重新编译
     * @param string $compileFile 编译后的文件
     * @return boolean
     */
    private function isRecompile($compileFile)
    {
        return time() - filemtime($compileFile) > $this->_config['cacheTime'];
    }

    /**
     * isReCacheHtml 是否需要重新缓存静态html文件
     * @return boolean
     */
    private function isReCacheHtml()
    {
        return $this->_config['isReCacheHtml'];
    }

    /**
     * path 获得模板文件路径
     * @return string
     */
    private function path()
    {
        return $this->_config['templateDir'] . $this->_file . $this->_config['suffix'];
    }
}
