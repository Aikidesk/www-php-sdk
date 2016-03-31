<?php
namespace Aikidesk\SDK\WWW\Contracts;

interface ResponseInterface
{
    /**
     * @return mixed
     */
    public function getRateReset();

    /**
     * @param mixed $rateReset
     */
    public function setRateReset($rateReset);

    /**
     * @return mixed
     */
    public function getRateRemaining();

    /**
     * @param mixed $rateRemaining
     */
    public function setRateRemaining($rateRemaining);

    /**
     * @return mixed
     */
    public function getRateLimit();

    /**
     * @param mixed $rateLimit
     */
    public function setRateLimit($rateLimit);

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @param mixed $data
     */
    public function setData($data);

    /**
     * @return mixed
     */
    public function getResponseCode();

    /**
     * @param mixed $responseCode
     */
    public function setResponseCode($responseCode);

    /**
     * If response is among OK status codes
     * @return bool
     */
    public function isOk();

    /**
     * @return string
     */
    public function getPlainBody();

    /**
     * @param string $plainBody
     */
    public function setPlainBody($plainBody);
}
