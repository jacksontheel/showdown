<?php
// A class representing a single match. Contains queries related to a match.
require_once "Dao.php";

class Fight
{
    public $id;

    public function __construct($fightId)
    {
        $this->id = $fightId;
    }

    public function getContestants()
    {
        $dao = new Dao();
        $conn = $dao->getConnection();
        $query = "SELECT * FROM fightcontestant
                  JOIN contestant ON fightcontestant.contestant = contestant.username 
                  WHERE fightId = " . $this->id;
        
        return $conn->query($query);
    }

    public function contestantsString()
    {
        // Will need to reimplement if we ever introduce more than just 1-on-1 fights.
        $contestants = $this->getContestants();
        return $contestants->fetch()["username"] . " vs. " . $contestants->fetch()["username"];
    }

    public function hasVotes()
    {
        $dao = new Dao();
        $conn = $dao->getConnection();
        $query = "SELECT * FROM vote JOIN fightcontestant
                  ON fightcontestantid = fightcontestant.id 
                  WHERE fightid = " . $this->id;

        $result = $conn->query($query);
        return $result->rowCount() != 0;
    }

    public function getFillPercent()
    {
        if(!$this->hasVotes())
        {
            return 50;
        }

        $dao = new Dao();
        $conn = $dao->getConnection();
        $query = "SELECT fightcontestantid, COUNT(*) * 100 / total AS percent 
                  FROM vote CROSS JOIN (
                      SELECT COUNT(*) AS total FROM vote 
                      JOIN fightcontestant ON fightcontestantid = fightcontestant.id
                      WHERE fightid=" . $this->id . ") AS t
                  JOIN fightcontestant ON fightcontestantid = fightcontestant.id
                  WHERE fightid = " . $this->id . " and contestant = 
                  (select contestant from fightcontestant where fightid = " . $this->id . " order by id limit 1)
                  GROUP BY fightcontestantid, total";
        
        $result = $conn->query($query);

        if ($result->rowCount() == 0)
        {
            return 0;
        }
        
        return $result->fetch()["percent"];
    }

    public function hasVoted($username)
    {
        $dao = new Dao();
        $conn = $dao->getConnection();
        $query =
            "SELECT * FROM vote 
            JOIN fightcontestant 
            ON vote.fightcontestantid = fightcontestant.id 
            WHERE fightid = :id AND voter = :voter";
        $q = $conn->prepare($query);
        $q->bindParam(":voter", $username);
        $q->bindParam(":id", $this->id);
        $q->execute();

        return $q->rowCount() > 0;
    }

    public static function addVote($username, $fcid)
    {
        try
        {
            $dao = new Dao();
            $conn = $dao->getConnection();
            $query =
                "INSERT INTO vote (voter, fightcontestantid) 
                VALUES (:voter, :fcid)";
            $q = $conn->prepare($query);
            $q->bindParam(":voter", $username);
            $q->bindParam(":fcid", $fcid);
            $q->execute();
        }
        catch (Exception $e)
        {
        }
    }
}