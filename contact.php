<?php
$pageTitle = 'Contact Us'; // Set the page title
include 'includes/header.php'; // Include your header
?>

<!-- Contact Us Content -->
<div class="container mt-4">
    <h1>Contact Us</h1>
    <p>
        We would love to hear from you! Whether you have questions, feedback, or suggestions, feel free to reach out. Use the form below to get in touch with our team.
    </p>

    <!-- Contact Form -->
    <form method="POST" action="process-contact.php">
        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Your Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">Your Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>

    <!-- Our Office Information -->
    <h3 class="mt-5">Our Office</h3>
    <p>
        OpenLearn Headquarters<br>
        123 Learning Avenue, Suite 100<br>
        Education City, XYZ 12345<br>
        Email: <a href="mailto:contact@openlearn.com">contact@openlearn.com</a><br>
        Phone: (123) 456-7890
    </p>

    <!-- Interactive Map Section -->
    <h3>Find Us on the Map</h3>
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed/v1/place?q=123+Learning+Avenue,+Suite+100,+Education+City,+XYZ+12345&key=YOUR_GOOGLE_MAPS_API_KEY" allowfullscreen></iframe>
    </div>

    <!-- Frequently Asked Questions Section -->
    <h3 class="mt-5">Frequently Asked Questions (FAQ)</h3>
    <div class="accordion" id="faqAccordion">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        How can I enroll in a course?
                    </button>
                </h5>
            </div>
            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                <div class="card-body">
                    To enroll in a course, simply visit the <a href="courses.php">Courses</a> page, browse through our course offerings, and select the course you want to take. You can sign up for free directly on the course page.
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Are the courses really free?
                    </button>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                <div class="card-body">
                    Yes! All our courses are completely free. There are no hidden fees or charges for accessing our content.
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Can I get a certificate after completing a course?
                    </button>
                </h5>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                <div class="card-body">
                    Currently, OpenLearn does not offer official certificates. However, you will receive a completion badge on your profile, which you can showcase to highlight your learning progress.
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media Links -->
    <h3 class="mt-5">Follow Us</h3>
    <p>
        Stay connected with us through our social media channels for updates, announcements, and more:
    </p>
    <ul class="list-inline">
        <li class="list-inline-item">
            <a href="https://facebook.com/openlearn" target="_blank" class="btn btn-outline-primary">Facebook</a>
        </li>
        <li class="list-inline-item">
            <a href="https://twitter.com/openlearn" target="_blank" class="btn btn-outline-primary">Twitter</a>
        </li>
        <li class="list-inline-item">
            <a href="https://instagram.com/openlearn" target="_blank" class="btn btn-outline-primary">Instagram</a>
        </li>
        <li class="list-inline-item">
            <a href="https://linkedin.com/company/openlearn" target="_blank" class="btn btn-outline-primary">LinkedIn</a>
        </li>
    </ul>

    <!-- Support Information Section -->
    <h3 class="mt-5">Need Help?</h3>
    <p>
        If you need assistance with any aspect of the platform or have technical issues, please reach out to our support team at <a href="mailto:support@openlearn.com">support@openlearn.com</a>. We're here to help!
    </p>
</div>

<?php include 'includes/footer.php'; ?>
