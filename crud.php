<?php
require("connexion.php");

 //add product
 if (isset($_POST["addproduct"])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['desc'];
    $errorMessages = array();
    // validate name
    if (empty($name)) {
        $errorMessages[] = "Please enter a name for the product";
    }
   
    // validate price
    if (empty($price)) {
        $errorMessages[] = "Please enter a price for the product";
    } elseif (!is_numeric($price)) {
        $errorMessages[] = "Please enter a valid price";
    }
    
    // validate description
    if (empty($desc)) {
        $errorMessages[] = "Please enter a description for the product";
    }
    
    if (count($errorMessages) > 0) {
        // display all error messages
        $errorMessage = implode(", ", $errorMessages);
        header("location: index.php?error=$errorMessage");
        exit();
    } else {
        // insert the product into the database
        $query = "INSERT INTO `products`( `name`, `price`, `description`) VALUES ('$name','$price','$desc')";
        mysqli_query($con, $query);
        header("location: index.php?success=inserted");
    }
}

//delete product
if (isset($_GET['rem'])) {
    $id = $_GET['rem'];
    $query = "DELETE FROM products WHERE id=$id";
    $result = mysqli_query($con, $query);
    header("location: index.php?success=removed");
}

//edit product
if (isset($_POST['editpid'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['desc'];
    $errorMessages = array();

    $query = "SELECT * FROM `products` WHERE id=$_POST[editpid]";
    $res = mysqli_query($con, $query);
    $r = mysqli_fetch_assoc($res);
          // validate name
    if (empty($name)) {
        $errorMessages[] = "Please enter a name for the product";
    }
   
    // validate price
    if (empty($price)) {
        $errorMessages[] = "Please enter a price for the product";
    } elseif (!is_numeric($price)) {
        $errorMessages[] = "Please enter a valid price";
    }
    
    // validate description
    if (empty($desc)) {
        $errorMessages[] = "Please enter a description for the product";
    }
    
    if (count($errorMessages) > 0) {
        // display all error messages
        $errorMessage = implode(", ", $errorMessages);
        header("location: index.php?error=$errorMessage");
        exit();
    } else {

        $UpdateSql = "UPDATE `products` SET `name`='$_POST[name]',`price`='$_POST[price]',`description`='$_POST[desc]' WHERE  id=$_POST[editpid]";
        $res = mysqli_query($con, $UpdateSql);
        header("location: index.php?success=inserted");

        
    }

}
