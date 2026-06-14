gsap.registerPlugin(ScrollTrigger);

/* HERO */

if(document.querySelector(".hero-content")){

    gsap.from(".hero-content",{
        y:100,
        opacity:0,
        duration:1,
        ease:"power4.out"
    });

}

if(document.querySelector(".hero-visual")){

    gsap.from(".hero-visual",{
        scale:0.8,
        opacity:0,
        duration:1.2,
        ease:"power4.out"
    });

}

/* MODULES */

if(document.querySelector(".module-card")){

    gsap.from(".module-card",{

        scrollTrigger:{
            trigger:".modules-grid",
            start:"top 80%"
        },

        y:80,
        opacity:0,
        stagger:0.15,
        duration:1,
        immediateRender: false,
        ease:"power4.out"
    });

}

/* SOFTWARE */

if(document.querySelector(".software-card")){

    gsap.from(".software-card",{

        scrollTrigger:{
            trigger:".catalog-grid",
            start:"top 80%"
        },

        y:100,
        opacity:0,
        stagger:0.2,
        duration:1,
        immediateRender: false,
        ease:"power4.out"
    });

}

/* DASHBOARD */

if(document.querySelector(".dashboard-card")){

    gsap.from(".dashboard-card",{

        scrollTrigger:{
            trigger:".dashboard-grid",
            start:"top 80%"
        },

        y:80,
        opacity:0,
        stagger:0.2,
        duration:1,
        immediateRender: false
    });

}

/* NLP */

if(document.querySelector(".nlp-box")){

    gsap.from(".nlp-box",{

        scrollTrigger:{
            trigger:".nlp-box",
            start:"top 80%"
        },

        scale:0.9,
        opacity:0,
        duration:1,
        immediateRender: false
    });

}

/* FORUM */

if(document.querySelector(".comment-card")){

    gsap.from(".comment-card",{

        scrollTrigger:{
            trigger:".forum-grid",
            start:"top 80%"
        },

        y:80,
        opacity:0,
        stagger:0.2,
        duration:1,
        immediateRender: false
    });

}