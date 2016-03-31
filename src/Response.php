<?php
namespace Aikidesk\SDK\WWW;

use Aikidesk\SDK\WWW\Contracts\ResponseInterface;
use ArrayAccess;

/**
 * Class Response
 */
class Response implements ResponseInterface, ArrayAccess
{

    /**
     * @var int
     */
    protected $rateLimit;

    /**
     * @var int
     */
    protected $rateRemaining;

    /**
     * @var int
     */
    protected $rateReset;

    /**
     * @var string
     */
    protected $plainBody;

    /**
     * @var mixed|array
     */
    protected $data;

    /**
     * @var int
     */
    protected $responseCode;

    /**
     * Array with http responce codes which indicate OK
     * @var array
     */
    protected $ok_http_codes = [200, 201, 202, 204];

    /**
     * Response constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getRateReset()
    {
        return $this->rateReset;
    }

    /**
     * @param mixed $rateReset
     */
    public function setRateReset($rateReset)
    {
        $this->rateReset = $rateReset;
    }

    /**
     * @return mixed
     */
    public function getRateRemaining()
    {
        return $this->rateRemaining;
    }

    /**
     * @param mixed $rateRemaining
     */
    public function setRateRemaining($rateRemaining)
    {
        $this->rateRemaining = $rateRemaining;
    }

    /**
     * @return mixed
     */
    public function getRateLimit()
    {
        return $this->rateLimit;
    }

    /**
     * @param mixed $rateLimit
     */
    public function setRateLimit($rateLimit)
    {
        $this->rateLimit = $rateLimit;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * If response is among OK status codes
     * @return bool
     */
    public function isOk()
    {
        if (in_array($this->getResponseCode(), $this->ok_http_codes)) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @param mixed $responseCode
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
    }

    /**
     * @return string
     */
    public function getPlainBody()
    {
        return $this->plainBody;
    }

    /**
     * @param string $plainBody
     */
    public function setPlainBody($plainBody)
    {
        $this->plainBody = $plainBody;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     * @return boolean true on success or false on failure.
     *                      </p>
     *                      <p>
     *                      The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
