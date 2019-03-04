<?php
    // In This File Every PHP Functions required for webapp are to be mentioned
    // Rules 1: Camel Case - method name
    // Rules 2: Snake Case - variable name
    // Rule 3: Try to Use Double Quote

    function getConfig($key='', $subkey='', $index=-1)
    {
        global $obj;
        if ($index > -1) {
            return $obj->$key[$index];
        } elseif ($subkey != '') {
            return $obj->$key->$subkey;
        } else {
            return $obj->$key;
        }
    }

    // Player function
    function showPlayer($value1='', $value2)
    {
        global $user;
        $user = "";
        if ($value1 !== "" && $value2 !== "") {
            $user = validateUser($value1, $value2);
        }
        require_once getConfig("path", "components") . "player.php";
    }

    // Content function
    // function showContent($value='')
    // {
    //     require_once getConfig("path", "components") . "content.php";
    // }

    // Information Panel function
    function showInfo($value='')
    {
        require_once getConfig("path", "components") . "info.php";
    }

    // Foooter funtion
    function showFooter($value='')
    {
        require_once getConfig("path", "components") . "footer.php";
    }

    // Get Song Data For A Specified Song
    function getMetaData($decoded_json, $key1, $key_index_1='', $key2='', $key_index_2='', $key3='')
    {
        if ($key_index_1 === '') {
            // echo "first";
            return $decoded_json->$key1;
        } elseif ($key_index_2 === '') {
            // echo "second";
            return $decoded_json->$key1[$key_index_1]->$key2;
        } else {
            // echo "third";
            return $decoded_json->$key1[$key_index_1]->$key2[$key_index_2]->$key3;
        }
    }

    // Display all the Song Details
    function genSpinnerElement($decoded_json='', $genre_index='', $val='',$enable='')
    {
        $configres = getConfig("path", "resource");
        $data = $decoded_json->genre[$genre_index]->list[$val];
        if ($data !== null) {
            $id = $data->id;
            $image = $data->image;
            $imagepath = $decoded_json->genre[$genre_index]->images_path . $image;
            $name = $data->name;
            $movie = $data->movie;
            if ($id < 10) {
                $id = "0" . $id;
            }
            if ($image === null) {
                $imagepath = $configres . "fallback.gif";
            }
            if ($name === null) {
                $name = "none";
            }
            if ($movie === null) {
                $movie = "none";
            }
            echo "<div class=\"spinner_ele three columns offset-by-one\" id=\"song" . $id . ">\">";
            if($enable == true){
                echo "<a onClick=\"playSelected(" . $id . ");showPlayerControls();\">";
            }
            else {
                echo "<a onClick=\"alert('WORK IN PPROGRESS --WIP--')\">";
            }
            echo "<img class=\"song_img\" src=\"" . $imagepath . "\">";
            echo "<img class=\"play_img\" src=\"" . $configres . "play.png" . "\">";
            echo "<h6 class=\"song_name\">" . $name  . "</h6>";
            echo "</a>";
            echo "<p class=\"song_desp\">" . $movie . "</p>";
            echo "</div>";
        } else {
            echo "<div class=\"spinner_ele three columns offset-by-one\" id=\"song" . ">\">";
            echo "<a onClick=\"playSelected(" . -1 . ");\">";
            echo "<img class=\"song_img\" src=\"" . $configres . "fallback.gif" . "\">";
            echo "<img class=\"play_img\" src=\"" . $configres . "play.png" . "\">";
            echo "<h6 class=\"song_name\">" . "None"  . "</h6>";
            echo "</a>";
            echo "<p class=\"song_desp\">" . "None" . "</p>";
            echo "</div>";
        }
    }

    function genJsonString($decoded_json='', $genre_index='', $val='')
    {
        $configres = getConfig("path", "resource");
        $arr = array( "images_path" => $decoded_json->genre[$genre_index]->images_path, "file_path" => $decoded_json->genre[$genre_index]->file_path);
        $data = $decoded_json->genre[$genre_index]->list[$val];
        if ($data !== null) {
            foreach ($data as $key => $value) {
                $arr[$key] = ($value != null) ? $value : "none";
            }
            echo json_encode($arr);
        } else {
            $data = $decoded_json->genre[0]->list[0];
            foreach ($data as $key => $value) {
                $arr[$key] = "none";
            }
            echo json_encode($arr);
        }
    }

    function getSqliConnection()
    {
        // Setup Database Connection...
        $servername = "localhost";
        $username = "id2398784_malav";
        $password = "500\$aaptokahu";
        $database = "id2398784_damnmusic";
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            // echo "Connected to php my admin";
        }
        return $conn;
    }

    function validateUser($value1='', $value2='')
    {
        global $playlist_json;
        $conn = getSqliConnection();
        $sql = "SELECT name, password, playlist FROM users WHERE email = '$value1'";
        if ($res = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    if ($row["password"] == $value2) {
                        $user_name = $row["name"];
                        $playlist_json = $row["playlist"];
                    } else {
                        $user_name = "USER";
                    }
                }
                mysqli_free_result($res);
            } else {
                echo "No Entries Found";
            }
        } else {
            echo "ERROR: Could not able to execute $sql. "
                            . mysqli_error($link);
        }
        mysqli_close($conn);
        return $user_name;
    }
