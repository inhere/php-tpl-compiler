<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-12-21
 * Time: 13:31
 */

namespace Inhere\Stc;

/**
 * @link http://www.jb51.net/article/122699.htm
 */
class Compiler extends Object
{
    /** @var string */
    private $_content;

    /** @var string */
    private $_compiled;

    /** @var string */
    private $_compiledDir;

    /** @var string */
    private $_compiledFile;

    /** @var array  */
    private $_valueMap = [];

    /** @var array  */
    private $_patterns = [
        '#\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}#',
        '#\{if (.*?)\}#',
        '#\{(else if|elseif) (.*?)\}#',
        '#\{else\}#',
        '#\{foreach \\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)}#',
        '#\{foreach \\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*) (.*?)}#',
        '#\{\/(foreach|if)}#',
        '#\{\\^(k|v)\}#',
    ];

    /** @var array The pattens replaces */
    private $_replaces = [
        // old: echo \$this->_valueMap['\\1'];
        "<?=\$\\1;?>",
        '<?php if (\\1) {?>',
        '<?php } else if (\\2) {?>',
        '<?php }else {?>',
        "<?php foreach (\$\\1 as \$k => \$v) {?>",
        "<?php foreach (\$\\1 \\2) {?>",
        '<?php }?>',
        '<?=\$\\1?>',
    ];

    /**
     * compile 编译模板文件
     * @param string $srcFile  模板文件
     * @param array $values  键值对
     * @param string $dstFile 编译后文件
     * @return string|int
     */
    public function compileFile($srcFile, $dstFile = null, array $values = [])
    {
        $content = file_get_contents($srcFile);

        return $this->compile($content, $dstFile, $values);
    }

    /**
     * compile 编译模板内容
     * @param string $source  模板文件
     * @param array $values  键值对
     * @param string $dstFile 编译后文件
     * @return string|$this
     */
    public function compile($source, $dstFile = null, array $values = [])
    {
        $this->_valueMap = $values;
        $this->_compiled = $this->_content = trim($source);

        if (strpos($this->_content, '{$') !== false) {
            $this->_compiled = preg_replace($this->_patterns, $this->_replaces, $this->_content);
        }

        if ($this->_compiledFile = $dstFile) {
            file_put_contents($dstFile, $this->_compiled);

            return $this;
        }

        return $this->_compiled;
    }

    /**
     * render 编译后的文件
     * @param string $file 编译后的文件
     * @param array $data 键值对
     * @return string
     * @throws \Throwable
     */
    public function render(array $data = [], $file = null)
    {
        $file = $file ?: $this->_compiledFile;

        if ($this->_valueMap) {
            $data = array_merge($this->_valueMap, $data);
        }

        try {
            ob_start();
            $this->protectedIncludeScope($file, $data);
            $output = ob_get_clean();
        } catch (\Throwable $e) { // PHP 7+
            ob_end_clean();
            throw $e;
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
     * @return mixed
     */
    public function getCompiledDir()
    {
        return $this->_compiledDir;
    }

    /**
     * @param string $compiledDir
     * @return Compiler
     */
    public function setCompiledDir($compiledDir)
    {
        $this->_compiledDir = $compiledDir;

        return $this;
    }
}
