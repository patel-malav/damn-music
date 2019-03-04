<div class="row" id="player_meta">
    <div class="four columns">
        <h2 style="cursor:pointer;" onclick="window.location.replace(window.location['origin']);"><?php echo getConfig("title");?></h2>
        <div id="user_panel" hidden>
            <h6 style="font-size:24px;margin-bottom:0px" <?php if($user == "") echo "hidden"; ?>>
                <img style="width:26px;height:24px;display:inline"
                src="<?php echo getConfig("path", "resource") . "profile.png";?>">
                <?php echo ($user !== "") ?  $user : "user"; ?>
            </h6>
            <h6 id="logout_button" <?php if($user == "") echo "hidden"; ?>
                onclick="window.location.replace(window.location['origin']);"
                >Logout
            </h6>
        </div>
    </div>
    <div class="row eight columns" id ="player_song_meta">
        <img id="player_song_img" src="<?php echo getConfig("path", "resource") . "fallback.gif"; ?>" class="three columns">
        <div class="offset-by-one eight columns">
            <div class="row">
                <h6 class="twelve columns" id="player_song_name">Fallback Name</h6>
            </div>
            <div class="row">
                <h6 class="offset-by-five seven columns">From ~
                    <span id="player_song_movie_name">Fallback Movie Name</span>
                </h6>
            </div>
        </div>
    </div>
    <div class="eight columns" id="player_inital_info" hidden>
        <h4 class="u-full-width"><?php echo ($user !== "") ? "" : "Login To"; ?> Enjoy &emsp; <span>Unlimited</span> &emsp; Music</h4>
        <form action="index.php" method="post" <?php if($user != "") echo "hidden"; ?>>
        <div class="u-full-width row">
            <div class="four columns">
                <label for="Email">Email</label>
                <input type="email" name="email" placeholder="xyz@xyzmail.com">
            </div>
            <div class="four columns">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="xxxxxxxx">
            </div>
            <input style="margin-top:25px;" type="submit" class="button-primary two columns" name="login" value="Login">
        </div>
    </form>
    </div>
</div>
<div class = "row" id = "player_controls">
    <div class="five columns">
    <input type = "image" src = "<?php echo getConfig("path", "resource") . "prev.png"; ?>" name="prev">
    <input type = "image" src = "<?php echo getConfig("path", "resource") . "play.png"; ?>" name="play" onclick="playControl();">
    <input type = "image" style="display:none" src = "<?php echo getConfig("path", "resource") . "pause.png"; ?>" name="pause" onclick="playControl();">
    <input type = "image" src = "<?php echo getConfig("path", "resource") . "next.png"; ?>" name="next">
    </div>
    <audio id = "player_source"></audio>
    <div class="six columns row" id="player_timer" style="">
        <span class="two columns" style="margin:1.8rem 4px;text-align:center;">00:00</span>
        <progress class="seven columns" style="margin:1.8rem 4px;" id = "player_progress" value="0" max="100"></progress>
        <span class="two columns" style="margin:1.8rem 4px;text-align:center;">00:00</span>
    </div>
    <input class="one columns" type = "image" src = "<?php echo getConfig("path", "resource") . "cancel.png"; ?>" name="cancel" onclick="stopControl(document.getElementById('player_source'));">
</div>
