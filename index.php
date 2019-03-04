<?php
    require_once "includes/functions.php";
    // Getting Desired Config from config.json
    $confile = fopen("config.json", "r") or die("<h1>File Not Found</h1>");
    $data = fread($confile, filesize("config.json"));
    //echo $data;
    fclose($confile);
    $obj = json_decode($data, false);
    // Handel Incomming Post Requests
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    // echo $email . " " . $password;
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title><?php echo getConfig("title");?></title>
        <link rel="icon" href="resources/favicon.png" sizes="64x64" type="image/png" sizes="16x16">
        <link rel="stylesheet" href="<?php echo getConfig("path", "css") . "skeleton.css"; ?>">
        <link rel="stylesheet" href="<?php echo getConfig("path", "css") . "normalize.css"; ?>">
        <link rel="stylesheet" href="<?php echo getConfig("path", "css") . "style.css"; ?>">
        <meta name="viewport" content="width = device-width, initial-scale = 1.0">
    </head>
    <body class="container" id="wrapper">
        <header class="row">
            <section class="twelve columns" id="player">
                <?php
                    showPlayer($email, $password);
                ?>
            </section>
        </header>
        <main class="row">
            <section class="nine columns row" id="content">
                <div class="offset-by-two nine columns" id="initial_content" hidden>
                    <h6>NOTICE ME SENPAI</h6>
                    <p>Adding Songs To Playlist is WIP login in to patelmalav74@gmail.com pass = killbill
                    <br>Registration and Login is working
                    <br>Available Genres Anime and Blues
                    <br>Blues Does not have any image or information but can play song
                    <br>Further Work Required But Devloper is Tired.. :(
                    <h2>Welcome To &quot;<span><?php echo getConfig("title");?></span>&quot;</h2>
                    <h4>
                        <?php
                            echo ($user !== "") ?
                            "<span>" . $user . "</span>&#39;s Playlist" :
                            "Register To Listen &emsp;&emsp; <span>Unlimited</span> Music For &emsp;&emsp; <span>Free</span>..";
                        ?>
                    </h4>
                    <fieldset <?php if ($user !== "") {
                            echo "hidden";
                        } ?>>
                        <legend>Register</legend>
                        <table>
                            <tbody>
                                <tr>
                                    <label for="name">Name</label>
                                    <input type="text" class="u-full-width" id="name" placeholder="Enter Name">
                                </tr>
                                <tr>
                                    <label for="email">Email</label>
                                    <input type="email" class="u-full-width" id="email" placeholder="xyz@xyzmail.com">
                                </tr>
                                <tr>
                                    <label for="password">Password</label>
                                    <input type="password" class="u-full-width" id="password" placeholder="xxxxxxxx">
                                </tr>
                                <tr>
                                    <label for="cpassword">Confirm Password</label>
                                    <input type="password" class="u-full-width" id="cpassword" placeholder="xxxxxxxx">
                                </tr>
                                <tr>
                                    <label for="term" style="margin-top:15px;">
                                    </label>
                                    <input type="checkbox" id="term"
                                        onclick="if(this.checked) {
                                            document.getElementById('submit').disabled = false;
                                            document.getElementById('submit').style.backgroundColor = '#33C3F0';
                                        }
                                        else {
                                            document.getElementById('submit').disabled = true;
                                            document.getElementById('submit').style.backgroundColor = 'grey';
                                        }">
                                    <span> Term & Condition</span>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <input type="submit" class="button-primary"
                        style="width:200px;align:center;background-color:grey;" id="submit" onclick="register();" value="Register" disabled>
                    </fieldset>
                </div>
                <div class="twelve columns" id="playlist_panel" <?php if ($user == "") {
                    echo "hidden";
                } ?>>
                <?php
                if($user !== "" && $playlist = json_decode($playlist_json,false)){
                    $metafile = fopen(getConfig("path", "data") . "meta.json", "r") or die("<h1>Meta File Not Found</h1>");
                    $metadata = fread($metafile, filesize(getConfig("path", "data") . "meta.json"));
                    fclose($metafile);
                    $metaobj = json_decode($metadata, false);
                    $count = $playlist->songs_count;
                    $list = $playlist->list;

                    $cntr = 0;
                    for ($i=0; $i < ceil($count/3); $i++) {
                        echo "<div class=\"row twelve columns random_spinner\" id=\"spinner_" . $i ."\">";
                        for ($j=0; $j < 3; $j++) {
                            if($cntr < $count)
                                genSpinnerElement($metaobj, $list[$cntr]->genre , $list[$cntr]->id);
                            $cntr++;
                        }
                        echo "</div>";
                    }
                }
                ?>
            </div>
            </section>
            <section class="three columns row" id="info">
                <?php showInfo(); ?>
            </section>
        </main>
        <footer class="row">
            <section class="twelve columns" id="foot">
                <?php showFooter(); ?>
            </section>
        </footer>
    </body>
    <script src="<?php echo getConfig("path", "js") . "main.js"; ?>"></script>
</html>
