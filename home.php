<?php 
session_start();
$con = mysqli_connect("localhost","root","","rgi_student");
if(!$con){die("Error with database.");}
$sql = "SELECT * FROM student_info";
$query = mysqli_query($con,$sql);
if(mysqli_num_rows($query)>0){
while($row = mysqli_fetch_assoc($query)){
echo "<h2 align='center'>STUDENT FEES<br></h2>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "
<table align='center' border='2px solid black' cellpadding='5'>
 <tr>
 <th>StudentID</th>
 <th>Student name</th>
 <th>Balance</th>
 <th>Due date</th>
 </tr>
 <tr>
 <th>20{$_SESSION['id']}</th>
 <th>{$_SESSION['username']}</th>
 <th>R{$row['STD_BALANCE']}</th>
 <th>{$row['DUE_DATE']}</th>
 </tr>
 <tr>
 <td colspan='3'></td>
 <td><input type='submit' name='return' value='RETURN'></td>
 </tr>
</table>
";
}}
else { echo "No Results";}
if (isset($_POST['return'])){
header("location:home.php");
}
?>