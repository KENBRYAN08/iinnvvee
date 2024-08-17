<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "it_resource_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//ADD RESOURCE

if (isset($_POST['add_resource'])) {
    $resource_name = $_POST['resource_name'];
    $type = $_POST['type'];
    $specification = $_POST['specification'];
    $status = $_POST['status'];
    $allocated_to = $_POST['allocated_to'];
    $date_allocated = $_POST['date_allocated'];

    $sql = "INSERT INTO resources (resource_name, type, specification, status, allocated_to, date_allocated) VALUES ('$resource_name', '$type','$specification', '$status', '$allocated_to', '$date_allocated')";
    $conn->query($sql);
}

//DELETE RESOURCE

if (isset($_POST['delete_resource'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM resources WHERE id=$id";
    $conn->query($sql);
}

//CLEAR ALL
if (isset($_POST['clear_all'])) {
    echo "<script> 
    if (confirm('Are you sure you want to clear all dat?'))
        {
            window.location.href='admin.php?confirm_clear_all=true';
}
            </script>";
}

if (isset($_GET['confirm_clear_all']) && $_GET['confirm_clear_all'] == 'true') {
    $sql = "DELETE FROM resources";
    $conn->query($sql);
    header('Location: admin.php');
    exit();//exit to prevent further execution after redirect
}


$result = $conn->query("SELECT * FROM resources");

 
?>


<!DOCTYPE html>
<html>
<head>
    <title>IT Resource Management</title>
    <style>
        body{
            font-family:Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #ddd;
        }
    </style>



</head>
<body>


<h3>Add New Resource</h3>

<form action="index.php" method="post">

    <input type="text" name="resource_name" placeholder="Resource Name" required>
    <input type="text" name="type" placeholder="Type" required>
    <input type="text" name="specification" placeholder="Specification" required>
    <input type="text" name="status" placeholder="Status" required>
    <input type="text" name="allocated_to" placeholder="Allocated To">
    <input type="date" name="date_allocated" placeholder="Date Allocated">
    <input type="submit" name="add_resource" value="Add Resource">
</form>

<h3>Current Resources</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Resource Name</th>
        <th>Type</th>
        <th>Specification</th>
        <th>Status</th>
        <th>Allocated To</th>
        <th>Date Allocated</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['resource_name']; ?></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo $row['specification']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['allocated_to']; ?></td>
            <td><?php echo $row['date_allocated']; ?></td>
            <td>
                <form style="display:inline;"action="admin.php"method="post">
                    <input type="hidden" name="id"value="<?php echo $row['id']; ?>">
                    <input type="submit" name="delet_resource" value="Delete">
                </form>
            <form style="display:inline;"action="edit_resource.php" method="get">
            <input type="hidden" name="id"value="<?php echo $row['id']; ?>">
            <input type="submit"value="Edit">
    </form>
    <?php endwhile; ?>
    </table>

<form action="admin.php" method="post" onsubmit="return confirm('Are you sure you want to clear data?');">
    <input type="submit" name="clear_all" value="Clear All">
    </form>
    <p><a href="index.php">Back to Resource List</a></>
    </body>
    </html>



