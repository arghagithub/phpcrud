<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <title>PHP Crud operation</title>
</head>

<body>
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
        Launch demo modal
    </button> -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit your note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="my-2" action="/CRUD/index.php/" method="POST">
                        <input type="hidden" name="snoedit" id="snoedit">
                        <div class="mb-3">
                            <label for="title" class="form-label">title </label>
                            <input type="text" class="form-control" id="etitle" name="etitle" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">description </label>
                            <textarea class="form-control" id="edescription" name="edescription" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update note</button>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img style="height: 30px;" src="/CRUD/phplogo.png" alt="..."></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/CRUD/index.php">iNotes App</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php

    $servername='localhost';
    $username='root';
    $password='';
    $dbname='crud';
    $insert=false;
    $update=false;
    $delete=false;

    $conn=mysqli_connect($servername,$username,$password,$dbname);
    if(!$conn){
        die("Sorry, don't connect to mysql");
    }

    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['snoedit'])){
            // echo "yes <br>";
            // exit();
            $snoedit= $_POST['snoedit'];
            $etitle=$_POST['etitle'];
            $edescription=$_POST['edescription'];

            $sql="UPDATE `notes` SET `title`='$etitle',`description` = '$edescription' WHERE `notes`.`sno` = $snoedit;";

            $result= mysqli_query($conn,$sql);

            if($result){
                $update=true;
            }
            else{
                echo '<div class="alert text-center alert-danger alert-dismissible fade show" role="alert">
                <strong>Error : </strong> Sorry, something went wrong 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        }
        else{
            $title=$_POST['title'];
            $description=$_POST['description'];
    
            $sql="INSERT INTO `notes` ( `title`, `description`) VALUES ('$title', '$description');";
    
            $result=mysqli_query($conn,$sql);
            if($result){
                $insert=true;
            }
        }
    }
    if(isset($_GET['delete'])){
        $sno=$_GET['delete'];

        $sql="DELETE FROM `notes` WHERE `notes`.`sno` = $sno";

        $result= mysqli_query($conn,$sql);

        if($result){
            $delete=true;
        }
    }
?>
    <?php
    if($insert){
        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">
        <strong>Success: </strong> Note is inserted successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if($update){
        echo '<div class="alert text-center alert-success alert-dismissible fade show" role="alert">
                <strong>Success : </strong> Note is updated successfully 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
    if($delete){
        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">
        <strong>Success: </strong> Note is deleted successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <div class="container my-3">
        <h2 class="">Add a note</h2>
        <form class="my-2" action="/CRUD/index.php" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">title </label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="form-group mb-3">
                <label for="title" class="form-label">description </label>
                <textarea class="form-control" placeholder="" id="description" name="description" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add note</button>
        </form>
    </div>
    <div class="container my-2">
        <h3 class="my-4">My notes</h3>
        <table id="mytable" class="table my-2">
            <thead>
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                            $sql="SELECT * FROM `notes`";
                
                            $result= mysqli_query($conn,$sql);

                            $num=1;
                
                            while($row=mysqli_fetch_assoc($result)){

                                echo "<tr>
                                <th>".$num."</th>
                                <td id='eletitle'>".$row['title']."</td>
                                <td id='eledesc'>".$row['description']."</td>
                                <td>
                                    <button type='button' id=".$row['sno']." class='btn btn-danger delete'>Delete</button>
                                    <button type='button' id=e".$row['sno']." class='btn btn-warning edit'>Edit</button>
                                </td>
                            </tr>";

                            $num+=1;
                            }
                ?>
            </tbody>
        </table>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
    crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#mytable').DataTable();
    })
</script>

<script>
    const edit= document.getElementsByClassName('edit');
    Array.from(edit).forEach((element)=>{
        element.addEventListener('click',(e)=>{
            // let sno=e.target.parentNode.parentNode.getElementsByTagName('th')[0].innerText;
            let sno=e.target.id.substr(1);
            let title=e.target.parentNode.parentNode.getElementsByTagName('td')[0].innerText;
            let description=e.target.parentNode.parentNode.getElementsByTagName('td')[1].innerText;
            document.getElementById('etitle').value=title;
            document.getElementById('edescription').value=description;
            document.getElementById('snoedit').value=sno;
            $('#editModal').modal('toggle');
        })
    })

    const del=document.getElementsByClassName('delete');
    Array.from(del).forEach((element)=>{
        element.addEventListener('click',(e)=>{
            // let sno=e.target.parentNode.parentNode.getElementsByTagName('th')[0].innerText;
            let sno= e.target.id;
            if(confirm("Do you want to delete the note ?")){
                console.log('yes',sno);
                window.location=`/CRUD/index.php/?delete=${sno}`;
            }
            else{
                console.log('no');
            }
        })
    })

</script>


</html>