<?php


namespace Tool\ShanTaoTool\Bean\BaseAuth;


use Tool\ShanTaoTool\Bean\BaseBean;

class AddUserParamBean extends BaseBean
{
    private $userPhone;//手机号码

    private $userName;//用户名称

    private $userEmail;//用户邮箱

    private $userPassword;//用户密码

    private $userProjectId;//项目ID

    /**
     * @return mixed
     */
    public function getUserProjectId()
    {
        return $this->userProjectId;
    }

    /**
     * @param mixed $userProjectId
     */
    public function setUserProjectId($userProjectId)
    {
        $this->userProjectId = $userProjectId;
    }

    /**
     * @return mixed
     */
    public function getUserPhone()
    {
        return $this->userPhone;
    }

    /**
     * @param mixed $userPhone
     */
    public function setUserPhone($userPhone)
    {
        $this->userPhone = $userPhone;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * @param mixed $userEmail
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return mixed
     */
    public function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * @param mixed $userPassword
     */
    public function setUserPassword($userPassword)
    {
        $this->userPassword = $userPassword;
    }

}