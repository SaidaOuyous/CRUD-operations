<?php
require("connexion.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <title>Product store</title>
    <style>
        .error {
            background-color: #FF8C8C;
            color: #F32424;
            padding: 10px 30px;
            font-size: 20px;
            margin-bottom: 30px;
            text-align: center;
            width: 50%;
            border: 1px solid #F32424;
        }
    </style>
</head>

<body class="bg_light">

    <!------header------>
    <div class="container  p-3 mt-5">
        <div class="d-flex justify-content-between">
            <h1><a class="text-dark text-decoration-none" href="index.php"><i class="bi bi-bag-heart-fill " style="color: #FCC822;"></i> Products </a></h1>
            <!-- Button trigger modal -->
            <div class="d-grid gap-2 col-2 ">
                <button type="button" style="background-color: #FCC822;font-size:20px; border-color:#FCC822 ;" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#addproduct">
                    Add Product </button>
            </div>
        </div>
        <hr class="hr" />
    </div>

    <div class="container my-5 ">
        <!--- show error --->
        <?php
        if (isset($_GET['error'])) {
            $errorMessages = explode(",", $_GET['error']);
            echo '<div class="error"><i class="bi bi-exclamation-triangle"></i>';
            foreach ($errorMessages as $errorMessage) {
                echo '<div>' . $errorMessage . '</div>';
            }
            echo '</div>';
        }
        ?>



        <!-----list of products----->
        <table class="table table-hover text-center ">
            <thead class=" text-white " style="background-color: #383838;">
                <tr>
                    <th width="10%" scope="col" class=" rounded-start">Product</th>
                    <th width="30%" scope="col">Name</th>
                    <th width="10%" scope="col">Price</th>
                    <th width="40%" scope="col">Description</th>
                    <th width="10%" scope="col" class="rounded-end">Action</th>

                </tr>
            </thead>
            <tbody>
                <!----display table contents --->
                <?php
                $query = "SELECT * FROM products";
                $result = mysqli_query($con, $query);
                while ($fetch = mysqli_fetch_assoc($result)) {
                    echo '<tr style="background-color: #F6FBF4;  ">';
                    echo '<th scope="row"  style="vertical-align: middle;"  class="rounded-start">' . $fetch["id"] . '</th>';
                    echo '<td   style="vertical-align: middle;" class="px-4 "  >' . $fetch["name"] . '</td>';
                    echo '<td  style="vertical-align: middle;" class="px-4">' . '$' . $fetch["price"] . '</td>';
                    echo '<td  style="vertical-align: middle;"  class="px-4">' . $fetch["description"] . '</td>';
                    echo '<td   style="vertical-align: middle; display:flex flex-direction: row justify-content: space-between ;"class="rounded-end">
                        <a href="?edit=' . $fetch["id"] . '" class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>
                        <button onclick="confirm_rem(' . $fetch["id"] . ')" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                        </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-----remove product----->
    <script>
        function confirm_rem(id) {
            if (confirm("Are you sure you want to delete this item?")) {
                window.location.href = "crud.php?rem=" + id;
            }
        }
    </script>

    <!-- Modal add product -->
    <div class="modal fade" id="addproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="crud.php" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-bag-heart-fill " style="color: #FCC822;"></i> Add New Product</h5>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light text-dark">Name</span>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light text-dark ">Price</span>
                            <input type="text" class="form-control" name="price">


                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light text-dark ">Description</span>
                            <textarea class="form-control" name="desc"></textarea>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-secondary" style="color: #FCC822; border-color : #FCC822 ;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success   " style="background-color: #FCC822; border : #FCC822 ;" name="addproduct">Add</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- Modal edit product -->
    <div class="modal fade" id="editproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="crud.php" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-bag-heart-fill " style="color: #FCC822;"></i> Edit Product</h5>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light text-dark">Name</span>
                            <input type="text" class="form-control" name="name" id="editname">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light text-dark ">Price</span>
                            <input type="text" class="form-control" name="price" id="editprice">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light text-dark ">Description</span>
                            <textarea class="form-control" name="desc" id="editdesc"></textarea>
                        </div>
                        <input type="hidden" name="editpid" id="editpid">
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-outline-secondary" style="color: #FCC822; border-color : #FCC822 ;" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success   " style="background-color: #FCC822; border-color : #FCC822 ;" name="editproduct">Edit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <?php
    // check if edit parameter is present in URL
    if (isset($_GET['edit'])) {

        // query the product details
        $query = "SELECT * FROM products WHERE id='$_GET[edit]'";
        $result = mysqli_query($con, $query);
        $product = mysqli_fetch_assoc($result);

        // display the edit modal
        echo '<script>
        var editproduct = new bootstrap.Modal(document.getElementById("editproduct"), {
            keyboard: false
          }) ;      
            document.querySelector("#editname").value = "' . $product['name'] . '";
            document.querySelector("#editprice").value = "' . $product['price'] . '";
            document.querySelector("#editdesc").value = "' . $product['description'] . '";
            document.querySelector("#editpid").value = "' . $_GET['edit'] . '";
            editproduct.show();
    </script>';
    }
    ?>


</body>

</html>