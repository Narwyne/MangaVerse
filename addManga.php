<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>addManga</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="aPanel.css">
    <script src="sidebarScript.js" defer></script>
</head>
<body>
<style>
.aMain{
    background-color: rgba(239, 191, 4, 1);
    height: 50px;
    font-family: 'Istok Web', sans-serif;
    font-weight: bold;
    color: white;
    font-size: 30px;
}
.mmm{
    width: 200px;
    height: 40px;
    text-align: center;
    margin-top: 7px;
}
.mMain{
    height: 650px;
    background-color: rgba(19, 18, 18, 1);
    margin-top: 3px;
}
.mContent{
    background-color: rgba(111, 110, 110, 1);
    /* border: 5px solid red; */
    font-size: 25px;
}
.mContent label{
        font-size: 14px;
}
.title{

}

</style>
<div class="aPanel">

    <div class="panel aTop">
        <div id="mangaverse">Welcome to Manga<span id="verse">Verse</span> admin panel</div>
        <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
    </div>

    <div class="panel aSide">
        <button onclick="window.location.href='adminPanel.php';">Admin Panel</button> <br>
        <button disabled="disabled">Add Manga</button> <br>
        <button onclick="window.location.href='addChapter.php';">Add Chapter</button> <br>
        <button onclick="window.location.href='editManga.php';">Edit Manga</button> <br>
        <button onclick="window.location.href='deleteManga.php';">Delete Manga</button>
    </div>

    <div class="panel aMain">  
        <div class="mTop mmm">Add Manga</div>
        <div class="mMain"> 
            <div class="mContent title">Title : <input type="text"></div>
            <div class="mContent">Photo : <input type="image" src="" alt=""></div>
            <div class="mContent">Genre : 
                <input  type="checkbox" name="Action" id="action">  <label class="cbFont" for="action">Action</label>
                <input  type="checkbox" name="Adventure" id="adventure">    <label class="cbFont" for="adventure">Adventure</label>
                <input  type="checkbox" name="Comedy" id="comedy">  <label class="cbFont" for="comedy">Comedy</label>
                <input  type="checkbox" name="Drama" id="drama">    <label class="cbFont" for="drama">Drama</label>
                    <br>
                <input  type="checkbox" name="Fantasy" id="fantasy">    <label class="cbFont" for="fantasy">Fantasy</label>
                <input  type="checkbox" name="Horror" id="horror">  <label class="cbFont" for="horror">Adventure</label>
                <input  type="checkbox" name="Mystery" id="mystery">  <label class="cbFont" for="mystery">Mystery</label>
                <input  type="checkbox" name="Romance" id="romance">    <label class="cbFont" for="romance">Romance</label> 
                    <br>               
                <input  type="checkbox" name="Sci-Fi" id="sci-fi">    <label class="cbFont" for="sci-fi">Sci-Fi</label>
                <input  type="checkbox" name="Slice of Life" id="slice of life">  <label class="cbFont" for="slice of life">slice of Life</label>
                <input  type="checkbox" name="Sports" id="sports">  <label class="cbFont" for="sports">Sports</label>
                <input  type="checkbox" name="Supernatural" id="supernatural">    <label class="cbFont" for="supernatural">Supernatural</label> 
                    <br>
                <input  type="checkbox" name="Thriller" id="thriller">    <label class="cbFont" for="thriller">Thriller</label> 
            </div>

            <div class="mContent">Status :
                <input  type="checkbox" name="Ongoing" id="ongoing">    <label class="cbFont" for="ongoing">Ongoing</label>
                <input  type="checkbox" name="Completed" id="completed">    <label class="cbFont" for="completed">Completed</label>  
            </div>

            <div class="mContent">
                <button></button>
            </div>
        </div>

    </div>
     

</div>
                <!-- Sidebar (Right Side) -->
                <div class="sidebar" id="sidebar">
                    <a href="#">Profile</a>
                    <a href="#">About Us</a>
                    <a href="adminPanel.php">Admin Panel</a>
                    <a href="#" class="logout">Log Out</a>
                </div>

                <!-- Overlay -->
                <div class="overlay" id="overlay"></div>
</body>
</html>