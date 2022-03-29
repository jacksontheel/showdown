<?php
// class for sending database queries, used by other classes that depend on sending queries
class Dao {

    public function getConnection () {
        $host= getenv('fightHost');
        $db = getenv('fightDb');
        $user = getenv('fightUser');
        $pass = getenv('fightPass');
        $dsn = "pgsql:host=$host;port=5432;dbname=$db;";
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return $pdo;
    }

    public function saveComment ($comment, $author, $fightid)
    {
        try
        {
            $conn = $this->getConnection();
            $saveQuery =
                "INSERT INTO comment
                (content, author, fightId)
                VALUES
                (:comment, :author, :fightid)";
            $q = $conn->prepare($saveQuery);
            $q->bindParam(":comment", $comment);
            $q->bindParam(":author", $author);
            $q->bindParam(":fightid", $fightid);
            $q->execute();
        }
        catch (Exception $e)
        {
        }
    }

    public function removeComment ($author, $fightid)
    {
            $conn = $this->getConnection();
            $saveQuery =
                "delete from comment where 
                author= :author 
                and fightid = :fightid;";
            $q = $conn->prepare($saveQuery);
            $q->bindParam(":author", $author);
            $q->bindParam(":fightid", $fightid);
            $q->execute();       
    }

    public function getComments ($fightid) {
        $conn = $this->getConnection();
        return $conn->query("SELECT * FROM comment WHERE fightid = " . $fightid . "ORDER BY id DESC");
    }

    public function checkUser($username, $password)
    {
        $retVal = false;

        $conn = $this->getConnection();
        $userQuery =
            "SELECT password FROM appUser WHERE username=:username";
        $q = $conn->prepare($userQuery);
        $q->bindParam(":username", $username);
        $q->execute();

        if ($q->rowCount() === 1)
        {
            $retVal = password_verify($password, $q->fetch()["password"]);
        }

        return $retVal;
    }

    public function checkUserExists($username)
    {
        $conn = $this->getConnection();
        $userQuery =
            "SELECT password FROM appUser WHERE username=:username";
        $q = $conn->prepare($userQuery);
        $q->bindParam(":username", $username);
        $q->execute();

        return $q->rowCount() === 1;
    }

    public function createUser($username, $password)
    {
        $conn = $this->getConnection();
        $saveQuery =
            "INSERT INTO appUser 
            (username, password)
            VALUES
            (:username, :password)";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":username", $username);
        $q->bindParam(":password", $password);
        $q->execute();
    }

} // end Dao