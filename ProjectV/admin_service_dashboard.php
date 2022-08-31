<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>


<body>

    <?php
    include("data_class.php");

    $msg = "";

    if (!empty($_REQUEST['msg'])) {
        $msg = $_REQUEST['msg'];
    }

    if ($msg == "done") {
        echo "<div class='alert alert-success' role='alert'>Sucssefully Done</div>";
    } elseif ($msg == "fail") {
        echo "<div class='alert alert-danger' role='alert'>Fail</div>";
    }

    ?>



    <div class="container">
        <div class="innerdiv">
            <div class="row"><img class="imglogo" src="images/logo.png" /></div>

            <!-- Left Menu -->
            <div class="leftinnerdiv">
                <Button class="greenbtn"> ADMIN</Button>
                <Button class="greenbtn" onclick="openpart('addbook')">ADD BOOK</Button>
                <Button class="greenbtn" onclick="openpart('bookreport')"> BOOK RECORD</Button>
                <Button class="greenbtn" onclick="openpart('bookrequestapprove')"> BOOK REQUESTS</Button>
                <Button class="greenbtn" onclick="openpart('addperson')"> ADD STUDENT</Button>
                <Button class="greenbtn" onclick="openpart('studentrecord')"> STUDENT RECORD</Button>
                <Button class="greenbtn" onclick="openpart('issuebook')"> ISSUE BOOK</Button>
                <Button class="greenbtn" onclick="openpart('issuebookreport')"> ISSUE REPORT</Button>
                <a href="index.php"><Button class="greenbtn"> LOGOUT</Button></a>
            </div>

            <!--Book Requests Approve  -->
            <div class="rightinnerdiv">
                <div id="bookrequestapprove" class="innerright portion" style="display:none">
                    <Button class="greenbtn">BOOK REQUEST APPROVE</Button>

                    <?php
                    $u = new data;
                    $u->setconnection();
                    $u->requestbookdata();
                    $recordset = $u->requestbookdata();

                    $table = "<table style='font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;'><tr><th style='  border: 1px solid #ddd;
            padding: 8px;'>Requested By</th><th>Book Name</th><th>Approve</th><th>Delete</th></tr>";
                    foreach ($recordset as $row) {
                        $table .= "<tr>";
                        // "<td>$row[0]</td>";
                        // "<td>$row[1]</td>";
                        // "<td>$row[2]</td>";

                        $table .= "<td>$row[1]</td>";
                        $table .= "<td>$row[3]</td>";

                        $table .= "<td><a href='approvebookrequest.php?reqid=$row[0]&userselect=$row[1]&book=$row[3]&days=$row[4]'><button type='button' class='btn btn-primary fa fa-check'></button></a></td>";
                        $table .= "<td><a href='deletebook_request.php?deletebookreqid=$row[0]'><button type='button' class='btn btn-danger fa fa-trash'></button></a></td>";
                        $table .= "</tr>";
                    }
                    $table .= "</table>";

                    echo $table;
                    ?>

                </div>
            </div>

            <!-- Add New Book  -->
            <div class="rightinnerdiv">
                <div id="addbook" class="innerright portion" style="<?php if (!empty($_REQUEST['viewid'])) {
                                                                        echo "display:none";
                                                                    } else {
                                                                        echo "";
                                                                    } ?>">
                    <Button class="greenbtn">ADD NEW BOOK</Button>
                    <form action="addbookserver_page.php" method="post" enctype="multipart/form-data">
                        <label>Book Name:</label>
                        <input type="text" name="bookname" />
                        </br>
                        <label>Detail:</label><input type="text" name="bookdetail" /></br>
                        <label>Autor:</label><input type="text" name="bookaudor" /></br>
                        <label>Publication</label><input type="text" name="bookpub" /></br>
                        <div>Branch:<input type="radio" name="branch" value="other" />other<input type="radio" name="branch" value="BSIT" />BSIT<div style="margin-left:80px"><input type="radio" name="branch" value="BSCS" />BSCS<input type="radio" name="branch" value="BSSE" />BSSE</div>
                        </div>
                        <label>Price:</label><input type="number" name="bookprice" /></br>
                        <label>Quantity:</label><input type="number" name="bookquantity" /></br>
                        <label>Book Photo</label><input type="file" name="bookphoto" /></br>
                        </br>

                        <input type="submit" value="SUBMIT" class="greenbtn" />
                        </br>
                        </br>

                    </form>
                </div>
            </div>


            <!-- Add New Student -->

            <div class="rightinnerdiv">
                <div id="addperson" class="innerright portion" style="display:none">
                    <Button class="greenbtn">ADD Person</Button>
                    <form action="addpersonserver_page.php" method="post" enctype="multipart/form-data">
                        <label>Name:</label><input type="text" name="addname" />
                        </br>
                        <label>Pasword:</label><input type="password" name="addpass" />

                        </br>
                        <label>Email:</label><input type="email" name="addemail" /></br>
                        <label for="typw">Choose type:</label>
                        <select name="type">
                            <option value="student">student</option>
                            <option value="teacher">teacher</option>
                        </select>

                        <input type="submit" value="SUBMIT" class="greenbtn" />
                    </form>
                </div>
            </div>


            <!-- Student List -->
            <div class="rightinnerdiv">
                <div id="studentrecord" class="innerright portion" style="display:none">
                    <Button class="greenbtn">Student RECORD</Button>

                    <?php
                    $u = new data;
                    $u->setconnection();
                    $u->userdata();
                    $recordset = $u->userdata();

                    $table = "<table style='font-family: Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;'><tr><th style='  border: 1px solid #ddd;
            padding: 8px;'> Name</th><th>Email</th><th>Type</th><th>Delete</th></tr>";
                    foreach ($recordset as $row) {
                        $table .= "<tr>";
                        "<td>$row[0]</td>";
                        $table .= "<td>$row[1]</td>";
                        $table .= "<td>$row[2]</td>";
                        $table .= "<td>$row[4]</td>";
                        $table .= "<td><a href='deleteuser.php?useriddelete=$row[0]'><button class='btn btn-danger fa fa-trash'></button></a></td>";
                        $table .= "</tr>";
                        // $table.=$row[0];
                    }
                    $table .= "</table>";

                    echo $table;
                    ?>

                </div>
            </div>

            <!-- Issue Book Record -->
            <div class="rightinnerdiv">
                <div id="issuebookreport" class="innerright portion" style="display:none">
                    <Button class="greenbtn">Issue Book Record</Button>

                    <?php
                    $u = new data;
                    $u->setconnection();
                    $u->issuereport();
                    $recordset = $u->issuereport();

                    $table = "<table style='border-collapse: collapse;width: 100%;'><tr><th style='  border: 1px solid #ddd;
            padding: 8px;'>Student Name</th><th>Book Name</th></th><th>Issue Date</th><th>Return Date</th><th>Return</th></tr>";

                    foreach ($recordset as $row) {
                        $table .= "<tr>";
                        "<td>$row[0]</td>";
                        $table .= "<td>$row[2]</td>";
                        $table .= "<td>$row[3]</td>";
                        // $table .= "<td>$row[6]</td>";
                        // $table .= "<td>$row[7]</td>";
                        // $table .= "<td>$row[8]</td>";
                        $table .= "<td>$row[4]</td>";
                        $table .= "<td>$row[5]</td>";
                        $table .= "<td><a href='returnbookserver_page.php?returnbook=$row[0]'><button class='btn btn-primary fa fa-undo'></button></a></td>";
                        $table .= "</tr>";
                        // $table.=$row[0];
                    }
                    $table .= "</table>";

                    echo $table;
                    ?>

                </div>
            </div>

            <!-- Issue New Book -->
            <div class="rightinnerdiv">
                <div id="issuebook" class="innerright portion" style="display:none">
                    <Button class="greenbtn">ISSUE BOOK</Button>
                    <form action="issuebook_server.php" method="post" enctype="multipart/form-data">
                        <label for="book">Choose Book:</label>
                        <select name="book">
                            <?php
                            $u = new data;
                            $u->setconnection();
                            $u->getbookissue();
                            $recordset = $u->getbookissue();
                            foreach ($recordset as $row) {

                                echo "<option value='" . $row[2] . "'>" . $row[2] . "</option>";
                            }
                            ?>
                        </select>

                        <label for="Select Student">:</label>
                        <select name="userselect">
                            <?php
                            $u = new data;
                            $u->setconnection();
                            $u->userdata();
                            $recordset = $u->userdata();
                            foreach ($recordset as $row) {
                                $id = $row[0];
                                echo "<option value='" . $row[1] . "'>" . $row[1] . "</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <label for="returndate">Return Date:</label>
                        <input type="date" name="returndate">

                        <input type="submit" value="SUBMIT" />
                    </form>
                </div>
            </div>

            <!-- Book Detail Page -->

            <div class="rightinnerdiv">
                <div id="bookdetail" class="innerright portion" style="<?php if (!empty($_REQUEST['viewid'])) {
                                                                            $viewid = $_REQUEST['viewid'];
                                                                        } else {
                                                                            echo "display:none";
                                                                        } ?>">

                    <Button class="greenbtn">BOOK DETAIL</Button>
                    </br>
                    <?php
                    $u = new data;
                    $u->setconnection();
                    $u->getbookdetail($viewid);
                    $recordset = $u->getbookdetail($viewid);
                    foreach ($recordset as $row) {

                        $bookid = $row[0];
                        $bookimg = $row[1];
                        $bookname = $row[2];
                        $bookdetail = $row[3];
                        $bookauthour = $row[4];
                        $bookpub = $row[5];
                        $branch = $row[6];
                        $bookprice = $row[7];
                        $bookquantity = $row[8];
                        $bookava = $row[9];
                        $bookrent = $row[10];
                    }
                    ?>

                    <div class="bookdetails">
                        <div class="book-img">
                            <img width='200px' style='border:1px solid #333333; float:left;margin-left:20px' src="uploads/<?php echo $bookimg ?> " />
                        </div>

                        <div class="book-details">

                            <p style="color:black"><u>Book Name:</u> &nbsp&nbsp<?php echo $bookname ?></p>
                            <p style="color:black"><u>Book Detail:</u> &nbsp&nbsp<?php echo $bookdetail ?></p>
                            <p style="color:black"><u>Book Authour:</u> &nbsp&nbsp<?php echo $bookauthour ?></p>
                            <p style="color:black"><u>Book Publisher:</u> &nbsp&nbsp<?php echo $bookpub ?></p>
                            <p style="color:black"><u>Book Branch:</u> &nbsp&nbsp<?php echo $branch ?></p>
                            <p style="color:black"><u>Book Price:</u> &nbsp&nbsp<?php echo $bookprice ?></p>
                            <p style="color:black"><u>Book Available:</u> &nbsp&nbsp<?php echo $bookava ?></p>
                            <p style="color:black"><u>Book Rent:</u> &nbsp&nbsp<?php echo $bookrent ?></p>
                        </div>
                    </div>

                </div>
            </div>


            <!-- Book List Page -->

            <div class="rightinnerdiv">
                <div id="bookreport" class="innerright portion" style="display:none">
                    <Button class="greenbtn">BOOK RECORD</Button>
                    <?php
                    $u = new data;
                    $u->setconnection();
                    $u->getbook();
                    $recordset = $u->getbook();

                    $table = "<table style='border-collapse: collapse;width: 100%;'><tr><th style='  border: 1px solid #ddd;
            padding: 8px;'>Book Name</th><th>Price</th><th>Qnt</th><th>Available</th><th>Rent</th><th>View</th><th>Delete</th></tr>";
                    foreach ($recordset as $row) {
                        $table .= "<tr>";

                        $table .= "<td>$row[2]</td>";
                        $table .= "<td>$row[7]</td>";
                        $table .= "<td>$row[8]</td>";
                        $table .= "<td>$row[9]</td>";
                        $table .= "<td>$row[10]</td>";
                        $table .= "<td><a href='admin_service_dashboard.php?viewid=$row[0]'><button type='button' class='btn btn-primary'><i class='fa fa-eye'></i></button></a></td>";
                        // $table .= "<td><a href='deletebook_dashboard.php?deletebookid=$row[0]'><button type='button' class='btn btn-primary'><i class='fa fa-pencil'></i></button></a></td>";
                        $table .= "<td><a href='deletebook_dashboard.php?deletebookid=$row[0]'><button type='button' class='btn btn-danger'><i class='fa fa-trash'></i></button></a></td>";
                        $table .= "</tr>";
                        // $table.=$row[0];
                    }
                    $table .= "</table>";

                    echo $table;
                    ?>

                </div>
            </div>



        </div>
    </div>



    <script>
        // Bootstrap Date Picker Call
        $('.datepicker').datepicker();

        function openpart(portion) {
            var i;
            var x = document.getElementsByClassName("portion");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(portion).style.display = "block";
        }
    </script>
</body>

</html>