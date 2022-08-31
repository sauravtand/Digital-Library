<?php include("db.php");

class data extends db
{

    private $bookpic;
    private $bookname;
    private $bookdetail;
    private $bookaudor;
    private $bookpub;
    private $branch;
    private $bookprice;
    private $type;
    private $bookava;
    private $bookquantity;
    private $newbookrent;

    private $book;
    private $userselect;
    private $days;
    private $getdate;
    private $returnDate;





    function __construct()
    {
        // echo " constructor ";
        echo "</br></br>";
    }


    function addnewuser($name, $pasword, $email, $type)
    {
        $this->name = $name;
        $this->pasword = $pasword;
        $this->email = $email;
        $this->type = $type;


        $q = "INSERT INTO userdata(id, name, email, pass,type)VALUES('','$name','$email','$pasword','$type')";

        if ($this->connection->exec($q)) {
            header("Location:admin_service_dashboard.php?msg=New Add done");
        } else {
            header("Location:admin_service_dashboard.php?msg=Register Fail");
        }
    }

    function userLogin($t1, $t2)
    {
        $q = "SELECT * FROM userdata where email='$t1' and pass='$t2'";
        $recordSet = $this->connection->query($q);
        $result = $recordSet->rowCount();
        if ($result > 0) {

            foreach ($recordSet->fetchAll() as $row) {
                $logid = $row['id'];
                header("location: otheruser_dashboard.php?userlogid=$logid");
            }
        } else {
            header("location: index.php?msg=Invalid Credentials");
        }
    }


    function adminLogin($t1, $t2)
    {

        $q = "SELECT * FROM admin where email='$t1' and pass='$t2'";
        $recordSet = $this->connection->query($q);
        $result = $recordSet->rowCount();


        if ($result > 0) {

            foreach ($recordSet->fetchAll() as $row) {
                $logid = $row['id'];
                header("Location: admin_service_dashboard.php?logid=$logid");
            }
        } else {
            header("Location: index.php?msg=Invalid Credentials");
        }
    }



    function addbook($bookpic, $bookname, $bookdetail, $bookaudor, $bookpub, $branch, $bookprice, $bookquantity, $bookava, $bookrent)
    {
        $this->$bookpic = $bookpic;
        $this->bookname = $bookname;
        $this->bookdetail = $bookdetail;
        $this->bookaudor = $bookaudor;
        $this->bookpub = $bookpub;
        $this->branch = $branch;
        $this->bookprice = $bookprice;
        $this->bookquantity = $bookquantity;
        $this->bookava = $bookava;
        $this->bookrent = $bookrent;

        $newDa = "$bookpub";

        $q = 'INSERT INTO book (bookpic,bookname, bookdetail, bookaudor, bookpub, branch, bookprice,bookquantity,bookava,bookrent)VALUES("' . $bookpic . '", "' . $bookname . '", "' . $bookdetail . '", "' . $bookaudor . '", "' . $newDa . '", "' . $branch . '", ' . $bookprice . ', ' . $bookquantity . ',' . $bookava . ',"' . $bookrent . '")';

        if ($this->connection->exec($q)) {
            header("Location:admin_service_dashboard.php?msg=done");
        } else {
            header("Location:admin_service_dashboard.php?msg=fail");
        }
    }


    private $id;



    function getissuebook($userloginid)
    {
        $q = "SELECT * FROM issuebook where userid='$userloginid'";
        $data = $this->connection->query($q);
        return $data;
    }

    function getbook()
    {
        $q = "SELECT * FROM book ";
        $data = $this->connection->query($q);
        return $data;
    }
    function getbookissue()
    {
        $q = "SELECT * FROM book where bookava !=0 ";
        $data = $this->connection->query($q);
        return $data;
    }

    function userdata()
    {
        $q = "SELECT * FROM userdata ";
        $data = $this->connection->query($q);
        return $data;
    }


    function getbookdetail($id)
    {
        $q = "SELECT * FROM book where id ='$id'";
        $data = $this->connection->query($q);
        return $data;
    }

    function userdetail($id)
    {
        $q = "SELECT * FROM userdata where id ='$id'";
        $data = $this->connection->query($q);
        return $data;
    }



    function requestbook($userid, $bookid)
    {

        $q = "SELECT * FROM book where id='$bookid'";
        $recordSetss = $this->connection->query($q);

        $q = "SELECT * FROM userdata where id='$userid'";
        $recordSet = $this->connection->query($q);

        foreach ($recordSet->fetchAll() as $row) {
            $username = $row['name'];
            $usertype = $row['type'];
        }

        foreach ($recordSetss->fetchAll() as $row) {
            $bookname = $row['bookname'];
        }

        if ($usertype == "student") {
            $days = 7;
        }
        if ($usertype == "teacher" || $usertype == "admin") {
            $days = 14;
        }


        $q = "INSERT INTO requestbook (id,userid,bookid,username,usertype,bookname,issuedays)VALUES('','$userid', '$bookid', '$username', '$usertype', '$bookname', '$days')";

        if ($this->connection->exec($q)) {
            header("Location:otheruser_dashboard.php?userlogid=$userid");
        } else {
            header("Location:otheruser_dashboard.php?msg=fail");
        }
    }


    function returnbook($id)
    {
        // $fine = "";
        $bookaval = "";
        $issuebook = "";
        $bookrentel = "";

        $q = "SELECT * FROM issuebook where id='$id'";
        $recordSet = $this->connection->query($q);

        foreach ($recordSet->fetchAll() as $row) {
            $userid = $row['userid'];
            $issuebook = $row['issuedbook'];
            // $fine = $row['fine'];
        }


        $q = "SELECT * FROM book where bookname='$issuebook'";
        $recordSet = $this->connection->query($q);

        foreach ($recordSet->fetchAll() as $row) {
            $bookaval = $row['bookava'] + 1;
            $bookrentel = $row['bookrent'] - 1;
        }
        $q = "UPDATE book SET bookrent='$bookrentel' where bookname='$issuebook'";
        $this->connection->exec($q);

        $q = "DELETE from issuebook where id=$id and issuedbook='$issuebook'";
        if ($this->connection->exec($q)) {


            header("Location:admin_service_dashboard.php?msg=done");
        } else {
            header("Location:admin_service_dashboard.php?msg=fail");
        }
    }

    function delteuserdata($id)
    {
        $q = "DELETE from userdata where id='$id'";
        if ($this->connection->exec($q)) {
            header("Location:admin_service_dashboard.php?msg=done");
        } else {
            header("Location:admin_service_dashboard.php?msg=fail");
        }
    }

    function deletebook($id)
    {
        $q = "DELETE from book where id='$id'";
        if ($this->connection->exec($q)) {
            header("Location:admin_service_dashboard.php?msg=done");
        } else {
            header("Location:admin_service_dashboard.php?msg=fail");
        }
    }


    function deletebookrequest($id)
    {
        $q = "DELETE from requestbook where id='$id'";

        if ($this->connection->exec($q)) {
            header("Location:admin_service_dashboard.php?msg=done");
        } else {
            header("Location:admin_service_dashboard.php?msg=fail");
        }
    }

    function issuereport()
    {
        $q = "SELECT * FROM issuebook ";
        $data = $this->connection->query($q);
        return $data;
    }

    function requestbookdata()
    {
        $q = "SELECT * FROM requestbook ";
        $data = $this->connection->query($q);
        return $data;
    }

    // issue issuebookapprove
    function issuebookapprove($book, $user, $returnDate, $redid)
    {
        // $this->$book = $book;
        // $this->$user = $user;
        // $this->$days = $days;
        // $this->$getdate = $getdate;
        // $this->$returnDate = $returnDate;
        // $this->$redid = $redid;


        $q = "SELECT * FROM book where bookname='$book'";
        $recordSetss = $this->connection->query($q);

        $q = "SELECT * FROM userdata where name='$user'";
        $recordSet = $this->connection->query($q);
        $result = $recordSet->rowCount();

        if ($result > 0) {

            foreach ($recordSet->fetchAll() as $row) {
                $issueid = $row['id'];
                $issuetype = $row['type'];

                // header("location: admin_service_dashboard.php?logid=$logid");
            }
            foreach ($recordSetss->fetchAll() as $row) {
                $bookid = $row['id'];
                $bookname = $row['bookname'];

                $newbookava = $row['bookava'] - 1;
                $newbookrent = $row['bookrent'] + 1;
            }


            $q = "UPDATE book SET bookava='$newbookava', bookrent='$newbookrent' where id='$bookid'";
            if ($this->connection->exec($q)) {

                $q = "INSERT INTO issuebook (userid,issuename,issuedbook,returndate)VALUES('$issueid','$user','$book','$returnDate')";

                if ($this->connection->exec($q)) {

                    $q = "DELETE from requestbook where id='$redid'";
                    $this->connection->exec($q);
                    header("Location:admin_service_dashboard.php?msg=done");
                } else {
                    header("Location:admin_service_dashboard.php?msg=fail");
                }
            } else {
                header("Location:admin_service_dashboard.php?msg=fail");
            }
        } else {
            header("location: index.php?msg=Invalid Credentials");
        }
    }

    // issue book 
    function issuebook($book, $userselect, $returnDate)
    {
        $this->$book = $book;
        $this->$userselect = $userselect;
        // $this->$days = $days;
        // $this->$getdate = $getdate;
        // $this->$returnDate = $returnDate;


        $q = "SELECT * FROM book where bookname='$book'";
        $recordSetss = $this->connection->query($q);

        $q = "SELECT * FROM userdata where name='$userselect'";
        $recordSet = $this->connection->query($q);
        $result = $recordSet->rowCount();

        if ($result > 0) {

            foreach ($recordSet->fetchAll() as $row) {
                $issueid = $row['id'];
                // $issuetype = $row['type'];

                // header("location: admin_service_dashboard.php?logid=$logid");
            }
            foreach ($recordSetss->fetchAll() as $row) {
                $bookid = $row['id'];
                $bookname = $row['bookname'];

                $newbookava = $row['bookava'] - 1;
                $newbookrent = $row['bookrent'] + 1;
            }


            $q = "UPDATE book SET bookava='$newbookava', bookrent='$newbookrent' where id='$bookid'";
            if ($this->connection->exec($q)) {
                $q = "INSERT INTO issuebook (userid,issuename,issuedbook,returndate)VALUES('$issueid','$userselect','$book','$returnDate')";
                if ($this->connection->exec($q)) {
                    header("Location:admin_service_dashboard.php?msg=done");
                } else {
                    header("Location:admin_service_dashboard.php?msg=fail");
                }
            } else {
                header("Location:admin_service_dashboard.php?msg=fail");
            }
        } else {
            header("location: index.php?msg=Invalid Credentials");
        }
    }
}
