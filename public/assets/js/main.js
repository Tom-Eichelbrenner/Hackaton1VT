function pigeonLeave()
{
    gsap.to(".pigeon", { duration: 2.5, ease: "expo.out", y: -1000, x:1200 });
    document.getElementById("questionpigeon").style.display = "block";
}
function pigeonBack()
{
    gsap.to(".pigeon", { duration: 1.5, ease: "expo.out", y: 50, x:-170 });
}