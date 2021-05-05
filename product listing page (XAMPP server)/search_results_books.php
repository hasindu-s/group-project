<?php
    include 'conn_books.php';

    if (isset($_POST["search_btn"]))
    {
        $search_word = $_POST["search"];
        $result = $con->query("SELECT original_title, title, authors, average_rating, image_url FROM books WHERE original_title LIKE '%".$search_word."%'");
        $books = $result->fetch_all(MYSQLI_ASSOC);      
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Search results - <?= $search_word; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css" type="text/css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Langar&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <style>
            .bttn
            {
                display: inline-block;
                background: #ff523b;
                color: #fff;
                padding: 10px 30px;
                margin: 30px 0;
            }
            
            .bttn1
            {
                display: inline-block;
                background: grey;
                color: #fff;
                padding: 10px 30px;
                margin: 30px 0;
            }

            .bttn:hover
            {
                background: #563434;
            }
            
        </style>
    </head>

<body>

    <div class="container">
        <div class="navbar">
            <div class="logo">
                <h2 style="font-family: 'Langar', cursive;color:#C70039;font-size: 35px;">Storefront</h2>
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="index1.php">Home</a></li>
                    <li><a href="product1.php">Product</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact_us1.php">Contact</a></li>
                    <li><a href="login.php">Sign In</a></li>
                </ul>
            </nav>
            <img src="images/cart.png" width="30px" height="30px">
            <img src="images/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
        
    </div>
    
    <div class="small-container">
        <div class="row row2">
            <h2>Search Results for '<?= $search_word; ?>'</h2>
            
            <form action="search_results_books.php" method="post">
                <input type="text" name="search" id="speechToText" placeholder="Search books..." style="width:60%;height: 25px; border: 1px solid #bcbcbc;border-radius: 50px;padding: 15px;" required>
                <button type="button" onclick="record()"><i class="material-icons">settings_voice</i></button>
                <button type="submit" name="search_btn"><i class="material-icons">search</i></button>
            </form>
            
        <script>
        function record() {
            var recognition = new webkitSpeechRecognition();
            recognition.lang = "en-GB";

            recognition.onresult = function(event) {
                // console.log(event);
                document.getElementById('speechToText').value = event.results[0][0].transcript;
            }
            recognition.start();

        }
        </script>

            <select onChange="window.location.href=this.value">
                <option>Select a Product</option>
                <option value="product1.php">Men</option>
                <option value="women1.php">Women</option>
                <option value="kids1.php">Kids</option>
                <option value="watch1.php">Watches</option>
                <option value="electronic1.php">Phones</option>
                <option value="testbook1.php">Books</option>
                <option value="furniture1.php">Furnitures</option>
            </select>
        </div>
        
        <?php 
        if (empty($books))
        {
            echo'<h2 style="font-weight:bold; margin: 50px 0px 200px;">'.'No books were found'.'</h2>';
        }
        else
        {
            echo'<div class="row">';
                
            foreach($books as $book)
            {   
                $title = rawurlencode($book['title']);
                if($book['average_rating'] >= 4.5)
                {
                    echo'<div class="col-4">';
                    echo'<a href="http://127.0.0.1:5000/book_details/'.$title.'"><img src="'.$book['image_url'].'">';
                    echo'<h4 style="font-weight:bold;">'.$book['original_title'].'</h4>'.'</a>';
                    echo'<p style="font-weight:bold;">'.$book['authors'].'</p>';
                    echo'<p>'.'$9.00'.'</p>';
                    echo'<div class="rating">';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                    echo'</div>';
                    echo'<a href="http://127.0.0.1:5000/book_details/'.$title.'" class="bttn">Buy Now</a>';
                    echo'</div>';
                }
                        
                           
                else if($book['average_rating'] >= 4.0)
                {
                    echo'<div class="col-4">';
                    echo'<a href="http://127.0.0.1:5000/book_details/'.$title.'"><img src="'.$book['image_url'].'">';
                    echo'<h4 style="font-weight:bold;">'.$book['original_title'].'</h4>'.'</a>';
                    echo'<p style="font-weight:bold;">'.$book['authors'].'</p>';
                    echo'<p>'.'$9.00'.'</p>';
                    echo'<div class="rating">';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star-half-o"></i>';
                    echo'</div>';
                    echo'<a href="http://127.0.0.1:5000/book_details/'.$title.'" class="bttn">Buy Now</a>';
                    echo'</div>';
                }
                        
                else if($book['average_rating'] >= 3.5)
                {
                    echo'<div class="col-4">';
                    echo'<a href="http://127.0.0.1:5000/book_details/'.$title.'"><img src="'.$book['image_url'].'">';
                    echo'<h4 style="font-weight:bold;">'.$book['original_title'].'</h4>'.'</a>';
                    echo'<p style="font-weight:bold;">'.$book['authors'].'</p>';
                    echo'<p>'.'$9.00'.'</p>';
                    echo'<div class="rating">';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star-o"></i>';
                    echo'</div>';
                    echo'<a href="http://127.0.0.1:5000/book_details/'.$title.'" class="bttn">Buy Now</a>';
                    echo'</div>';
                }

                else if($book['average_rating'] >= 3.0)
                {
                    echo'<div class="col-4">';
                    echo'<a href="http://127.0.0.1:5000/book_details/'.$title.'"><img src="'.$book['image_url'].'">';
                    echo'<h4 style="font-weight:bold;">'.$book['original_title'].'</h4>'.'</a>';
                    echo'<p style="font-weight:bold;">'.$book['authors'].'</p>';
                    echo'<p>'.'$9.00'.'</p>';
                    echo'<div class="rating">';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star-half-o"></i>';
                        echo'<i class="fa fa-star-o"></i>';
                    echo'</div>';
                    echo'<a href="http://127.0.0.1:5000/book_details/'.$title.'" class="bttn">Buy Now</a>';
                    echo'</div>';
                }
                        
                else
                {
                    echo'<div class="col-4">';
                    echo'<a href="http://127.0.0.1:5000/book_details/'.$title.'"><img src="'.$book['image_url'].'">';
                    echo'<h4 style="font-weight:bold;">'.$book['original_title'].'</h4>'.'</a>';
                    echo'<p style="font-weight:bold;">'.$book['authors'].'</p>';
                    echo'<p>'.'$9.00'.'</p>';
                    echo'<div class="rating">';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star"></i>';
                        echo'<i class="fa fa-star-o"></i>';
                        echo'<i class="fa fa-star-o"></i>';
                    echo'</div>';
                    echo'<a href="http://127.0.0.1:5000/book_details/'.$title.'" class="bttn">Buy Now</a>';
                    echo'</div>';
                }
            }          
            echo "</div>";
        }
        ?>
    
    </div>
    <!--footer-->
    
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <h3>Download our App</h3>
                    <p>Download app for android and ios mobile phone</p>
                    <div class="app-logo">
                        <img src="images/play-store.png">
                        <img src="images/app-store.png">
                    </div>
                </div>
                
                 <div class="footer-col-2">
                    <p>Our purpose is to sustainbly make the pleasure and benefits of online shopping accessible to the many.</p>
                </div>
                
                <div class="footer-col-3">
                    <h3>Useful Links</h3>
                    <ul>
                        <li>Coupons</li>
                        <li>Blog Post</li>
                        <li>Return Policy</li>
                        <li>Join Affiliate</li>
                    </ul>
                </div>
                
                <div class="footer-col-4">
                    <h3>Follow Us</h3>
                    <ul>
                        <li>Facebook</li>
                        <li>Twitter</li>
                        <li>Instagram</li>
                        <li>YouTube</li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="copyright">Copyright 2021 - StoreFront</p>
        </div>
    </div>

    <script>
        var MenuItems = document.getElementById("MenuItems");
        
        MenuItems.style.maxHeight = "0px";
        
        function menutoggle()
        {
            if(MenuItems.style.maxHeight == "0px")
            {
                MenuItems.style.maxHeight = "200px";
            }
            
            else
            {
                MenuItems.style.maxHeight = "0px"; 
            }
            
        }
        
    </script>
    <script src="https://account.snatchbot.me/script.js"></script><script>window.sntchChat.Init(145307)</script> 
</body>
    
</html>