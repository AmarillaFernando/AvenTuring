if(document.querySelector(".particle")){

    gsap.to(".particle",{

        y:-30,
        duration:2,
        stagger:0.2,
        repeat:-1,
        yoyo:true,
        ease:"sine.inOut"

    });

}

if(document.querySelector(".floating-card")){

    gsap.to(".floating-card",{

        y:-20,
        duration:3,
        stagger:0.3,
        repeat:-1,
        yoyo:true,
        ease:"sine.inOut"

    });

}