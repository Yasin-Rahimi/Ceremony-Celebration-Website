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
    <div id="nemoone">
        <div class="introduce-section">
            <span class="nemoone-text">
بیش از 60 نمونه کار در زمینه دیزاین تولد، دکور فرمالیته و بادکنک ارایی
</span>
        </div>

    <div class="slideshow-container">
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    </div>
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
    let nemoone_gellery = <?php echo json_encode($nemoone_gellery); ?>;
    let nemoone_size = <?php echo $nemoone_size; ?>;
    
    for (let i = 0; i < nemoone_size; i++) {
        let element = `
            <div class='mySlides fade'>
                <div class='numbertext'>${i+1} / ${nemoone_size}</div>
                <img src='media/nemoone/nemoone-car/${nemoone_gellery[i]}' style='width:100%'>
            </div>`;
        container.innerHTML += element;
    }
    
    let slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName('mySlides');
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
        }
        slides[slideIndex-1].style.display = 'block';
    }
</script>
