function redirectToMainPage() {
    var countdown = 3; 

    var countdownInterval = setInterval(function() {
        if (countdown <= 0) {
            clearInterval(countdownInterval);
            window.location.href = "../index.php";
        } else {
            document.getElementById("countdown").innerText = countdown;
            countdown--;
        }
    }, 1000); 
}

document.addEventListener("DOMContentLoaded", function() {
    let anim_obj = document.querySelector('.img-ball');
    if(anim_obj){
        runAnim(anim_obj, {
        fps: 25,
        x_start: 70,
        x_end: 0,
        acceleration: 2,
        duration: 1000
    });
    }
});

function runAnim(obj, data) {
    let fpsdelay = 1000 / data.fps;
    let from = data.x_start; // Change to x_start
    let to = data.x_end;     // Change to x_end
    let acceleration = data.acceleration || 1; // Optional acceleration parameter
    let duration = data.duration;

    let start = new Date().getTime();

    setTimeout(function () {
        var now = new Date().getTime() - start;
        var progress = now / duration;

        // Apply acceleration if provided
        if (acceleration !== 0) {
            progress = Math.pow(progress, acceleration);
        }

        var result = (to - from) * progress + from;

        obj.style.right = result + "px";

        if (progress < 1)
            setTimeout(arguments.callee, fpsdelay);
    }, fpsdelay);
}