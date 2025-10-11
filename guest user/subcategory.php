<?php
$title_page;
ob_start();

// Category parameter 
$category = isset($_GET['cat']) ? $_GET['cat'] : '';
?>

<style>
    body {
        margin: 0;
        padding: 0;
        background: #fdf2f8; /* light pinkish background */
        
    }

    .container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        padding: 30px;
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
    

    

    .card h3 {
        margin: 15px 0;
        color: #d63384;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
        color: #444;
    }
</style>

<body>

    <h2>
        <?php 
            if($category == "flowers") echo "🌸 Flowers Collection";
            elseif($category == "gifts") echo "🎁 Flowers with Gifts";
            elseif($category == "plants") echo "🌱 Plants Collection";
            else echo "Our Sub Categories";
        ?>
    </h2>

    <div class="container">
        <?php if($category == "flowers") { ?>
            <div class="card">
                <img src="images/wp16.jpg" alt="Rose">
                <h3>All Flowers</h3>
                <a href="product.php?sub=allflower" class="btn">View Products</a>
            </div>
            <div class="card">
                <img src="images/flowerbouquet.jpg" alt="Bouquets">
                <h3>Bouquets</h3>
                <a href="product.php?sub=bouquet" class="btn">View Products</a>
            </div>

        <?php } elseif($category == "gifts") { ?>
            <div class="card">
                <img src="images/flowerhamper.png" alt="Special Hampers">
                <h3>Special Hampers</h3>
                <a href="p_forhamper.php?sub=hamper" class="btn">View Products</a>
            </div>
           

        <?php } elseif($category == "plants") { ?>
            <div class="card">
                <img src="images/plants/flowerplant.jpg" alt="Money Plant">
                <h3>Indoor Plants</h3>
                <a href="p_forplant.php?sub=indoorplant" class="btn">View Products</a>
            </div>
            <div class="card">
                <img src="images/plants/outdoorfp.jpg" alt="Aloe Vera">
                <h3>Outdoor Plants</h3>
                <a href="p_forplant.php?sub=outdoorplant" class="btn">View Products</a>
            </div>
            
        <?php } ?>
    </div>
</body>

<?php
$content1 = ob_get_clean();
include_once("layout.php");
?>