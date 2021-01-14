<?php
include("./includes/config.php");
include("./includes/phpBB.php");
include("./includes/funcs.php");

$id = (int)$_GET['id'];

if(empty($id)) {
    header("Location: index.php");
} elseif(!is_numeric($id)) {
    header("Location: index.php");
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<div class="container mt-5">
<?php
$getvideo = mysqli_query($conn, "SELECT * FROM videos WHERE id = " . $id);
 if ($getvideo->num_rows > 0) {
while ($row = mysqli_fetch_assoc($getvideo)) {
    $getcat = mysqli_query($conn, "SELECT * FROM video_categories WHERE id = " . $row['cat']);
    $catrow = mysqli_fetch_assoc($getcat);
    $userinfo = userbyid($row['user_id']);
    $embed = explode("watch?v=", $row['url']);
    ?>
    <div class="card">
        <div class="card-header"><?php echo $row['title']; ?></div>
        <div class="card-body">
            <div class="alert alert-info text-center">
                Качен от <b style="color:#<?php echo $userinfo['user_colour']; ?>"><?php echo $userinfo['username']; ?></b>
                Добавена на <?php echo date("d.m.Y", $row['date']); ?>
                Категория: <?php echo $catrow['name']; ?>
            </div>
            <iframe style="width: 100%;height: 500px" src="https://www.youtube.com/embed/<?php echo $embed[1]; ?>"></iframe>
        </div>
    </div>

<?php } } else {
     echo "Няма такъв видео клип";
} ?>
