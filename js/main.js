var data = null;
var genre, timer_elements, time, timeout_var;
var initial_content = document.getElementById("content").innerHTML;

window.onload = firstRun();

function firstRun() {
    var hide_elms = [];
    hide_elms.push(document.getElementById("player_controls"));
    hide_elms.push(document.getElementById("player_song_meta"));
    hide_elms.push(document.getElementById("information_meta"));
    hide_elms.push(document.getElementById("information_image"));
    for (var x of document.getElementById("content").children)
        hide_elms.push(x);
    console.log("I Ran");
    if (!data) {
        console.log("it is null");
        for (var x of hide_elms) {
            x.setAttribute("hidden", "");
        }
    }
    (document.getElementById("initial_content") !== null) ?
    document.getElementById("initial_content").removeAttribute("hidden"): console.log();
    document.getElementById("information_genres").removeAttribute("hidden");
    document.getElementById("player_inital_info").removeAttribute("hidden");
    document.getElementById("user_panel").removeAttribute("hidden");
    document.getElementById("playlist_panel").removeAttribute("hidden");
}

function setGenre(input) {
    genre = input;
    document.getElementById("information_genres").setAttribute("hidden", "");
    var http_req = new XMLHttpRequest();
    http_req.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("content").innerHTML = this.responseText;
        }
    };
    http_req.open("GET", "includes/query.php?genre=" + genre, true);
    http_req.send();
    document.getElementById("player_inital_info").setAttribute("hidden", "");
}

function showPlayerControls() {
    if (!data) {
        console.log("BRO I AM HERE");
        var hide_elms = ["player_controls", "player_song_meta", "information_meta", "information_image"];
        for (var x of hide_elms) {
            document.getElementById(x).removeAttribute("hidden");
        }
    }
}

function playSelected(id) {
    var http_req = new XMLHttpRequest();
    http_req.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            data = JSON.parse(this.responseText);
            // var uri = "http://localhost/DaMn-Music/";
            // Set Fallback Image if no image available
            if (data.image == "none") {
                data.image = "fallback.gif";
                data.images_path = "resources/";
            }
            // Set Image in Player Panel
            document.getElementById("player_song_img").setAttribute("src", data["images_path"] + data["image"]);
            // Set Time in Player Controls
            timer_elements = document.getElementById("player_timer").children;
            timer_elements[2].innerHTML = ((data.length == "none") ? data.length : data.length.substring(3));
            // Set Source for audio tag
            document.getElementById("player_source").setAttribute("src", data["file_path"] + data["filename"]);
            // Set Meta Data in Player Panel
            document.getElementById("player_song_name").innerHTML = data["name"];
            document.getElementById("player_song_movie_name").innerHTML = data["movie"];
            // Remove Attribute src if no sound available
            if (data.filename == "none") {
                document.getElementById("player_source").removeAttribute("src");
            }
            // Set Meta Data in Info. Panel
            document.getElementById("information_image").children[0].setAttribute("src", data["images_path"] + data["image"]);
            var nodes = document.getElementById("information_meta").children;
            nodes[0].innerHTML = "name" + " : " + data.name;
            nodes[1].innerHTML = "singer" + " : " + data.singer;
            nodes[2].innerHTML = "lyricist" + " : " + data.lyricist;
            nodes[3].innerHTML = "movie" + " : " + data.movie;
            nodes[4].innerHTML = "length" + " : " + ((data.length == "none") ? data.length : data.length.substring(3));
            console.log(nodes[4].innerHTML);
        }
    };
    http_req.open("GET", "includes/query.php?genreid=" + genre.substr(-2) + "&id=" + id, true);
    http_req.send();
}

function switchPlayPause(state) {
    var play = document.getElementsByName("play")[0];
    var pause = document.getElementsByName("pause")[0];
    if (state == "play") {
        play.style.display = "none";
        pause.style.display = "inline";
    }
    if (state == "pause") {
        pause.style.display = "none";
        play.style.display = "inline";
    }
}

function playControl() {
    var audio = document.getElementById('player_source');
    if (audio.paused) {
        audio.play();
        switchPlayPause("play");
        time = parseInt(((data["length"] == "none") ? "00" : data["length"].substring(6)));
        timeout_var = setTimeout(timer, 1000);
        setTimeout(function() {
            switchPlayPause("pause");
            document.getElementById("player_progress").value = 0;
        }, time * 1000 + 500);
    } else {
        audio.pause();
        clearTimeout(timeout_var);
        timer_elements[0].innerHTML = "00:00";
        audio.currentTime = 0;
        document.getElementById("player_progress").value = 0;
        switchPlayPause("pause");
    }
}

function stopControl(audio) {
    audio.pause();
    clearTimeout(timeout_var);
    timer_elements[0].innerHTML = "00:00";
    audio.currentTime = 0;
    document.getElementById("player_progress").value = 0;
    switchPlayPause("pause");
    data = null;
    firstRun();
    document.getElementById("information_genres").removeAttribute("hidden");
    document.getElementById("content").innerHTML = initial_content;
    document.getElementById("initial_content").removeAttribute("hidden");
}

function timer() {
    var text = timer_elements[0].innerHTML;
    var time_str = text.split(":");
    var sec = parseInt(time_str[0]) * 60 + parseInt(time_str[1]) + 1;
    var minval = parseInt(sec / 60);
    var secval = sec % 60;
    var time_disp = ((minval < 10) ? "0" + minval : minval) + ":" + ((secval < 10) ? "0" + secval : secval);
    timer_elements[0].innerHTML = time_disp;
    (time) ? document.getElementById("player_progress").value = (sec / time * 100): console.log("nothing");
    if (sec < time) {
        timeout_var = setTimeout(timer, 1000);
    } else {
        timer_elements[0].innerHTML = "00:00";
    }
}

function register() {
    var formeles = ["name", "email", "password", "cpassword"];
    var formdata = [];
    for (var x of formeles) {
        formdata.push(document.getElementById(x).value);
        document.getElementById(x).value = "";
    }
    // console.log(formdata);
    var http_req = new XMLHttpRequest();
    http_req.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    };
    http_req.open("POST", "includes/query.php", true);
    http_req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var postr = "";
    for (var i = 0; i < formeles.length; i++) {
        postr += formeles[i] + "=" + formdata[i] + "&";
    }
    http_req.send(postr.slice(0, -1));
}
