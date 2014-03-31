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
}
