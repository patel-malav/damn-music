<?php
    $id = isset($_GET["id"]) ? $_GET["id"] : "";

    $genre = isset($_GET["genre"]) ? $_GET["genre"] : "";
    $genre_id = isset($_GET["genreid"]) ? $_GET["genreid"] : "";

    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    if ($name !== "") {
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
        $cpassword = isset($_POST["cpassword"]) ? $_POST["cpassword"] : "";
    }

    require_once "functions.php";

    if ($id !== "" || $genre !== "") {
        // Getting Desired Config from config.json
        $confile = fopen("../config.json", "r") or die("<h1>File Not Found</h1>");
        $data = fread($confile, filesize("../config.json"));
        //echo $data;
        fclose($confile);
        $obj = json_decode($data, false);
        // Get Data From JSON File
        $metafile = fopen("../" .getConfig("path", "data") . "meta.json", "r") or die("<h1>Meta File Not Found</h1>");
        $metadata = fread($metafile, filesize("../" . getConfig("path", "data") . "meta.json"));
        fclose($metafile);
        $metaobj = json_decode($metadata, false);

        // Handel The Incoming HTTP GET REQUESTS
        // Handel Incomming GENRE GET Requests
        if ($genre !== "") {
            $genre_id = intval(substr($genre, -2));
            $count = getMetaData($metaobj, "genre", $genre_id, "songs_count");
            $cntr = 0;
            for ($i=0; $i < ceil($count / 3); $i++) {
                echo "<div class=\"row twelve columns random_spinner\" id=\"spinner_" . $i ."\">";
                for ($j=0; $j<3; $j++) {
                    genSpinnerElement($metaobj, $genre_id, $cntr++,true);
                }
                echo "</div>";
            }
        }
        // Handel Incomming ID GET Requests
        if ($id !== "") {
            genJsonString($metaobj, intval($genre_id), $id - 1);
        }
    }

    if ($name !== "" && $email !== "" && $password !== "" && $cpassword !== "") {
        $conn = getSqliConnection();

        if ($password == $cpassword) {
            $sql = "INSERT INTO users (name, email, password)
            VALUES ('$name', '$email', '$password')";

            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
        mysqli_close($conn);
    }
