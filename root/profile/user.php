<?php
class User {
    private $username = "";
    private $displayname = "";
    private $email = "";
    private $isAdministrator = false;
    private $isModerator = false;
    
    /**
    function __construct
        Params: username (A User's username)
                displayname (A User's display name)
                email (A User's email address)
        Default constructor for a User object
    **/
    public function __construct($username, $displayname, $email) {
        $this->username = $username;
        $this->displayname = $displayname;
        $this->email = $email;
    }
    
    /**
    function setAdminStatus
        Gives the User admin privileges
        Inherently gives the User mod privileges as well
    **/
    public function setAdminStatus() {
        $this->isAdministrator = true;
        $this->setModStatus();
    }
    
    /**
    function getAdminStatus
        Returns the User's administrative status
    **/
    public function getAdminStatus() {
        return $this->isAdministrator;
    }
    
    /**
    function setModStatus
        Gives the User mod privileges
    **/
    public function setModStatus() {
        $this->isModerator = true;
    }
    
    /**
    function getModStatus
        Returns the User's moderator status
    **/
    public function getModStatus() {
        return $this->isModerator;
    }
    
    /**
    function getUsername
        Returns the User's username
    **/
    public function getUsername() {
        return $this->username;   
    }
    
    /**
    function getUsername
        Returns the User's display name
    **/
    public function getDisplayname() {
        return $this->displayname;   
    }
    
    /**
    function setDisplayname
        Params: displayname (A new display name for the User)
        Updates the User's display name
    **/
    public function setDisplayname($displayname) {
        $this->displayname = $displayname;
    }
    
    /**
    function getEmail
        Returns the User's email address
    **/
    public function getEmail() {
        return $this->email;
    }
}
?>