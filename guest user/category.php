<?php
$title_page;
ob_start();
?>

<style>
    body {
        margin: 0;
        padding: 0;
        background: #fae8f4ff;
    }

    .container {
        display:flex;
           
        gap: 20px;
        padding: 20px;
        justify-content: center;
        flex-wrap: wrap;

    }

    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 30px;
       width: 470px;
       background: #fff;
        margin: 20px;
        flex-shrink: 0;
        justify-content: space-between;
    }
   
    .card img {
        height: 400px;
        width: 400px;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
       
    }
h2{
    text-align: center;
    color:black ;
}

    .card h3 {
        margin: 20px 0 20px;
        color: #333;
    }
</style>
</head>

<body>

    <h2><u> Our Collection </u></h2>
    <div class="container">
        <div class="card">
            <img src="images/wp11.jpg" alt="Flowers">
            <h3>Flowers</h3>
            <a href="subcategory.php?cat=flowers" class="btn">View Sub Items</a>
        </div>
        <div class="card">
            <img src="images/flowergift.png" alt="Gifts">
            <h3>Flowers with Gifts</h3>
            <a href="subcategory.php?cat=gifts" class="btn">View Sub Items</a>
        </div>
        <div class="card">
            <img src="images/plants/plantimg.jpg" alt="Plants">
            <h3>Plants</h3>
            <a href="subcategory.php?cat=plants" class="btn">View Sub Items</a>
        </div>
    </div>
</body>

<?php
$content1 = ob_get_clean();
include_once("layout.php");
?>