<?php
//ini_set( 'display_errors', 1 );
ob_start();//？
session_start();

include_once 'dbconnect.php';
include_once 'functions.php';

$rakuten_result = getRakutenResult('ヘアアクセサリー', 1000);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include 'header.php'; ?>
</head>

<body>
    <div class="container-fulid ">
    <?php 
    if(isset($_SESSION['users'])){
        include 'my_nav.php';
    } else{
        include 'home_nav.php'; 
    }
    include 'home_menu.php';
    ?>
    </div>

    <main role="main" class="container">
    <h2>通販</h2><br><br>

        
        <?php 
        foreach($rakuten_result as $row){ 
            
            ?>
            
                <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative" style="height:250px">
                    <div class="col-md-8 p-4 d-flex flex-column position-static ">
                        <p class="mb-0"><?php echo  $row['name']?></p>
                        <p><?php echo $row['price']; ?>円</p>
                        <p><?php echo $row['shop']; ?></p>
                        <a href='<?php echo $row['url']; ?>' target="_blank">購入はこちらから</a>
                    </div>
                    <div class="col-md-4 d-none d-lg-block">
                    <img src="<?php echo $row['img']; ?>" alt="サムネイル" 　width="100%" height="250px"><br>
                    </div>
                </div>
            
            <?php } ?>
       

       
    </main>



</body>

</html>
