function redirectToMainPage() {
    var countdown = 3; 

    var countdownInterval = setInterval(function() {
        if (countdown <= 0) {
            clearInterval(countdownInterval);
            window.location.href = "lab3.html";
        } else {
            document.getElementById("countdown").innerText = countdown;
            countdown--;
        }
    }, 1000); 
}

function form(form) {
    var name = form.name.value;
    var gender = document.querySelector('input[name="rb"]:checked').value;
    var day = parseInt(form.dd.value);
    var month = parseInt(form.mm.value);
    var year = parseInt(form.yyyy.value);

    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth() +1; 
    var currentDay = currentDate.getDate();

    var errorMessageElement = document.getElementById("errorMessage");

    if (isNaN(day) || isNaN(month) || isNaN(year)) {
        errorMessageElement.innerText = "Please enter valid numeric values for the date!";
        errorMessageElement.style.display = "block";
        return false;
    }

    errorMessageElement.style.display = "none";

    let age_year = currentYear - year;

    if( (currentMonth < month) || (currentMonth == month) && (currentDay<=day) )
    {
        age_year--;
    }

    if( (gender == "m") && (age_year>=21) || (gender == "f") && (age_year>=18) ) 
    {
        return true;
    }

    errorMessageElement.innerText = "You can't buy a ticket! You're under a certain age!";
    errorMessageElement.style.display = "block";
    return false;
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