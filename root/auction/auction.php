<?php
//require_once("../dependencies/underscore.php");

//$underscore = new __;

class Auction {
    private $auction_title = "";
    private $auction_desc = "";
    private $user_id = 0;
    private $auction_id = 0;
    private $bin_price = 0.00;
    private $start_bid_price = 0.00;
    private $isbn = "";
    private $username = "";
    private $displayname = "";
    private $creation_time = null;
    private $end_time = null;
    private $auction_ended = false;
    private $winner_username = "";

    public function __construct() {
        
    }
    
    function setAuctionTitle($auctionTitle) {
        if($this->auction_title != $auctionTitle) {
            $this->auction_title = $auctionTitle;
        }
    }

    function getAuctionTitle() {
        return $this->auction_title;
    }

    function setAuctionDesc($auctionDesc) {
        if($this->auction_desc != $auctionDesc) {
            $this->auction_desc = $auctionDesc;
        }
    }

    function getAuctionDesc() {
        return $this->auction_desc;
    }
    
    function setAuctionId($auctionId) {
        if($this->auction_id != $auctionId) {
            $this->auction_id = $auctionId;
        }
    }

    function getAuctionId() {
        return $this->auction_id;
    }

    function setUserId($userId) {
        if($this->user_id != $userId) {
            $this->user_id = $userId;
        }
    }

    function getUserId() {
        return $this->user_id;
    }

    function setBINPrice($binPrice) {
        if($this->bin_price != $binPrice) {
            $this->bin_price = $binPrice;
        }
    }

    function getBINPrice() {
        return $this->bin_price;
    }
    
    function setStartBidPrice($startBidPrice) {
        if($this->start_bid_price != $startBidPrice) {
            $this->start_bid_price = $startBidPrice;
        }
    }

    function getStartBidPrice() {
        return $this->start_bid_price;
    }
    
    function setISBN($ISBN) {
        if($this->isbn != $ISBN) {
            $this->isbn = $ISBN;
        }
    }

    function getISBN() {
        return $this->isbn;
    }
    
    function setSellerUserName($username) {
        if($this->username != $username) {
            $this->username = $username;
        }
    }

    function getSellerUserName() {
        return $this->username;
    }
    
    function setSellerDisplayName($displayname) {
        if($this->displayname != $displayname) {
            $this->displayname = $displayname;
        }
    }

    function getSellerDisplayName() {
        return $this->displayname;
    }
    
    function setCreationTime($creationTime) {
        if($this->creation_time != $creationTime) {
            $this->creation_time = $creationTime;
        }
    }
    
    function getCreationTime() {
        return $this->creation_time;
    }
    
    function setEndTime($endTime) {
        if($this->end_time != $endTime) {
            $this->end_time = $endTime;
        }
    }
    
    function getEndTime() {
        return $this->end_time;
    }
    
    function setAuctionEnded($auctionEnded) {
        if($this->auction_ended != $auctionEnded) {
            $this->auction_ended = $auctionEnded;
        }
    }
    
    function getAuctionEnded() {
        return $this->auction_ended;
    }
    
    function setWinnerUserName($winnerUserName) {
        if($this->winner_username != $winnerUserName) {
            $this->winner_username = $winnerUserName;
        }
    }
    
    function getWinnerUserName() {
        return $this->winner_username;
    }
}

?>