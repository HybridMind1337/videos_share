<?php
include("./includes/config.php");
include("./includes/phpBB.php");
include("./includes/funcs.php");
if (isset($_POST['del'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    mysqli_query($conn, "DELETE FROM videos WHERE id = " . $id);
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<div class="container mt-5">
    <?php
    $getall = mysqli_query($conn, "SELECT * FROM videos WHERE approved = 1");
    if ($getall->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($getall)) {
            $getcat = mysqli_query($conn, "SELECT * FROM video_categories WHERE id = " . $row['cat']);
            $catrow = mysqli_fetch_assoc($getcat);
            $userinfo = userbyid($row['user_id']);
            $embed = explode("watch?v=", $row['url']);
            $imgy = "http://i3.ytimg.com/vi/$embed[1]/maxresdefault.jpg";
            ?>
            <div class="card">
                <div class="card-header"><?php echo $row['title']; ?></div>
                <div class="card-body">
                    <a href="view.php?id=<?php echo $row['id']; ?>"><img src="<?php echo $imgy; ?>" style="width: 100%" alt=""/></a>
                    <?php if ($bb_is_admin) { ?>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="del" class="m-1 btn btn-danger">Изтрий видеото</button>
                        </form>
                    <?php } ?>
                </div>
            </div>

        <?php }
    } else {
        echo "Няма добавени клипове";
    } ?>

