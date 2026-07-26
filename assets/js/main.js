const containers = document.querySelectorAll('.container-plate');
let imgs = {
    1: "bricks.png",
    2: "pipes.png",
    3: "house.png",
    4: "garage.png",
    5: "roof.png",
    6: "fireplace.png",
    7: "grill.png"
};

for (let i = 0; i < containers.length; i++) {
    
    if (imgs[containers[i].dataset.template]) {
        containers[i].children[0].src = '/assets/img/' + imgs[containers[i].dataset.template];
    }
    

}