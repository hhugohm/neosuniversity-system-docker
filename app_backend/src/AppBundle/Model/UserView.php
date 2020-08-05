<?php
/**
 * Created by IntelliJ IDEA.
 * User: neossoftware
 * Date: 09/05/18
 * Time: 16:29
 */

namespace AppBundle\Model;


class UserView
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     *
     */
    private $completename;

    /**
     * @var string
     *
     */
    private $idcountry;

    /**
     * @var \DateTime
     */
    private $enrollmentDate;

    /**
     * @var integer
     *
     */
    private $payIsComplete;


    /**
     * @var string
     *
     */
    private $paypalOrderId;


    /**
     * @var string
     *
     */
    private $paypalPaymentId;

    /**
     * @return int
     */
    public function getPayIsComplete()
    {
        return $this->payIsComplete;
    }

    /**
     * @param int $payIsComplete
     */
    public function setPayIsComplete($payIsComplete)
    {
        $this->payIsComplete = $payIsComplete;
    }

    /**
     * @return string
     */
    public function getPaypalOrderId()
    {
        return $this->paypalOrderId;
    }

    /**
     * @param string $paypalOrderId
     */
    public function setPaypalOrderId($paypalOrderId)
    {
        $this->paypalOrderId = $paypalOrderId;
    }

    /**
     * @return string
     */
    public function getPaypalPaymentId()
    {
        return $this->paypalPaymentId;
    }

    /**
     * @param string $paypalPaymentId
     */
    public function setPaypalPaymentId($paypalPaymentId)
    {
        $this->paypalPaymentId = $paypalPaymentId;
    }




    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCompletename()
    {
        return $this->completename;
    }

    /**
     * @param string $completename
     */
    public function setCompletename($completename)
    {
        $this->completename = $completename;
    }

    /**
     * @return string
     */
    public function getIdcountry()
    {
        return $this->idcountry;
    }

    /**
     * @param string $idcountry
     */
    public function setIdcountry($idcountry)
    {
        $this->idcountry = $idcountry;
    }

    /**
     * @return \DateTime
     */
    public function getEnrollmentDate()
    {
        return $this->enrollmentDate;
    }

    /**
     * @param \DateTime $enrollmentDate
     */
    public function setEnrollmentDate($enrollmentDate)
    {
        $this->enrollmentDate = $enrollmentDate;
    }



}