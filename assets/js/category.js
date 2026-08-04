const contentItem = document.querySelectorAll('.category--content--item--title');
const contentInside = document.querySelectorAll('.category--content--inside');
const arrow = document.querySelectorAll('.category--content--item--arrow');

for (let i = 0; i < contentItem.length; i++) {
    contentItem[i].addEventListener('click', ()=>{
    arrow[i].classList.toggle('category--content--item--arrow--rotate');
    contentInside[i].classList.toggle('category--content--inside--show');
    })
            
}