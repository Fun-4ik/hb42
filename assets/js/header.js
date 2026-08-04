const bonusModal = document.getElementById('bonusModal');
const openBonusBtn = document.querySelectorAll('#btnBonus');

const burgerMenu = document.getElementById("burgerMenu");
const btnburgerMenu = document.querySelector(".mobile-main-menu");
const overlay = document.querySelector(".modal-overlay");

openBonusBtn.forEach(btn => {
    btn.addEventListener('click', () => {
    bonusModal.showModal();
    document.activeElement.blur();
    closeBurgerMenu();
});
});

btnburgerMenu.addEventListener("click", ()=>{
    overlay.classList.add("modal-overlay-show");
    burgerMenu.show();
    document.activeElement.blur();
});

bonusModal.addEventListener('click', (e) => {
    if (e.target === bonusModal) {
        bonusModal.close();
    }
});

document.addEventListener('click', (e) => {
    if (!burgerMenu.contains(e.target) && burgerMenu.hasAttribute('open') && !btnburgerMenu.contains(e.target)) {
        closeBurgerMenu();
    }
});

function closeBurgerMenu(){
    overlay.classList.remove("modal-overlay-show");
    burgerMenu.close();
}