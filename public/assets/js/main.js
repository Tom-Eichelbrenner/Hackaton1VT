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
    var audio = new Audio('/assets/sounds/pigeon.mp3');
    audio.play();
}