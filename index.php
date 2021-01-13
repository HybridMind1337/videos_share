<?php
include("./includes/config.php");
include("./includes/phpBB.php");
include("./includes/funcs.php");
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<div class="container mt-5">
    <?php
    $getall = mysqli_query($conn, "SELECT * FROM videos WHERE approved = 1");
    while ($row = mysqli_fetch_assoc($getall)) {
        $getcat = mysqli_query($conn, "SELECT * FROM video_categories WHERE id = ". $row['cat']);
        $catrow = mysqli_fetch_assoc($getcat);
        $userinfo = userbyid($row['user_id']);
        $embed = explode("watch?v=", $row['url']);
        $imgy = "http://i3.ytimg.com/vi/$embed[1]/maxresdefault.jpg";
        ?>
        <div class="card">
            <div class="card-header"><?php echo $row['title']; ?></div>
            <div class="card-body">
                <a href="view.php?id=<?php echo $row['id']; ?>"><img src="<?php echo $imgy; ?>" style="width: 100%" alt="" /></a>
            </div>
        </div>

    <?php } ?>


