<?php
    session_start();
    include "database.php";
    // Assuming the $username and $password are already set (e.g., from the session or request)
    $sql = "SELECT * FROM Student WHERE EMAIL = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_SESSION["email"], $_SESSION["password"]); // Bind the username and password parameters
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    // Check if we got a result
    if ($result->num_rows > 0) {
        // Fetch the row as an associative array
        $row = $result->fetch_assoc();
        $Fname = $row['FirstName']; // Retrieve the 'FirstName' from the row
        $Lname = $row['Lastname']; // Retrieve the 'FirstName' from the row
        $SID = $row['StudentID']; // Retrieve the 'FirstName' from the row
        $GPA = $row['GPA']; // Retrieve the 'FirstName' from the row
        $major = $row['MajorID']; 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Course Registration System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section id="home">
        <h2>Home Screen</h2>

        <!-- Student Information Section -->
        <div class="student-info">
            <h3>Student Information</h3>
            <p><strong>Name:</strong><?php echo "$Fname $Lname" ?></p>
            <p><strong>Student ID:</strong><?php echo "$SID" ?></p>
            <p><strong>GPA:</strong><?php echo "$GPA" ?></p>
            <p><strong>Major:</strong><?php echo "$major" ?></p>
            <p><strong>Standing:</strong><?php echo "" ?></p>
            <p><strong>Credits Earned:</strong><?php echo "" ?></p>
        </div>

        <div class="sidebar">
            <h3>Registered Classes</h3>
            <form id="registeredClassesForm">
                <div id="registeredClassesList"></div>
                <div class="button-container">
                    <button type="button" id="dropClassesButton" onclick="">Drop Selected Classes</button>
                    <button type="button" id="registerClassesButton" onclick="window.location.href='selection.php'">Register for Classes</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>

