<?php
session_start();  // Start the session at the top of the page

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    // Now you can use $userId in detection.php

    // Check user's membership count
    include 'connect.php';  // Assuming you have a connect.php file for the database connection

    $sql = "SELECT count FROM membership WHERE users_id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userCount = $row['count'];
    } else {
        // In case there is no membership data, redirect to login
        header("Location: membership.html");
        exit();
    }
} else {
    // Redirect to login if session is not set
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE  html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detection of Sensitive Data exposure in Images">
    <title>Sensitivity checker</title>
    <link rel="icon" href="./assets/images/favicon.png">
    <link rel="stylesheet" href="./detectstyle.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel=”stylesheet” href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- TensorFlow JS and Tesseract -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs/dist/tf.min.js"></script>
    <script src="https://unpkg.com/tesseract.js@v2.1.0/dist/tesseract.min.js"></script>
</head>

<body>
    <nav class="navbar">
        <div class="title"><a href="">Sensitivity Checker</a></div>
        <div class="toggle-button">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <div class="navbar-links">
            <ul>
                <li><a href="#about">About</a></li>
                <li><a href="#team">Team</a></li>
                <li><a href="./membership.php">Membership Plans</a></li>
                <li><a href="./logout.php">Logout</a></li>
                <li class="darkmode-button">
                    <input type="checkbox" class="checkbox" id="chk" />
                    <label class="label" for="chk">
            <i class="fas fa-sun"></i>	    
            <i class="fas fa-moon"></i>
            <div class="ball"></div>
          </label>
                </li>
            </ul>
        </div>
    </nav>

    <div class="section">
       

        <div class="big-text">Detection of sensitive data exposure in images</div>
        <div class="steps">
            <div class="single-step">
                <img src="./webapp/public/assets/images//click.png" alt="Upload">
                <div class="single-step-content">
                    <p class="main-title">Click</p>
                    <p>Take or choose a picture from your device</p>
                </div>
            </div>
            <div class="single-step">
                <img src="./webapp/public/assets/images/upload.png" alt="Upload">
                <div class="single-step-content">
                    <p class="main-title">Upload</p>
                    <p>Upload the picture to SENSITIVITY CHECKER before uploading to cloud</p>
                </div>
            </div>
            <div class="single-step">
                <img src="./webapp/public/assets/images/detect.png" alt="Upload">
                <div class="single-step-content">
                    <p class="main-title">Detect</p>
                    <p>Detect if your image contains sensitive information</p>
                </div>
            </div>
        </div>
 <!-- Welcome Message Section -->
 <div class="welcome-container">
    <h3>Welcome, Available Credits: <?php echo $userCount; ?> </h3>
</div>
        <div class="main-container">
            <button>Browse File</button>
            <div class="drag-area">
                <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
                <header>Upload your file here</header>
                <input type="file" onchange="loadFile(event, <?php echo $userCount; ?>)" hidden>
                <img src="#" id="output">
            </div>
            <h1>Text Classifier</h1>
<div class="text-input-area">
<textarea id="input_text" class="input-text" placeholder="Enter your text here..." oninput="autoResizeTextarea(this)"></textarea>
    <button onclick="handleClick(<?php echo $userCount; ?>)" class="classify-button">Classify Text</button>
    <div id="textResult" class="classification"></div>
    <div id="text_output">Classification result will appear here...</div>
</div>

            <div id="progressStatus">
                <div id="progressBar">1%</div>
            </div>
            <div class="classification non-sensitive main-title"><i class="fas fa-check-square"></i> Non-Sensitive</div>
            <div class="classification sensitive main-title"><i class="fas fa-times-circle"></i> Sensitive</div>
        </div>
    </div>

    <div id="about" class="section secondary">
        <div>
            <div class="big-text">
                Is your data safe in the cloud?
            </div>

            <p>
                In the current age of smart devices and smart phones, any image taken using these devices are immediately auto uploaded to the cloud (Google Photos, iCloud, etc) or internet (Social media sites like Facebook, Twitter, etc). And there is an archive of
                all the contents that is being uploaded to the internet in the Wayback Machine. So, one must be cautious about what is being uploaded to the internet.
            </p>

            <p>
                Loss, misuse, modification, or unauthorized access to sensitive information can adversely affect the privacy or welfare of an individual, trade secrets of a business or even the security and international relations of a nation depending on the level of
                sensitivity and nature of the information.
            </p>
        </div>

        <div>
            <div class="main-title">
                About the project
            </div>

            <p>
                We have designed a machine learning system that classifies the data in the images as <b>sensitive or non-sensitive</b>. On being classified as sensitive, we can warn the users that their image contains sensitive information (before uploading
                to the cloud).
            </p>
            
        </div>
    </div>

    

    <div class="footer">
        <p class="footer-text">Project by Group - 7</p>
        <p class="footer-text">© Sensitivity Checker - 2024</p>
    </div>

    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>
    <div class="firefly"></div>

    <script src="./detectscript.js">
    </script>
    <script>
    var userCount = <?php echo $userCount; ?>;
</script>

</body>

</html>