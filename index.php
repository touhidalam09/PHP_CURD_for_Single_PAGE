<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_info";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
//    echo "Connection Successfully";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PHP CURD Single</title>

        <!--BOOTSTRAP LINK--> 
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1 class="bg-secondary text-white py-3 text-center">
            Single Page CURD
        </h1>

        <?php
        //INSERT dATA START
        $studentId = $studentName = $department = $email = "";
        if (isset($_POST["submit"])) {

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $studentId = test_input($_POST["studentid"]);
                $studentName = test_input($_POST["studentname"]);
                $department = test_input($_POST["department"]);
                $email = test_input($_POST["email"]);
            }
            $sqlinsertData = "INSERT INTO student_info (StudentID, StudentName, Department, Email) VALUES('$studentId', '$studentName', '$department', '$email')";

            if ($conn->query($sqlinsertData) === TRUE) {
                //success message
            } else {
                echo "Error: " . $sqlinsertData . "<br>" . $conn->error;
                exit();
            }
            header("location:index.php");
        }

//        INSERT DATA END
//        DELETE DATA START
        if (isset($_GET["delete_btn_id"])) {

            $id = $_GET['delete_btn_id'];
            $sql = "DELETE FROM student_info WHERE Id='$id'";

            if ($conn->query($sql) === TRUE) {
                
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                exit();
            }
        }

//        DELETE DATA END
//        UPDATE DATA START
        $studentId = $studentName = $department = $email = "";
        if (isset($_POST["update_submit_btn"])) {
            $id = $_POST["id"];

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $studentId = test_input($_POST["studentid"]);
                $studentName = test_input($_POST["studentname"]);
                $department = test_input($_POST["department"]);
                $email = test_input($_POST["email"]);
            }

            $sql = "UPDATE student_info SET StudentID = '$studentId', StudentName = '$studentName', Department = '$department', Email = '$email' WHERE Id = '$id'";

            if ($conn->query($sql) === TRUE) {
                //success message
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                exit();
            }
        }

//        UPDATE DATA END

        function selectSection($select = 0) {
            global $conn;
            switch ($select) {
                case 0:
                    ?>
                    <!--Table VIEW START-->
                    <section class="btn-section py-3">
                        <div class="container">
                            <div class="d-flex justify-content-end">
                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div>
                                        <button type="submit" name="addNewItem" class="btn btn-success text-white">
                                            Add New Item
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>   
                    <section class="table-section">
                        <div class="container">

                            <div>
                                <table class = "table table-hover table-striped text-center">
                                    <thead class = "bg-dark text-white">
                                        <tr>
                                            <th scope = "col">#</th>
                                            <th scope = "col">Student Id</th>
                                            <th scope = "col">Student Name</th>
                                            <th scope = "col">Department</th>
                                            <th scope = "col">Email</th>
                                            <th scope = "col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                            SELECT DISPLAY START 
                                        $sqlShowData = "SELECT * FROM student_info";
                                        $result = $conn->query($sqlShowData);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <th scope = "row"> <?php echo $row["Id"] ?></th>
                                                    <td> <?php echo $row["StudentID"] ?> </td>
                                                    <td> <?php echo $row["StudentName"] ?> </td>
                                                    <td> <?php echo $row["Department"] ?> </td>
                                                    <td> <?php echo $row["Email"] ?> </td>
                                                    <td>
                                                        <form method="GET" action="<?php $_SERVER["PHP_SELF"]; ?>">
                                                            <button type="submit" name="delete_btn" class = "btn bg-danger text-white">
                                                                <a href = "index.php?delete_btn_id=<?php echo $row["Id"]; ?>" class = "text-white text-decoration-none">
                                                                    DELETE
                                                                </a>
                                                            </button>
                                                            <button type = "submit" name="update_submit" id="<?php echo $row["Id"] ?>" class = " btn bg-info text-white">
                                                                <a href = "index.php?update_btn_id=<?php echo $row["Id"]; ?>&email=<?php echo $row["Email"] ?>" class = "text-white text-decoration-none">
                                                                    UPDATE
                                                                </a>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
//                            SELECT DISPLAY END 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    <!--Table VIEW END -->

                    <?php
                    break;
                case 1:
                    ?>
                    <section class="insert-form-secton" id="insertSection">
                        <div class="container">
                            <div class="d-flex justify-content-center">
                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="form-group row">
                                        <label for="firstName" class="col-lg-5 col-form-label text-end">Student ID : </label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" id="firstName" name="studentid" placeholder="Student Id" autocomplete="off" required="*">
                                        </div>
                                    </div>
                                    <div class="form-group row pt-3">
                                        <label for="lastName" class="col-lg-5 col-form-label text-end">Student Name:</label>
                                        <div class="col-lg-7">
                                            <input type="type" class="form-control" id="lastName" name="studentname" autocomplete="off" placeholder="Student Name">
                                        </div>
                                    </div>
                                    <div class="form-group row pt-3">
                                        <label for="lastName" class="col-lg-5 col-form-label text-end">Department:</label>
                                        <div class="col-lg-7">
                                            <input type="type" class="form-control" id="lastName" name="department" autocomplete="off" placeholder="your department">
                                        </div>
                                    </div>
                                    <div class="form-group row py-3">
                                        <label for="email" class="col-lg-5 col-form-label text-end">Email:</label>
                                        <div class="col-lg-7">
                                            <input type="email" class="form-control" id="email" name="email" autocomplete="off" placeholder="email" required="*">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="text-center ml-2">
                                            <button type="submit" name="submit" class="btn btn-success my-submit-btn">submit</button>
                                        </div>
                                        <div class="px-2">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="cancel_btn" class="btn btn-danger my-submit-btn">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                    <?php
                    break;
                case 2:
                    ?>
                    <div class = "alert alert-danger" role = "alert">
                        Delete One Item !!
                    </div>
                    <?php
                    break;
                case 3:
                    ?>
                    <section class="insert-form-secton" id="insertSection">
                        <div class="container">
                            <div class="d-flex justify-content-center">
                                <?php
                                $id = $_GET['update_btn_id'];
                                $sqlFindRow = "SELECT * FROM student_info WHERE id = '$id'";

                                $result = $conn->query($sqlFindRow);

                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                            <input type="hidden" id="id" name="id" value="<?php echo $row["Id"] ?>" />
                                            <div class="form-group row">
                                                <label for="firstName" class="col-lg-5 col-form-label text-end">Student ID : </label>
                                                <div class="col-lg-7">
                                                    <input 
                                                        type="text" 
                                                        class="form-control" 
                                                        id="firstName" 
                                                        name="studentid" 
                                                        value="<?php echo $row["StudentID"] ?>"
                                                        autocomplete="off" 
                                                        required="*"
                                                        >
                                                </div>
                                            </div>
                                            <div class="form-group row pt-3">
                                                <label for="lastName" class="col-lg-5 col-form-label text-end">Student Name:</label>
                                                <div class="col-lg-7">
                                                    <input 
                                                        type="type"
                                                        class="form-control"
                                                        id="lastName"
                                                        name="studentname"
                                                        autocomplete="off"
                                                        value="<?php echo $row["StudentName"] ?>"
                                                        >
                                                </div>
                                            </div>
                                            <div class="form-group row pt-3">
                                                <label for="lastName" class="col-lg-5 col-form-label text-end">Department:</label>
                                                <div class="col-lg-7">
                                                    <input 
                                                        type="type"
                                                        class="form-control"
                                                        id="lastName"
                                                        name="department"
                                                        autocomplete="off"
                                                        value="<?php echo $row["Department"] ?>"
                                                        >
                                                </div>
                                            </div>
                                            <div class="form-group row py-3">
                                                <label for="email" class="col-lg-5 col-form-label text-end">Email:</label>
                                                <div class="col-lg-7">
                                                    <input 
                                                        type="email"
                                                        class="form-control"
                                                        id="email"
                                                        name="email"
                                                        autocomplete="off"
                                                        value="<?php echo $row["Email"] ?>"
                                                        required="*">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <div class="text-center ml-2">
                                                    <button type="submit" name="update_submit_btn" class="btn btn-success my-submit-btn">Update</button>
                                                </div>
                                                <div class="px-2">
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" name="cancel_btn" class="btn btn-danger my-submit-btn">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </section>
                <?php
                default :
                    break;
            }
        }

        //view control
        if (isset($_POST["addNewItem"])) {
            selectSection(1); //Insert Form
        } else if (isset($_POST["submit"])) {
            selectSection(0); //Insert Form to Table Display
        } else if (isset($_POST["cancel_btn"])) {
            header("location:index.php"); //Insert Form to Table Display [No data entry in DataBase]
        } else if (isset($_GET["delete_btn_id"])) {
            $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
            if ($pageWasRefreshed) {
                //do something because page was refreshed;
                selectSection(0);
            } else {
                //do nothing;
                selectSection(2);
                selectSection(0);
            }
        } else if (isset($_GET["update_btn_id"])) {
//             echo '<pre>' . print_r( $_GET,1 ) . '</pre>';
//            echo $_GET["update_btn_id"];
//            echo $_GET["email"];
//            exit;
            selectSection(3); //Table Display to Update Form
        } else {
            selectSection(0); //Table Show
        }

        $conn->close();
        ?>

        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/popper.min.js"></script>
    </body>
</html>

