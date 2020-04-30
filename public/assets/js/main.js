function pigeonLeave()
{
    var audio = new Audio('/assets/sounds/pigeon.mp3');
    audio.play();
    gsap.to(".pigeon", { duration: 2.5, ease: "expo.out", y: -1000, x:1200 });
    document.getElementById("questionpigeon").style.display = "block";
}
function pigeonBack()
{
    gsap.to(".pigeon", { duration: 1.5, ease: "expo.out", y: 50, x:-170 });
}
function percevalNav() {
    var audio = new Audio('/assets/sounds/salut_perceval.mp3');
    audio.play();
}
function marron() {
    var audio =  new Audio('/assets/sounds/quest_ce_qui_est_petit_et_marron.mp3');
    audio.play();
}
function chieDsu()
{
    var audio =  new Audio('/assets/sounds/chie_dessus.mp3');
    audio.play();
    setTimeout(function () {
        // Do something after 5 seconds
        location.reload();//reload page
    }, 2000);
}
function mortelOuais(){
    var audio =  new Audio('/assets/sounds/mortel_ouais.mp3');
    audio.play();
    setTimeout(function () {
        // Do something after 5 seconds
        location.reload();//reload page
    }, 2000);
}