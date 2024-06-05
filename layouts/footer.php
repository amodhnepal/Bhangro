<style>
    /* Reset some default styles */
    body, html {
      margin: 0;
      padding: 0;
    }
    ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    /* Footer styles */
    footer {
      background-color: #2a2a2a;
      color: white;
      padding: 40px 0;
    }
    footer h5 {
      font-weight: 700;
      font-size: 1.2rem;
      margin-bottom: 20px;
    }
    footer li {
      padding-bottom: 4px;
    }
    footer li a {
      font-size: 0.8rem;
      color: #999;
      text-decoration: none;
    }
    footer li a:hover {
      color: white;
    }
    .social-icons {
      margin-top: 20px;
    }
    .social-icons a {
      color: white;
      margin-right: 10px;
      font-size: 1.2rem;
    }
    .map {
      width: 400px;
      height: 200px; /* Adjust height as needed */
      background-color: #f0f0f0; /* Placeholder background color */
      margin-top: 20px;
    }
    .footer-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    .footer-row {
      display: flex;
      flex-wrap: wrap;
      margin: 0 -15px;
    }
    .column {
      flex: 1;
      padding: 0 15px;
    }

    .footer-content p{
      color:#999
    }
   
  </style>


<!-- footer -->
<footer class="mt-5 py-5">
    <div class="footer-container">
      <div class="footer-row">
        <div class="column column-3" style="">
        <a href="index.php">
          <img src="images\Logo.png" alt="Logo" style="width:300px; ">
        </a>
        </div>
        <div class="column column-3">
          <h5>Featured</h5>
          <ul class="text-uppercase footer-featured">
            <li><a href="">String bag</a></li>
            <li><a href="">Twot Bag</a></li>
            <li><a href="">Fanny pack</a></li>
            <li><a href="">Side Bag</a></li>
          </ul>
        </div>
        <div class="column column-3">
          <h5>Contact Us</h5>
          <div class="footer-content">
            <h6 class="text-uppercase">Address</h6>
            <p>Budhanilkantha, Kathmandu</p>
          </div>
          <div class="footer-content">
            <h6 class="text-uppercase">Phone</h6>
            <p>9862583199</p>
          </div>
          <div class="footer-content">
            <h6 class="text-uppercase">Email</h6>
            <p>bhangro@gmail.com</p>
          </div>
        </div>
        <div class="column column-3">
          <h5>Find Us</h5>
          <div class="map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7062.830340267742!2d85.32630444402677!3d27.735337804665935!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb193854e20abb%3A0x8ff36d1f00e10346!2z4KSu4KS-4KS54KS-4KSw4KS-4KSc4KSX4KSC4KScLCDgpJXgpL7gpKDgpK7gpL7gpKHgpYzgpIEgNDQ2MDA!5e0!3m2!1sne!2snp!4v1711081055122!5m2!1sne!2snp"style="border:0; width:100%; height:100%" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
      <div class="footer-row flex-column justify-content-center align-items-center mt-4">
        <div class="social-icons">
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
        <span style="font-weight: 100; padding:5px 0;">copyright &copy; Bhangro, 2024 </span>
      </div>
    </div>
  </footer>
 