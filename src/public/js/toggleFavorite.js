function toggleFavorite(itemId) {
    fetch(`/favorite/toggle/${itemId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            console.log('Response status:', response.status);
            if (response.status === 401) {
                return response.json();
            }
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data); 
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                const icon = document.getElementById('favorite-icon');
                icon.src = data.isFavorited
                    ? '/icon/heart_red.png'
                    : '/icon/heart_gray.png';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (error instanceof SyntaxError) {
                window.location.href = '/login';
            }
        });
}
