<?php
// A class representing a user of the app. Contains SQL queries related to user.
require_once "Dao.php";

class DiaryEntry {
    public $contestant;
    public $comment;

    public function __construct($contestant, $comment)
    {
        $this->contestant = $contestant;
        $this->comment = $comment;
    }
}

class AppUser {

    private string $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    public function getUsername ()
    {
        return $this->username;
    }

    public function getDiary()
    {
        $dao = new Dao();
        $conn = $dao->getConnection();
        $query = "SELECT * FROM vote JOIN fightcontestant
                  ON fightcontestantid = fightcontestant.id 
                  WHERE voter=:username 
                  ORDER BY vote.id DESC";
        
        $q = $conn->prepare($query);
        $q->bindParam(":username", $this->username);
        $q->execute();

        $retVal = [];
        foreach ($q as $entry)
        {
            $query = "SELECT * FROM comment WHERE author=:username
                      AND fightid = " . $entry["fightid"] . " LIMIT 1";
            $innerQ = $conn->prepare($query);
            $innerQ->bindParam(":username", $this->username);
            $innerQ->execute();

            $comment = "";
            if($innerQ->rowCount() == 1)
            {
                $comment = $innerQ->fetch()["content"];
            }
            
            $retVal[$entry["fightid"]] = new DiaryEntry($entry["contestant"], $comment);
        }
        return $retVal;
    }

    public function sendRequestFrom($follower)
    {
        $dao = new Dao();
        $conn = $dao->getConnection();
        $query = "insert into follows(followee, follower) values (:followee, :follower)";
        $q = $conn->prepare($query);
        $q->bindParam(":followee", $this->username);
        $q->bindParam(":follower", $follower);
        $q->execute();
    }

    public function numberOfVotes()
    {
        $dao = new Dao();
        $conn = $dao->getConnection();
        $query = "SELECT COUNT(*) FROM vote WHERE voter=:username GROUP BY voter LIMIT 1";
        
        $q = $conn->prepare($query);
        $q->bindParam(":username", $this->username);
        $q->execute();
        
        if($q->rowCount() == 0)
        {
            return 0;
        }

        return $q->fetch()["count"];
    }

    public function getCreateDate()
    {
        $dao = new Dao();
        $conn = $dao->getConnection();
        $query = "SELECT creationdate FROM appUser WHERE username=:username";

        $q = $conn->prepare($query);
        $q->bindParam(":username", $this->username);
        $q->execute();

        return date("F d, Y", strtotime($q->fetch()["creationdate"]));
    }

}