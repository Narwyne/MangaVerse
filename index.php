<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
    
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
    background-image: url(MangaVerse.png);
    background-size: 200px;
    background-repeat: no-repeat;
    background-position: center;
    margin-left: 10px;
    
    
}
.item1{
    /* header */
    grid-column: 1 / 7;
    height: 50px;
    background-color: rgba(19, 18, 18, 1);
    display: flex;
    justify-content: space-between;

}
.item1 button{
    width: 43px;
    height: 43px;
    margin-right: 5px;
    margin-top: 3px;
}
.item1 input{
    
}
.item2{
    /* recomendation picture 1 */
    grid-column: 1 / 4;
    height: 300px;
    margin-top: 15px;
    margin-bottom: 15px;
    background-size: cover;
    background-repeat: no-repeat;
    background-image: url(Best-Shonen-Mangas-Recommendations.jpg);
    margin-left: 5px;
}
.item2p2{
    /* recomendation picture 2 */
    grid-column: 4/7;
    margin-top: 15px;
    margin-bottom: 15px;
    background-image: url(C20241210.webp);
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
.item4top{
    /* top10 top */
    grid-column: 6/7;
    height: 40px;
    background-color: rgba(239, 191, 4, 1);
    margin-left: 5px;
    margin-right: 5px;
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
    grid-template-columns: auto auto auto;
    grid-template-rows: auto auto auto auto auto;
    column-gap: 10px;
    row-gap: 10px;
    padding: 8px;
}
.content{
    background-color: black;
}
    </style>
    <div class="container">
        <div class="item item1">
            
            <div id="logo">
            </div>
            <input type="text"> 
            <button></button>
        </div>
        <div class="item item2">2</div>
        <div class="item item2p2">2p2</div>
        <div class="item item3top">  Latest Chapter</div>
        <div class="item item4top">4top</div>

        <div class="item item3 latestMain">
            <div class="content">C1</div>
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