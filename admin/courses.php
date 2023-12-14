<?php
if(!isset($_SESSION)){
    session_start();
 }
 
 include('./admininclude/header.php');
 include('../dbconnection.php');
 
// security of page
 if(isset($_SESSION['is_admin_login'])){
    $adminEmail = $_SESSION['adminLogEmail'];
 }else{
    echo "<script> location.href='../index.php'; </script>";
 }
?>

<div class="col-sm-12 mt-5 text-center">
    <!-- Table -->
    <p class="bg-dark text-white p-2 radius-5" style=" border-radius: 10px;">List of Courses</p>
    <?php 
    $sql = "SELECT * FROM course";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
    ?>
    <table class="table text-light">
        <thead>
            <tr>
                <th scope="col">Course ID</th>
                <th scope="col">Name</th>
                <th scope="col">Author</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
           <?php while($row = $result->fetch_assoc()){
           echo '<tr>';
            echo '<th scope="row">'.$row['course_id'].'</th>';
            echo '<td>'.$row['course_name'].'</td>';
            echo '<td>'.$row['course_author'].'</td>';
            echo '<td>'.$row['status'].'</td>';
            echo '<td>';
            echo '
                <form action="editcourse.php" method="POST" class="d-inline">
                <input type="hidden" name="id" value='.$row["course_id"].'>
                <button
                    type="Submit"
                    class="btn btn-info mar-3"
                    name="view"
                    value="View">
                <i class="fas fa-pen"></i></button>
                </form>

                <form action="" method="POST" class="d-inline">
                <input type="hidden" name="id" value='.$row["course_id"].'>
                <button type="submit" class="btn btn-danger" name="delete" value="Delete">
                    <i class="fas fa-trash"></i>
                </button>
                </form>

                <form action="" method="POST" class="d-inline">
                <input type="hidden" name="id" value='.$row["course_id"].'>
                    <button
                    type="submit"
                    class="btn btn-success"
                    name="approve"
                    value="Approve">
                <i class="fas fa-check"></i></button>
                </form>

                <form action="" method="POST" class="d-inline">
                <input type="hidden" name="id" value='.$row["course_id"].'>
                    <button
                    type="submit"
                    class="btn btn-danger"
                    name="deny"
                    value="Deny">
                <i class="fas fa-times"></i></button>
                </form>

            </td>
            </tr>';
            } ?>
        </tbody>
    </table>
<?php } else {
    echo "0 result";
}

if(isset($_REQUEST['approve'])){
    $sql = "UPDATE course SET status=1 WHERE course_id = {$_REQUEST['id']}";
    if($conn->query($sql) == TRUE){
        echo '<meta http-equiv="refresh" content="0;URL=?approved" />';
    } else {
        echo "Unable to update the data";
    }
}
if(isset($_REQUEST['deny'])){
    $sql = "UPDATE course SET status=0 WHERE course_id = {$_REQUEST['id']}";
    if($conn->query($sql) == TRUE){
        echo '<meta http-equiv="refresh" content="0;URL=?denied" />';
    } else {
        echo "Unable to update the data";
    }
}

if(isset($_REQUEST['delete'])){
    $sql = "DELETE FROM course WHERE course_id = {$_REQUEST['id']}";
    if($conn->query($sql) == TRUE){
        echo '<meta http-equiv="refresh" content="0;URL=?deleted" />';
    } else {
        echo "Unable to delete the data";
    }
}



 ?>
</div>
</div>

<!-- Div Row Close from Header -->
<div>
    <a class="btn btn-danger box" href="./addcourse.php"><i class="fas fa-plus fa-2x"></i></a>
    
</div>
</div>
<!-- DIv Container-fluid close form header -->
<?php 
include('./admininclude/footer.php');
?>