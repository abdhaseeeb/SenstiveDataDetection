<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// If logged in, proceed to display the membership page content
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensitivity Checker</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="membership.css">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Sensitivity Checker</h1>
            <nav id="navbar">
                <a href="./detection.php" class="nav-link">Home</a>
                <a href="#membership" class="nav-link">Plans</a>
                <a href="#about" class="nav-link">About Us</a>
                <a href="#contact" class="nav-link">Contact</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="sliderinfo">
                <section class="membership-description swiper">
                    <div class="swiper-wrapper">
                        <!-- First Slide -->
                        <div class="swiper-slide">
                            <h2>Welcome to Sensitivity Checker!</h2>
                            <p>Explore the full range of tools and resources designed to help you create inclusive and sensitive digital content that respects and appeals to a wide audience.</p>
                        </div>
                        <!-- Second Slide -->
                        <div class="swiper-slide">
                            <h2>Optimize Your Content</h2>
                            <p>Use our advanced detection tools to refine your content, ensuring it meets global sensitivity standards and adheres to best practices for inclusivity.</p>
                        </div>
                    </div>
                    <!-- Pagination dots -->
                    <div class="swiper-pagination"></div>
                </section>
            </div>
        </div>

        <div id="membership" class="sub">
            <section class="subscription-plans">
                <h2>Choose Your Plan</h2>
                <div class="plans grid">
                    <!-- Basic Plan -->
                    <div class="plan">
                        <img src="./webapp/public/assets/images/basic-icon.png" alt="Icon representing the Basic Plan" class="basic-plan-img">
                        <h3>Basic</h3>
                        <p>Free</p>
                        <p>Up to 5 images and one text prompt</p>
                        <button class="btn subscribe" data-membership="basic">Choose Plan</button>
                    </div>
                    <!-- Premium Plan -->
                    <div class="plan">
                        <img src="./webapp/public/assets/images/premium-icon.png" alt="Icon representing the Premium Plan" class="premium-plan-img">
                        <h3>Premium</h3>
                        <p>$5 Per Month</p>
                        <p>Up to 50 images and 10 text prompts</p>
                        <button class="btn subscribe" data-membership="premium">Choose Plan</button>
                    </div>
                    <!-- Premium Plus Plan -->
                    <div class="plan">
                        <img src="./webapp/public/assets/images/plus-icon1.png" alt="Icon representing the Premium Plus Plan" class="plus-plan-img">
                        <h3>Premium Plus</h3>
                        <p>$7 Per Month</p>
                        <p>Unlimited images and text detection</p>
                        <button class="btn subscribe" data-membership="premium_plus">Choose Plan</button>
                    </div>
                </div>
            </section>
        </div>

        <!-- About Section -->
        <section class="about">
            <h2>About Us</h2>
            <p>At Sensitivity Checker, we believe that content should be inclusive, respectful, and safe for all audiences. Our tools help ensure that your content is sensitive to cultural, racial, and social contexts, making it universally accessible and appealing.</p>
            <p>We are committed to providing the best tools to help content creators, marketers, and businesses ensure that their digital content is inclusive, diverse, and appropriate for all users worldwide.</p>
        </section>

        <!-- Features Section -->
        <section class="features">
            <h2>Why Choose Us?</h2>
            <div class="feature-list grid">
                <div class="feature">
                    <i class="fas fa-check-circle fa-3x"></i>
                    <h3>Comprehensive Analysis</h3>
                    <p>Our platform checks for sensitivity across various topics including language, images, and tone.</p>
                </div>
                <div class="feature">
                    <i class="fas fa-cogs fa-3x"></i>
                    <h3>Advanced Tools</h3>
                    <p>Utilize advanced AI-driven tools to fine-tune and improve your content for a global audience.</p>
                </div>
                <div class="feature">
                    <i class="fas fa-users fa-3x"></i>
                    <h3>Global Reach</h3>
                    <p>Content that is sensitive to various global contexts and accessible to diverse audiences.</p>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials">
            <h2>What Our Customers Say</h2>
            <p>"This service is excellent! Never thought it would be so easy to use this feature!" - Jane Doe</p>
            <p>"Absolutely love the premium plan, worth every penny!" - John Smith</p>
            <p>"As a content creator, I find this tool to be a game-changer for making sure my content is inclusive!" - Sarah Lee</p>
        </section>

        <!-- Contact Section -->
        <div class="container"> <!-- Adding container to wrap the contact section -->
        <section class="contact">
            <h2>Contact Us</h2>
            <p>If you have any questions or need support, feel free to reach out to us:</p>
            <ul>
                <li>Email: support@sensitivitychecker.com</li>
                <li>Phone: +1 (800) 123-4567</li>
                <li>Address: 1234 Sensitivity St, Inclusivity City, 56789</li>
            </ul>
        </section>
    </div>
    </main>

    <footer>
        <p>© 2024 Sensitivity Checker Inc. All rights reserved.</p>
        <p>Follow us on social media</p>
        <p>Project by Group - 7</p>
    </footer>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subscribeButtons = document.querySelectorAll('.btn.subscribe');
            subscribeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const selectedPlan = this.getAttribute('data-membership'); // Get the selected plan
                    const userId = <?php echo isset($_SESSION['userId']) ? $_SESSION['userId'] : 'null'; ?>; // Get the user_id from session
        
                    if (userId !== null) {
                        // Send an AJAX request to update the membership in PHP
                        updateMembership(userId, selectedPlan);
                    } else {
                        alert("User is not logged in.");
                    }
                });
            });
        
            function updateMembership(userId, selectedPlan) {
                fetch('updateMembership.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        userId: userId,
                        membershipType: selectedPlan
                    })
                })
                alert(`Your membership has been updated to the ${selectedPlan} plan.`);

            }
        });
        </script>
</body>
</html>
