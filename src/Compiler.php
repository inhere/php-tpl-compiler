<?php

namespace Inhere\Stc;

/**
 * @link http://www.jb51.net/article/122699.htm
 */
class Compiler extends Object
{
    private $_content;

    private $_compiled;

    private $_valueMap = [];

    private $_patten = [
        '#\{\\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)\}#',
        '#\{if (.*?)\}#',
        '#\{(else if|elseif) (.*?)\}#',
        '#\{else\}#',
        '#\{foreach \\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)}#',
        '#\{foreach \\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*) (.*?)}#',
        '#\{\/(foreach|if)}#',
        '#\{\\^(k|v)\}#',
    ];

    private $_translation = [
        // old: echo \$this->_valueMap['\\1'];
        "<?php echo \$\\1; ?>",
        '<?php if (\\1) {?>',
        '<?php } else if (\\2) {?>',
        '<?php }else {?>',
        "<?php foreach (\$\\1 as \$k => \$v) {?>",
        "<?php foreach (\$\\1 \\2) {?>",
        '<?php }?>',
        '<?php echo \$\\1?>',
    ];

    /**
     * compile 编译模板文件
     * @param string $source  模板文件
     * @param array $values  键值对
     * @param string $dstFile 编译后文件
     * @return string|int
     */
    public function compileFile($srcFile, array $values, $dstFile = null)
    {
        $content = file_get_contents($srcFile);

        return $this->compile($content, $values, $dstFile);
    }

    /**
     * compile 编译模板内容
     * @param string $source  模板文件
     * @param array $values  键值对
     * @param string $dstFile 编译后文件
     * @return string|int
     */
    public function compile($source, array $values, $dstFile = null)
    {
        $this->_valueMap = $values;
        $this->_compiled = $this->_content = trim($source);

        if (strpos($this->_content, '{$') !== false) {
            $this->_compiled = preg_replace($this->_patten, $this->_translation, $this->_content);
        }

        if ($dstFile) {
            return file_put_contents($dstFile, $this->_compiled);
        }

        return $this->_compiled;
    }
}
