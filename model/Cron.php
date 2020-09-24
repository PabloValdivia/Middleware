<?php

/**
 *
 * Author : David Marquez
 * Date   : 22 September 2020
 * 
 */
require(MDLPH . 'Base.php');

class Cron extends Base
{
    /** Table Head */
    public $thead = ['#', 'module', 'action'];

    public function readCron()
    {
        $this->data = explode('|', $this->crontab);
        $this->getModules();

        $this->title = $this->module;
        $this->description = ucfirst($this->module) . ' details';
    }

    public function getModules()
    {
        $i = 0;
        foreach ($this->data as $key) {
            $this->data[$i] = array(
                'id'        => $i + 1,
                'modules'   => $this->data[$i],
                'button'    => [
                    'button'    =>  $this->getFlag('button', 1),
                    'icon'      =>  $this->getIcon('method', 'info'),
                    'module'    =>  $this->data[$i],
                    'method'    =>  'info'
                ]
            );
            $i++;
        }
    }
}
