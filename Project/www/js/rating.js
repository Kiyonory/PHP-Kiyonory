function updateStars(articleId, userRating) {
    const stars = document.querySelectorAll(`.rating-star[data-article-id="${articleId}"]`);
    stars.forEach(star => {
        const starRating = parseInt(star.dataset.rating);
        if (starRating <= userRating) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}