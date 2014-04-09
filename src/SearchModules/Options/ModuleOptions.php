<?php
    
namespace SearchModules\Options;

use Zend\Stdlib\AbstractOptions;



class ModuleOptions extends AbstractOptions
{
    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    protected $modules = [];
    
    protected $indexDir = '/var/www/data/search_index';

    /**
     * How often the cron should fully rebuild the search index, should be a cronExpression
     * @link( https://github.com/heartsentwined/zf2-cron )
     * @var string
     */
    protected $indexFrequencyExpression = '* * * * *';

    /**
     * Gets the Turn off strict options mode.
     *
     * @return mixed
     */
    public function get__strictMode__()
    {
        return $this->__strictMode__;
    }

    /**
     * Sets the Turn off strict options mode.
     *
     * @param mixed $__strictMode__ the __strict mode__
     *
     * @return self
     */
    public function set__strictMode__($__strictMode__)
    {
        $this->__strictMode__ = $__strictMode__;

        return $this;
    }

    /**
     * Gets the value of modules.
     *
     * @return mixed
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Sets the value of modules.
     *
     * @param mixed $modules the modules
     *
     * @return self
     */
    public function setModules($modules)
    {
        $this->modules = $modules;

        return $this;
    }

    /**
     * Gets the value of indexDir.
     *
     * @return mixed
     */
    public function getIndexDir()
    {
        return $this->indexDir;
    }

    /**
     * Sets the value of indexDir.
     *
     * @param mixed $indexDir the index dir
     *
     * @return self
     */
    public function setIndexDir($indexDir)
    {
        $this->indexDir = $indexDir;

        return $this;
    }

    /**
     * Gets the How often the cron should fully rebuild the search index, should be a cronExpression.
     *
     * @return string
     */
    public function getIndexFrequencyExpression()
    {
        return $this->indexFrequencyExpression;
    }

    /**
     * Sets the How often the cron should fully rebuild the search index, should be a cronExpression.
     *
     * @param string $indexFrequencyExpression the index frequency expression
     *
     * @return self
     */
    public function setIndexFrequencyExpression($indexFrequencyExpression)
    {
        $this->indexFrequencyExpression = $indexFrequencyExpression;

        return $this;
    }
}
