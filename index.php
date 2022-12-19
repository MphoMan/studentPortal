<?php 
$con = mysqli_connect("localhost","root","","rgi_student");
if(!$con){
    die("Error occured" .mysqli_connect_error());
}

if(isset($_POST['register'])){

$password = mysqli_real_escape_string($con,$_POST["password"]);
$cpassword = mysqli_real_escape_string($con,$_POST["cpassword"]);
$username = mysqli_real_escape_string($con,$_POST["username"]);
$firstname = mysqli_real_escape_string($con,$_POST["firstname"]);
$surname = mysqli_real_escape_string($con,$_POST["surname"]);
$email = mysqli_real_escape_string($con,$_POST["email"]);
$qualification = $_POST["qualification"];
$cellphone = mysqli_real_escape_string($con,$_POST["cellphone"]);
$gender = $_POST["gender"];
$nationality = $_POST["nationality"];
$check_username = "SELECT * FROM student_reg WHERE username='$username'";
$result= mysqli_query($con,$check_username);

if(empty($username) || empty($password) || empty($cpassword) || empty($firstname) || 
    empty($surname) || empty($email) || empty($cellphone)){
    echo '<script>alert("All fields are required.");</script>';
} 
else if($password !== $cpassword){
    echo '<script>alert("Your password do not match.");</script>';
}
else if(mysqli_num_rows($result)!==0){
    echo '<script>alert("The username is already exist.");</script>';
}
else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo '<script>alert("Invalid email address.");</script>';
} 
else {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO student_reg 
    (username,password,firstname,surname,email,qualification,cellphone,gender, nationality) 
    VALUES('$username', '$password', '$firstname', '$surname', '$email', '$qualification', 
    '$cellphone', '$gender', '$nationality')";
    $query = mysqli_query($con, $sql);
        if($query) {
            echo '<script>alert("{$firstname} registration submitted successfully");</script>';
            header("location:login.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>registration Page</title>
<style type="text/css" src="first.css">
h1 {
text-align: center;
text-transform: uppercase;
}
label {text-transform: uppercase;}
.lightblue {background-color: lightblue;}
input {cursor: pointer;}
</style>
</head>
<body>
 <h1>registration</h1>
<form method="post">
<table align="center">
 <tr>
<td><label>username:</label></td><td> <input type="text" name="username" 
class="lightblue"></td>
</tr>
 <tr>
<td><label>password:</label></td><td> <input type="password" name="password" 
maxlength="10"></td>
</tr>
<tr>
<td><label>confirm password:</label></td><td> <input type="password" 
name="cpassword" maxlength="10"></td>
</tr>
<tr>
<td><label>firstname:</label></td><td> <input type="text" name="firstname" 
class="lightblue"></td>
</tr>
<tr>
<td><label>surname:</label></td><td> <input type="text" name="surname"></td>
</tr>
<tr>
<td><label>email:</label></td><td> <input type="email" name="email" 
class="lightblue" >
</td>
</tr>
<tr>
<td><label>qualification</label>
</td>
<td> 
 <select name="qualification">
 <option value="BSc">BSc IT</option>
<option value="Dpl">Dpl IT</option>
<option value="HIC" >HIC IT</option>
 </select>
</td>
</tr>
<tr>
<td><label>cell number:</label></td><td> 
<input type="text" name="cellphone" maxlength="10"></td>
</tr>
<tr>
<td><label>gender</label></td><td> 
<input type="radio" name="gender" value="Male" checked="" 
><label>male</label>
 <input type="radio" name="gender" value="Female"><label>female</label></td>
 </tr>
 <tr>
<td><label>nationality</label>
</td>
<td> 
<select name="nationality">
 <option value ="SOUTH AFRICAN">SOUTH AFRICAN</option>
 <option value ="ZIMBABWEAN">ZIMBABWEAN</option>
 <option value ="MALAWIAN">MALAWIAN</option>
 <option value ="ZAMBIAN">ZAMBIAN</option>
 <option>NIGERIAN</option>
</select>
</td>
</tr>
<tr>
<td>
<button type="reset" name="clear">CLEAR</button>
</td> 
<td> 
 <button type="submit" name="register">REGISTER</button></td>
 </tr>
 <tr>
    <td><a href="login.php">LogIn</a></td>
 </tr>
</table>
</form>
</body>
</html>