<?php
namespace App\Modules\Api\Components\Service;

abstract class Service_Abstract
{
    /**
     * @var string
     */
    private $_type;


    /**
     * @var mixed
     */
    protected $_resultData;


    /**
     * @param mixed $data
     */
    public function setResultData ($data)
    {
        $this->_resultData = $data;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getResultData ()
    {
        return $this->_resultData;
    }


    /**
     * @see http://php.net/manual/en/language.oop5.magic.php
     * @return array
     */
    public function __sleep()
    {
        if ($this->_resultData instanceof Transfer_Interface) {
            $this->_type = $this->_resultData->getClassName();
            $this->_resultData = $this->_resultData->toArray();
        } else {
            $this->_type = null;
        }

        /*
         * If an object is converted to an array, the result is an array whose elements are the object's properties.
		 * http://www.php.net/manual/en/language.types.array.php
         */
        return array_keys((array) $this);
    }


    /**
     * @see http://php.net/manual/en/language.oop5.magic.php
     */
    public function __wakeup()
    {
        if (null !== $this->_type) {
            $type = $this->_type;
            $this->_resultData = new $type($this->_resultData);
            $this->_type = null;
        }
    }
}