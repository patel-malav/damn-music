<div class="twelve columns">
    <div id = "information_image">
        <img src = "<?php echo getConfig("path", "resource") . "fallback.gif" ?>">
    </div>
    <div id = "information_meta">
        <p>Name : Fallback Name</p>
        <p>Singer : Fallback Singer</p>
        <p>Lyricist : Fallback Lyricist</p>
        <p>From : Fallback Movie Name</p>
        <p>Length : 02:45</p>
    </div>
</div>
<div class="twelve columns" id="information_genres" hidden>
    <table>
        <thead>
            <tr>
                <th>Genres</th>
            </tr>
        </thead>
        <tbody>
            <tr><td onclick="setGenre('anime00');">Anime</td></tr>
            <tr><td onclick="setGenre('blues01');">Blues</td></tr>
            <tr><td onclick="setGenre('classical02');">Classical</td></tr>
            <tr><td onclick="setGenre('country03');">Country</td></tr>
            <tr><td onclick="setGenre('disco04');">Disco</td></tr>
            <tr><td onclick="setGenre('hiphop05');">Hip Hop</td></tr>
            <tr><td onclick="setGenre('jazz06');">Jazz</td></tr>
            <tr><td onclick="setGenre('metal07');">Metal</td></tr>
            <tr><td onclick="setGenre('pop08');">Pop</td></tr>
            <tr><td onclick="setGenre('reggae09');">Reggae</td></tr>
            <tr><td onclick="setGenre('rock10');">Rock</td></tr>
        </tbody>
    </table>
</div>
