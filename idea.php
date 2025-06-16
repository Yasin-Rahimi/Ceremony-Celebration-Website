<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section id="idea">
        <h1 class="introduce-section">!و ایده هایی که با درخواست شما میتونن اجرایی بشن</h1>
        <div id="gallery-container"></div>   
        <div class="gallery-controls"></div>   
</section>

    <?php 
    $ideaGallery = scandir('media/idea/');
    $ideaGallery = array_diff($ideaGallery, array('.', '..'));
    $ideaGallery = array_values($ideaGallery);
    $ideaSize = sizeof($ideaGallery);
    ?>

    <script>
        const galleryContainer = document.getElementById('gallery-container');
        const galleryControlsContainer = document.querySelector('.gallery-controls');

        // Define button labels and matching CSS classes
        const galleryControls = [
            { label: '', class: 'previous' },
            { label: '', class: 'next' }
        ];

        // Get PHP variables from server
        const ideaGalleryArray = <?php echo json_encode($ideaGallery); ?>;
        const ideaSize = <?php echo $ideaSize; ?>;

        // Create image elements
        let result = '';
        for (let i = 0; i < ideaSize; i++) {
            let element = `
                <img class='gallery-item gallery-item-${i + 1}' src='media/idea/${ideaGalleryArray[i]}' data-index='${i + 1}'>
            `;
            result += element;
        }
        galleryContainer.innerHTML = result;

        const galleryItems = document.querySelectorAll('.gallery-item');

        class Carousel {
            constructor(container, items, controls) {
                this.carouselContainer = container;
                this.carouselControls = controls;
                this.carouselArray = [...items];
            }

            updateGallery() {
                this.carouselArray.forEach(el => {
                    el.classList.remove('gallery-item-1', 'gallery-item-2', 'gallery-item-3', 'gallery-item-4', 'gallery-item-5');
                });

                this.carouselArray.slice(0, 5).forEach((el, i) => {
                    el.classList.add(`gallery-item-${i + 1}`);
                });
            }

            setCurrentState(direction) {
                if (direction === 'previous') {
                    this.carouselArray.unshift(this.carouselArray.pop());
                } else {
                    this.carouselArray.push(this.carouselArray.shift());
                }
                this.updateGallery();
            }

            setControls() {
                this.carouselControls.forEach(control => {
                    const btn = document.createElement('button');
                    btn.className = `gallery-controls-${control.class}`;
                    btn.innerText = control.label;
                    btn.dataset.direction = control.class;
                    galleryControlsContainer.appendChild(btn);
                });
            }

            useControls() {
                const triggers = [...galleryControlsContainer.childNodes];
                triggers.forEach(control => {
                    control.addEventListener('click', e => {
                        e.preventDefault();
                        this.setCurrentState(control.dataset.direction);
                    });
                });
            }
        }

        const exampleCarousel = new Carousel(galleryContainer, galleryItems, galleryControls);
        exampleCarousel.setControls();
        exampleCarousel.useControls();
    </script>
</body>
</html>
