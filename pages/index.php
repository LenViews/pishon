<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'pishon_shop');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $conn->real_escape_string($_POST['regUsername']);
    $email = $conn->real_escape_string($_POST['regEmail']);
    $password = password_hash($_POST['regPassword'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            echo "Login successful!";
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that username!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pishon Shop Website</title>
    <link rel="stylesheet" type="text/css" href="/pj/css/style.css">

    <style>
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .btn {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <h1>Pishon Shop</h1>
                    <input type="text" placeholder="Search..." name="search">
                </div>
                <nav>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Product</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Cart</a></li>
                        <li><a href="#">Checkout</a></li>
                        <?php if (isset($_SESSION['username'])): ?>
                            <li><a href="#">Welcome, <?php echo $_SESSION['username']; ?></a></li>
                            <li><a href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="#" id="loginBtn">Login</a></li>
                            <li><a href="#" id="registerBtn">Register</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <div class="row">
                <div class="col">
                    <h2>Welcome to The<br>Pishon Online Shop!</h2>
                    <p>Discover the best designer clothing<br>for all your needs.</p>
                    <a href="#" class="btn">Explore Now &#8594;</a>
                </div>
                <div class="col">
                    <img src="/pj/img/img1.jpeg" alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeLogin">&times;</span>
            <h2>Login</h2>
            <form action="index.php" method="POST">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required><br><br>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required><br><br>
                <button type="submit" class="btn" name="login">Login</button>
            </form>
        </div>
    </div>

    <!-- Registration Modal -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeRegister">&times;</span>
            <h2>Register</h2>
            <form action="index.php" method="POST">
                <label for="regUsername">Username</label>
                <input type="text" id="regUsername" name="regUsername" required><br><br>
                <label for="regEmail">Email</label>
                <input type="email" id="regEmail" name="regEmail" required><br><br>
                <label for="regPassword">Password</label>
                <input type="password" id="regPassword" name="regPassword" required><br><br>
                <button type="submit" class="btn" name="register">Register</button>
            </form>
        </div>
    </div>

    <div class="categories">
        <div class="small-container">
            <div class="row">
                <div class="col3">
                    <img src="/pj/img/img2.jpg" alt="">
                </div>
                <div class="col3">
                    <img src="/pj/img/img3.jpg" alt="">
                </div>
                <div class="col3">
                    <img src="/pj/img/img5.jpg" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="small-container">
        <h2 class="title">Latest Products</h2>
        <div class="row">
            <div class="col4">
                <img src="/pj/img/img2.jpg" alt="">
                <h4>Men's clothing</h4>
                <p>Ksh 60,000</p>
            </div>
            <div class="col4">
                <img src="/pj/img/img3.jpg" alt="">
                <h4>Ladies Wear</h4>
                <p>Ksh 12,000</p>
            </div>
            <div class="col4">
                <img src="/pj/img/img12.jpg" alt="">
                <h4>Men's clothing</h4>
                <p>Ksh 120,000</p>
            </div>
            <div class="col4">
                <img src="/pj/img/img5.jpg" alt="">
                <h4>Teens clothing</h4>
                <p>Ksh 6,000</p>
            </div>
        </div>
    </div>

    <div class="small-container">
        <h2 class="title">Featured Products</h2>
        <div class="row">
            <div class="col4">
                <img src="/pj/img/img2.jpg" alt="">
                <h4>Men's clothing</h4>
                <p>Ksh 60,000</p>
            </div>
            <div class="col4">
                <img src="/pj/img/img3.jpg" alt="">
                <h4>Ladies Wear</h4>
                <p>Ksh 12,000</p>
            </div>
            <div class="col4">
                <img src="/pj/img/img11.png" alt="">
                <h4>Men's Shoes</h4>
                <p>Ksh 20,000</p>
            </div>
            <div class="col4">
                <img src="/pj/img/img5.jpg" alt="">
                <h4>Teens clothing</h4>
                <p>Ksh 6,000</p>
            </div>
        </div>
        <div class="row">
            <div class="col4">
                <img src="/pj/img/img6.jpg" alt="">
                <h4>Men's clothing</h4>
                <p>Ksh 60,000</p>
            </div>
            <div class="col4">
                <img src="/pj/img/img7.jpg" alt="">
                <h4>Ladies Wear</h4>
                <p>Ksh 12,000</p>
            </div>
            <div class="col4">
                <img src="/pj/img/img8.jpeg" alt="">
                <h4>Men's clothing</h4>
                <p>Ksh 20,000</p>
            </div>
            <div class="col4">
                <img src="/pj/img/img9.jpg" alt="">
                <h4>Teens clothing</h4>
                <p>Ksh 6,000</p>
            </div>
        </div>
    </div>

    <div class="offer">
        <div class="small-container">
            <div class="row">
                <div class="col">
                    <img src="/pj/img/img10.jpg" class="offer-img">
                </div>
                <div class="col">
                    <p>Only Available in Pishon Shop</p>
                    <h1>Nike</h1>
                    <small>Rounding out the top 10 in November were Burberry (9,808,722); 
                        Levi’s (9,371,541); Nike Football (9,112,968); Lacoste (6,742,187); DC Shoes (6,196,780); Puma (5,907,725); Gucci (5,644,529), and Dior (5,612,573). 
                        The only changes between October’s and November’s rankings was that Levi’s and Nike Football switched places.<br>
                    </small>
                    <a href="#" class="btn">Buy Now &#8594;</a>
                </div>
            </div>
            <div class="footer">
                <div class="small-container">
                    <p>&copy; 2024 Pishon Shop. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Adding JavaScript for modal functionality -->
    <script>
        // Get the modals
        var loginModal = document.getElementById("loginModal");
        var registerModal = document.getElementById("registerModal");

        // Get the buttons that open the modals
        var loginBtn = document.getElementById("loginBtn");
        var registerBtn = document.getElementById("registerBtn");

        // Get the <span> elements that close the modals
        var closeLogin = document.getElementById("closeLogin");
        var closeRegister = document.getElementById("closeRegister");

        // When the user clicks the button, open the modal
        loginBtn.onclick = function() {
            loginModal.style.display = "block";
        }
        registerBtn.onclick = function() {
            registerModal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        closeLogin.onclick = function() {
            loginModal.style.display = "none";
        }
        closeRegister.onclick = function() {
            registerModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == loginModal) {
                loginModal.style.display = "none";
            } else if (event.target == registerModal) {
                registerModal.style.display = "none";
            }
        }
    </script>
</body>
</html>