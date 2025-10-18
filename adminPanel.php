<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>adminPanel</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="sidebar.css">
    <script src="sidebarScript.js" defer></script>
</head>
<body>
    
<style>
body{
    background-color: rgba(41, 41, 41, 1);
    margin: 0%;

}
.aPanel{
    display: grid;
    grid-template-columns: 250px auto auto auto;
}
.panel{
    /* border: 5px solid white; */
}
.aTop{
    grid-column: 1/5;
    height: 60px;
    background-color: rgba(19, 18, 18, 1);
    color: aliceblue;
    font-style: normal;
    font-size: 30px;
    display: flex;
    justify-content: space-between;
}
#mangaverse{
    width: 600px;
    margin-top: 11px;
    margin-left: 19px;
    font-family: 'Istok Web', sans-serif;
font-weight: bold;
font-size: 32px;
line-height: auto; /* You can adjust this as needed */
letter-spacing: 0%;
text-align: left; /* Adjust alignment as needed */
vertical-align: middle; /* Adjust vertical alignment if needed */
}
#verse{
    color: rgba(239, 191, 4, 1);
}
.aTop button {
  width: 43px;
  height: 43px;
  border: none;
  background: none;
  color: white;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 8px;
  margin-right: 10px;
}
.aTop button:hover {
  background-color: rgba(239, 191, 4, 1);
  border-radius: 5px;
}
.aSide{
    grid-column: 1/2;
    height: 700px;
    background-color: rgba(76, 76, 76, 1);
    justify-content: center;
}
.aSide button{
    width: 230px;
    height: 50px;
    margin-top: 6px;
    margin-left: 10px;
    font-size: 30px;
    font-weight: bold;
    background-color: rgba(239, 191, 4, 1);
    border-radius: 5px;
    color: whitesmoke;
}
.aSide button:disabled{
    background-color: black;
}
.aSide button:disabled:hover{
    background-color: black;
    cursor: default;
}
.aSide button:hover{
    cursor: pointer;
}
.aMain{
    grid-column: 2/5;
}

</style>

<div class="aPanel">

    <div class="panel aTop">
        <div id="mangaverse">Welcome to Manga<span id="verse">Verse</span> admin panel</div>
        <button id="menuBtn"><span class="material-symbols-outlined">menu</span></button>
    </div>

    <div class="panel aSide">
        <button disabled="disabled">Admin Panel</button> <br>
        <button>Add Manga</button> <br>
        <button>Add Chapter</button> <br>
        <button>Edit Manga</button> <br>
        <button>Delete Manga</button>
    </div>
    <div class="panel aMain">3</div>
     

</div>
                <!-- Sidebar (Right Side) -->
                <div class="sidebar" id="sidebar">
                    <a href="#">Profile</a>
                    <a href="#">About Us</a>
                    <a href="#">Admin Panel</a>
                    <a href="#" class="logout">Log Out</a>
                </div>

                <!-- Overlay -->
                <div class="overlay" id="overlay"></div>
</body>
</html>