<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <script src="caroselScript.js" defer></script>

</head>
<body>
    <style>
body{
    background-color: rgba(19, 18, 18, 1);
}
.container{
    display: grid;
    grid-template-columns: auto auto auto auto auto auto;
    background-color: rgba(41, 41, 41, 1);
    /* text-align: center;     */
}
.item{
    /* outline: auto; */
}
#logo{
    height: 48px;
    width: 200px;
    background-image: url(pictures/MangaVerse.png);
    background-size: 200px;
    background-repeat: no-repeat;
    background-position: center;
    margin-left: 10px;
    
    
}
.header{
    /* header */
    grid-column: 1 / 7;
    height: 50px;
    background-color: rgba(19, 18, 18, 1);
    display: flex;
    justify-content: space-between;
    /* align-content: center; */

}
.header button {
  width: 43px;
  height: 43px;
  border: none;
  background: none;
  color: white;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}
.header button:hover {
  background-color: rgba(239, 191, 4, 1);
  border-radius: 5px;
}
.material-symbols-outlined {
  font-size: 28px;
}
.search-bar {
  display: flex;
  align-items: center;
  background-color: #4a4a4a; /* dark gray */
  border-radius: 10px;
  overflow: hidden;
  width: 400px; /* adjust width as you like */
  height: 40px;
}

.search-bar input {
  flex: 1;
  border: none;
  background: transparent;
  color: white;
  padding: 0 10px;
  outline: none;
  font-size: 16px;
}

.search-bar button {
  background-color: #efbf04; /* yellow */
  border: none;
  width: 45px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.search-bar button:hover {
  background-color: #d4a703; /* darker yellow on hover */
}

.search-bar .material-symbols-outlined {
  color: white;
  font-size: 24px;
}

.carosel{
    /* recomendation picture 1 */
    grid-column: 1 / 4;
    height: 300px;
    margin-top: 15px;
    margin-bottom: 15px;
    background-size: cover;
    background-repeat: no-repeat;
    background-image: url(pictures/Best-Shonen-Mangas-Recommendations.jpg);
    margin-left: 5px;
}
.caroselp2{
    /* recomendation picture 2 */
    grid-column: 4/7;
    margin-top: 15px;
    margin-bottom: 15px;
    background-image: url(pictures/C20241210.webp);
    background-size: cover;
    background-repeat: no-repeat;
    margin-right: 5px;
}
.item3top{
    /* Latest chapter top */
    grid-column: 1/6;
    height: 40px;
    background-color: rgba(239, 191, 4, 1);
    margin-left: 5px;
    margin-right: 5px;
    align-content: center;
}
.item3{
    /* latest chapter Body */
    grid-column: 1 / 6;
    height: 1100px;
    background-color: rgba(64, 64, 64, 1);
    margin-left: 5px;
    margin-right: 5px;
    grid-template-columns: auto auto auto;
}
.item5{
    /* latest chapter Bottom */
    grid-column: 1/6;
    height: 40px;
    background-color: rgba(19, 18, 18, 1);
        margin-left: 5px;
    margin-right: 5px;
}
.item4{
    /* top10 body */
    grid-column: 6 / 7;
    height: 1100px;
    margin-left: 5px;
    background-color: rgba(64, 64, 64, 1);
    margin-right: 5px;
}
.recommendationsTop{
    /* top10 top */
    grid-column: 6/7;
    height: 40px;
    background-color: rgba(239, 191, 4, 1);
    margin-left: 5px;
    margin-right: 5px;
    align-content: center;
}

.item6{
    /* top10 bottom */
    grid-column: 6/7;
    margin-left: 5px;
    margin-right: 5px;
    height: 40px;
    background-color: rgba(19, 18, 18, 1);
}
.latestMain{
    display: grid;
    grid-template-columns: 32% 32% 32%;
    grid-template-rows: auto auto auto auto auto;
    column-gap: 10px;
    row-gap: 10px;
    padding: 8px;
}
.content{
    background-color: black;
    display: flex;


}
.picture{
    /* background-color: whitesmoke;
    align-content: flex-start;
    width: 200px; */

}
.material-symbols-outlined {
  font-variation-settings:
  'FILL' 1,
  'wght' 700,
  'GRAD' 200,
  'opsz' 48
}
.carosel {
  grid-column: 1 / 7;
  position: relative;
  height: 390px;
  margin: 15px 5px;
  overflow: hidden;
  border-radius: 5px;
  /* margin-left: 20px;
  margin-right: 20px; */
}

.slides {
  display: flex;
  height: 100%;
  transition: transform 1s ease;
}

.slides img {
  flex: 0 0 50%; /* two images per view */
  width: 50%;
  height: 100%;
  object-fit: cover;
}



/* Animation: slides to the next pair of images */
@keyframes slideDouble {
  0% { transform: translateX(0%); }
  45% { transform: translateX(0%); }
  50% { transform: translateX(-100%); }
  95% { transform: translateX(-100%); }
  100% { transform: translateX(0%); }
}


 </style>
    <div class="container">
                <div class="item header">
                        <div id="logo"></div>

                            <div class="search-bar">
                            <input type="text" placeholder="Search...">
                            <button><span class="material-symbols-outlined">search</span></button>
                        </div>

                        <button><span class="material-symbols-outlined">menu</span></button>
                </div>
                        <div class="item carosel">
                        <div class="slides">
                            <img src="pictures/Best-Shonen-Mangas-Recommendations.jpg" alt="Slide 1">
                            <img src="pictures/C20241210.webp" alt="Slide 2">
                            <img src="pictures/123123.jpg" alt="Slide 3">
                            <img src="pictures/3307142.jpg" alt="Slide 4">
                            <img src="pictures/OIP.webp" alt="Slide 5">
                            <img src="pictures/underrated-shounen-manga.avif" alt="Slide 6">
                        </div>
                        </div>



        <div class="item item3top">  Latest Chapter</div>
        <div class="item recommendationsTop">Recommendations</div>

                <div class="item item3 latestMain">
                    <div class="content">
                        <div class="picture"> </div>
                        <div class="title"></div>
                        <div class="tags"></div>
                        <div class="status"></div>
                    </div>



                    <div class="content">C2</div>
                    <div class="content">C3</div>
                    <div class="content">C4</div>
                    <div class="content">C5</div>
                    <div class="content">C6</div>
                    <div class="content">C7</div>
                    <div class="content">C8</div>
                    <div class="content">C9</div>
                    <div class="content">C10</div>
                    <div class="content">C11</div>
                    <div class="content">C12</div>
                    <div class="content">C13</div>
                    <div class="content">C14</div>
                    <div class="content">C15</div>
                </div>
        
        <div class="item item4">4</div>
        <div class="item item5">5</div>
        <div class="item item6">6</div>
    </div>

</body>
</html>
