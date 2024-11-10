function previewImages(event) {
    const previews = document.getElementById('image-previews');
    const files = event.target.files;
    if (files.length === 0) return;

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function (e) {
            const imageContainer = document.createElement('div');
            imageContainer.classList.add('image-container');

            const img = document.createElement('img');
            img.src = e.target.result;
            img.onclick = function () {
                imageContainer.remove();
            };

            const closeButton = document.createElement('span');
            closeButton.textContent = '×';
            closeButton.classList.add('close-button');

            closeButton.onclick = function () {
                imageContainer.remove();
            };

            imageContainer.appendChild(img);
            imageContainer.appendChild(closeButton);
            previews.appendChild(imageContainer);
        };

        reader.readAsDataURL(file);
    }
}
