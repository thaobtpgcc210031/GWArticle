<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .left-panel,
        .right-panel {
            flex: 1;
            padding: 20px;
        }

        .left-panel {
            background-color: #f0f0f0;
        }

        .right-panel {
            background-color: #e0e0e0;
        }

        /* Responsive layout */
        @media (max-width: 768px) {

            .left-panel,
            .right-panel {
                flex: 100%;
            }
        }

        /* Chat box styles */
        .chat-box {
            border: 1px solid #ccc;
            height: 300px;
            overflow-y: auto;
            padding: 10px;
        }

        .chat-message {
            margin-bottom: 10px;
        }

        .chat-message .sender {
            font-weight: bold;
        }

        .chat-message .message-body {
            margin-left: 20px;
        }

        /* Download button styles */
        .download-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .download-btn:hover {
            background-color: #45a049;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .btn_back {
            display: inline-block;
            font-weight: bold;
            padding: 4px 16px;
            background-color: #fff;
            color: black;
            text-decoration: none;
            border-radius: 3px;
            border: none;
        }

        .btn_back:hover {
            border-radius: 3px;
            transition: background-color 0.3s, color 0.3s;
background-color: grey;
            color: white;
        }

        .btn_back span {
            display: inline-block;
        }

        /* Add Feedback section */
        #feedbackInput {
            margin-top: 20px;
        }

        #feedbackInput input[type="text"],
        #feedbackInput button[type="submit"] {
            margin-top: 10px;
        }

        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <?php
    // Include the connection.php file
    include_once("connection.php");

    // Initialize the success message variable
    $success_message = "";

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle feedback submission
        if (isset($_POST['feedback'])) {
            $feedbackValue = $_POST['feedback'];
            // Insert feedback into the database or process as needed
            $insertQuery = "INSERT INTO comments (ContributionID, Comment, CommentDate, UserID) VALUES (?, ?, NOW(), ?)";
            $stmt = $conn->prepare($insertQuery);
            if ($stmt) {
                // Bind parameters and execute the statement
                $stmt->bind_param("isi", $contributionID, $feedbackValue, $userID);
                $contributionID = $_GET['id']; // Assuming you get it from the URL
                if (isset($_SESSION['UserID'])) {
                    $userID = $_SESSION['UserID'];
                } // Assuming you store user ID in session after login
                if ($stmt->execute()) {
                    // Feedback inserted successfully
                    $success_message = "Feedback submitted successfully!";
                } else {
                    // Error occurred while inserting feedback
                    $success_message = "Error: " . $stmt->error;
                }
                // Close statement
                $stmt->close();
            } else {
                // Error preparing statement
                $success_message = "Error: " . $conn->error;
            }
        }
    }

    // Retrieve contribution details
    if (isset($_GET['id'])) {
        $contributionID = $_GET['id'];
        $sql = "SELECT Title, ContentP, FileP, ImgCv, ImgSample, Status FROM contributions WHERE ContributionID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $contributionID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $title = $row['Title'];
                $content = $row['ContentP'];
                $fileP = $row['FileP'];
                $imgCv = $row['ImgCv'];
                $imgSample = $row['ImgSample'];
                $status = $row['Status'];
                $pdfLink = "download.php?file=example.pdf";
            }
        }
    }
    ?>

    <form method="POST">
<input type="hidden" id="selectedStatusInput" name="selectedStatus" value="<?php echo htmlspecialchars($status); ?>">
        <a href="?page=submit" class="btn_back"><span>&#171;Back</span></a>
        <div class="container">
            <div class="left-panel">
                <div class="header">
                    <h2 style="display: inline;">Contributions</h2>
                    <a class="download-btn" href="<?php echo $pdfLink; ?>" download style="display: inline; float: right;">Download PDF</a>
                </div>
                <p><strong>Title:</strong> <?php echo $title; ?></p>
                <p><strong>Content:</strong> <?php echo $content; ?></p>
                <p><strong>File:</strong> <?php echo $fileP; ?></p>
                <div class="dropdown">
                    <?php if (empty($status)) { ?>
                        <button class="dropbtn" id="selectedStatus" name="selectedStatus">Considering...</button>
                    <?php } else { ?>
                        <button class="dropbtn" id="selectedStatus" name="selectedStatus"><?php echo $status; ?></button>
                    <?php } ?>
                </div>
                <button type="submit" name="" id="" value="UpdateStatus">Update Your Contribution</button>
               <!-- Add Feedback section -->
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 3) { ?>
                    <button onclick="toggleFeedbackInput()">Add Feedback</button>
                    <div id="feedbackInput" style="display: none;">
                        <form method="POST">
                            <input type="text" name="feedback" placeholder="Enter feedback...">
                            <button type="submit">Submit Feedback</button>
                        </form>
                    </div>
                    <!-- Display success message if feedback submitted successfully -->
                    <?php if ($success_message !== "") { ?>
                        <div class="success-message"><?php echo $success_message; ?></div>
                    <?php } ?>
                <?php } ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            </div>
            <script>
                function toggleFeedbackInput() {
                    var feedbackInput = document.getElementById('feedbackInput');
                    if (feedbackInput.style.display === 'none') {
                        feedbackInput.style.display = 'block';
                    } else {
                        feedbackInput.style.display = 'none';
                    }
                }
                
                // Check if the Add Feedback button was clicked
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback'])) { ?>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById('feedbackInput').style.display = 'block';
                    });
<?php } ?>
            </script>


            <div class="right-panel">
                <h2>Chat</h2>
                <!-- PHP code for handling message submission -->
                <form action="#" method="post">
                    <input type="text" name="message" placeholder="Type here...">
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </form>


</body>

</html>