<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="/css/home.css" rel="stylesheet">
</head>
<body>
    @include('layout.navbar')
        <div class="home-section">
            <div class="triangle"></div>
            <img src="/images/neighbors.png" alt="Image" class="neighbor-image">
            <div class="circle"></div>
            <div class="circle2"></div>
            <div class="title-text">Explore, Connect, and Thrive<br>with Community Canvas</div>
            <div class="intro">Bergabunglah bersama kami saat ini dan marilah mengecat dari pengalaman bersama, gagasan, dan peluang untuk memperkaya keberagaman komunitas kita.</div>
        </div>
        <div class="about-section" id="about">
            <div class="about-container">
                <div class="rectangle"></div>
                <img src="/images/new-neighbors.jpg" alt="Community Image">
                <div class="about-text">
                    <h2>Tentang Kami</h2>
                    <p>Community Canvas adalah sebuah website dimana warga bisa mendapatkan berita dan acara lokal. Warga bisa mengunggah berita dan menambahkan acara mereka sendiri di kalender yang tersedia.</p>
                </div>
            </div>
        </div>
        <div class="contact-section" id="contact">
            <h2>Kontak Kami</h2>
            <div class="contact-info">
                <div class="contact-item">
                    <div class="icon email-icon"></div>
                    <img src="/images/email-icon.png" alt="Email" class="email-icon">
                    <p>community.canvas@gmail.com</p>
                </div>
                <div class="contact-item">
                    <div class="icon phone-icon"></div>
                    <img src="/images/phone-icon.png" alt="Phone" class="phone-icon">
                    <p>021-27482953<br>08568944752</p>
                </div>
                <div class="contact-item">
                    <div class="icon location-icon"></div>
                    <img src="/images/location-icon.png" alt="Location" class="location-icon">
                    <p>Jl. Ujung Munteng RT 008/03,<br>DKI Jakarta</p>
                </div>
            </div>
        </div>
</body>
</html>