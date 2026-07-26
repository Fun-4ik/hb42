const modalLink = document.getElementById('linkModal');
const openBtn = document.getElementById('openModalBtn');
const modalRating = document.getElementById('ratingModal');
const openRatingBtn = document.getElementById('openRatingBtn');


openBtn.addEventListener('click', () => {
    modalLink.showModal();
});

openRatingBtn.addEventListener('click', ()=>{
    modalRating.showModal();
})