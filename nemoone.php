<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-------- Nemoone container -------->
    <section id="nemoone">
        <div class="introduce-section">
            <span class="nemoone-text">
..بیش از 60 نمونه کار در زمینه دیزاین تولد، دکور فرمالیته و بادکنک ارایی
</span>
        </div>

    <div class="enhanced-slider-container">
        <!-- Auto-play controls -->
        <div class="slider-controls">
            <button class="autoplay-btn" id="autoplayBtn" onclick="toggleAutoplay()">
                <span class="play-icon">▶</span>
                <span class="pause-icon">⏸</span>
            </button>
        </div>

        <!-- Main slider with navigation arrows -->
        <div class="slideshow-container">
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>

        <!-- Dots indicators -->
        <div class="dots-container" id="dotsContainer"></div>

        <!-- Thumbnail navigation -->
        <div class="thumbnails-container">
            <div class="thumbnails-wrapper" id="thumbnailsWrapper"></div>
        </div>
    </div>

    </section>
</body>
</html>
<?php 
$nemoone_gellery = scandir('media/nemoone/nemoone-car/');
$nemoone_gellery = array_diff($nemoone_gellery, array('.', '..'));
$nemoone_gellery = array_values($nemoone_gellery);
$nemoone_size = sizeof($nemoone_gellery);
?>

<script>
    let container = document.querySelector('.slideshow-container');
    let dotsContainer = document.getElementById('dotsContainer');
    let thumbnailsWrapper = document.getElementById('thumbnailsWrapper');
    let autoplayBtn = document.getElementById('autoplayBtn');

    let nemoone_gellery = <?php echo json_encode($nemoone_gellery); ?>;
    let nemoone_size = <?php echo $nemoone_size; ?>;

    let slideIndex = 1;
    let autoplayInterval = null;
    let isAutoplay = false;
    let touchStartX = 0;
    let touchEndX = 0;

    // Generate slides
    for (let i = 0; i < nemoone_size; i++) {
        let element = `
            <div class='mySlides fade'>
                <div class='numbertext'>${i+1} / ${nemoone_size}</div>
                <img src='media/nemoone/nemoone-car/${nemoone_gellery[i]}' alt='Slide ${i+1}' loading='lazy'>
            </div>`;
        container.innerHTML += element;
    }

    // Generate dots
    for (let i = 0; i < nemoone_size; i++) {
        let dot = document.createElement('span');
        dot.className = 'dot';
        dot.onclick = function() { currentSlide(i + 1); };
        dotsContainer.appendChild(dot);
    }

    // Generate thumbnails
    for (let i = 0; i < nemoone_size; i++) {
        let thumbnail = document.createElement('div');
        thumbnail.className = 'thumbnail';
        thumbnail.onclick = function() { currentSlide(i + 1); };
        thumbnail.innerHTML = `<img src='media/nemoone/nemoone-car/${nemoone_gellery[i]}' alt='Thumbnail ${i+1}' loading='lazy'>`;
        thumbnailsWrapper.appendChild(thumbnail);
    }

    // Initialize
    showSlides(slideIndex);

    // Touch gesture support
    container.addEventListener('touchstart', handleTouchStart, { passive: true });
    container.addEventListener('touchend', handleTouchEnd, { passive: true });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') plusSlides(-1);
        if (e.key === 'ArrowRight') plusSlides(1);
    });

    // Pause on hover
    container.addEventListener('mouseenter', pauseAutoplay);
    container.addEventListener('mouseleave', resumeAutoplay);

    function plusSlides(n) {
        showSlides(slideIndex += n);
        resetAutoplayTimer();
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
        resetAutoplayTimer();
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName('mySlides');
        let dots = document.getElementsByClassName('dot');
        let thumbnails = document.getElementsByClassName('thumbnail');

        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}

        // Hide all slides
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
        }

        // Remove active class from all dots and thumbnails
        for (i = 0; i < dots.length; i++) {
            dots[i].classList.remove('active');
        }
        for (i = 0; i < thumbnails.length; i++) {
            thumbnails[i].classList.remove('active');
        }

        // Show current slide and highlight corresponding dot and thumbnail
        slides[slideIndex-1].style.display = 'block';
        dots[slideIndex-1].classList.add('active');
        thumbnails[slideIndex-1].classList.add('active');

        // Scroll thumbnail into view
        thumbnails[slideIndex-1].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
    }

    function toggleAutoplay() {
        if (isAutoplay) {
            pauseAutoplay();
        } else {
            startAutoplay();
        }
    }

    function startAutoplay() {
        isAutoplay = true;
        autoplayBtn.classList.add('playing');
        autoplayInterval = setInterval(function() {
            plusSlides(1);
        }, 4000);
    }

    function pauseAutoplay() {
        isAutoplay = false;
        autoplayBtn.classList.remove('playing');
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
    }

    function resumeAutoplay() {
        if (isAutoplay) {
            setTimeout(startAutoplay, 10000); // Resume after 10 seconds
        }
    }

    function resetAutoplayTimer() {
        if (isAutoplay) {
            pauseAutoplay();
            startAutoplay();
        }
    }

    // Touch gesture handling
    function handleTouchStart(e) {
        touchStartX = e.changedTouches[0].screenX;
    }

    function handleTouchEnd(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipeGesture();
    }

    function handleSwipeGesture() {
        let swipeThreshold = 50;
        let diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                plusSlides(1); // Swipe left, go to next
            } else {
                plusSlides(-1); // Swipe right, go to previous
            }
        }
    }

    // Start autoplay by default
    startAutoplay();
</script>
