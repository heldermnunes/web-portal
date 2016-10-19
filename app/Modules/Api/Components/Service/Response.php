<?php

namespace App\Modules\Api\Components\Service;


class Service_Response
{

    /**
     * @var boolean
     */
    protected $_success;
    /**
     * @var array
     */
    protected $_errorMessages = [];
    /**
     * @var array
     */
    protected $_successMessages = [];
    /**
     * @var array
     */
    protected $_validationMessages = [];

    /**
     * @var string
     */
    private $_type;

    /** @var array */
    protected $header = [];


    /**
     * @var mixed
     */
    protected $_resultData;


    /**
     * @param mixed $data
     */
    public function setResultData($data)
    {
        $this->_resultData = $data;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getResultData()
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
        return array_keys((array)$this);
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


    /**
     *
     * @param Transfer_AbstractObject $transfer
     * @param boolean $success
     * @param string $message
     */
    public function __construct(Transfer_AbstractObject $transfer = null, $success = null, $successMessages = array(), $errorMessages = array())
    {
        if (isset($success)) {
            $this->setSuccess($success);
        }
        $this->setResultData($transfer);
        $this->setSuccessMessages($successMessages);
        $this->setErrorMessages($errorMessages);
    }

    /**
     * @param bool $success
     * @return Service_Response
     */
    public function setSuccess($success)
    {
        assert('is_bool($success)');
        $this->_success = $success;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFailure()
    {
        return !$this->isSuccess();
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return (boolean)$this->_success;
    }

    /**
     * @param array $messages
     * @return Service_Response
     */
    public function setErrorMessages(array $messages)
    {
        $this->_errorMessages = $messages;
        return $this;
    }

    /**
     * @param string $message
     * @return Service_Response
     */
    public function addErrorMessage($message)
    {
        if (is_array($message)) {
            $this->_errorMessages = array_merge($this->_errorMessages, $message);
        } else {
            $this->_errorMessages[] = $message;
        }
        return $this;
    }

    /**
     * @param array $messages
     * @return Service_Response
     */
    public function setSuccessMessages(array $messages)
    {
        $this->_successMessages = $messages;
        return $this;
    }

    /**
     * Add one success message to the list of success messages
     * @param string $message
     * @return Service_Response
     */
    public function addSuccessMessage($message)
    {
        $this->_successMessages[] = $message;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return $this->_errorMessages;
    }

    /**
     * @return array
     */
    public function getSuccessMessages()
    {
        return $this->_successMessages;
    }

    /**
     * @param array $messages
     * @return Service_Response
     */
    public function setValidationMessages(array $messages)
    {
        $this->_validationMessages = $messages;
        return $this;
    }

    /**
     * @param string $partialName
     * @return array
     */
    public function getValidationMessages($partialName = null)
    {
        if ($partialName) {
            if (array_key_exists($partialName, $this->_validationMessages)) {
                return $this->_validationMessages[$partialName];
            } else {
                return array();
            }
        } else {
            return $this->_validationMessages;
        }
    }

    /**
     * @param array $messages
     * @return Service_Response
     */
    public function setNoticeMessages(array $messages)
    {
        $this->_noticeMessages = $messages;
        return $this;
    }

    /**
     * @return array
     */
    public function getNoticeMessages()
    {
        return $this->_noticeMessages;
    }

    /**
     * @param $message
     * @return \Service_Response
     */
    public function addNoticeMessage($message)
    {
        $this->_noticeMessages[] = $message;
        return $this;
    }

    /**
     * @return bool
     */
    public function  hasNoticeMessages()
    {
        return count($this->getNoticeMessages()) > 0;
    }


    /**
     * Checks if validation errors exist
     * @return bool
     */
    public function hasValidationErrors()
    {
        return count($this->getValidationMessages()) > 0;
    }

    /**
     * Checks if error messages exist
     * @return bool
     */
    public function hasErrorMessages()
    {
        return count($this->getErrorMessages()) > 0;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return boolean
     */
    public function hasRedirectUrl()
    {
        return (null !== $this->redirectUrl);
    }

    public function getHeader()
    {
        if (empty($this->header)) {
            $this->header = [
                'XSRF-TOKEN' => $_COOKIE['XSRF-TOKEN'],
                'laravel_session' => $_COOKIE['laravel_session'],
                'request_url' => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                'request_method' => $_SERVER['REQUEST_METHOD']
            ];
        }

        return $this->header;
    }

    public function prepareResponse()
    {
        $messages = [];
        ;
        if ($this->hasErrorMessages()) {
            $messages['error'] = $this->getErrorMessages();
        } else {
            $messages['success'] = $this->getSuccessMessages();
        }

        $response = [
            'header' => $this->getHeader(),
            'success' => $this->isSuccess(),
            'messages' => $messages,
            'metadata' => $this->getResultData()
        ];
        return json_encode($response);
    }

}
