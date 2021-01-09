<?php
include ("./includes/config.php");
include ("./includes/phpBB.php");
include ("./includes/funcs.php");

$ok = (int)$_GET['ok'];
$remove = (int)$_GET['remove'];

if(isset($_GET['ok'])) {
    mysqli_query($conn, "UPDATE videos SET approved = 1 WHERE id = ". $ok);
    msg("acp.php", "success", "Успешно добавен клип");
}
if(isset($_GET['remove'])) {
    mysqli_query($conn, "DELETE FROM videos WHERE id = ". $remove);
    msg("acp.php", "success", "Успешно премахнат клип");
}
// Добавяне на категория
if(isset($_POST['addcat'])) {
    $catname = mysqli_real_escape_string($conn,$_POST['catname']);
    mysqli_query($conn, "INSERT INTO video_categories (`name`) VALUES('$catname')");
    msg("acp.php", "success", "Успешно добавена категория");
}
// Изтриване на категория
if(isset($_POST['delcat'])) {
    $cat = mysqli_real_escape_string($conn,$_POST['cat']);
    mysqli_query($conn, "DELETE FROM video_categories WHERE id = ". $cat);
    msg("acp.php", "success", "Категорията е успешно премахната");
}

// Проверяваме дали потребителя е админ
if(!$bb_is_admin) {
    header('Location: index.php');
    exit();
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<div class="container mt-5">
<?php if(!$bb_is_anonymous) { ?>
<?php echo showMessage(); ?>
<div class="card mb-3">
   <div class="card-header">Видеа за одобряване</div>
   <div class="card-body">
   <?php
    $getall = mysqli_query($conn, "SELECT * FROM videos WHERE approved = 0");
    if ($getall->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($getall)) { ?>
            <form method="POST">
               Оргинален линк: <a href="<?php echo $row['url'];?>"><?php echo $row['title'];?></a>
               <a href="acp.php?ok=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Одобри</a>
               <a href="acp.php?remove=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Откажи</a>
            </form>
        <?php } } else {  ?>
        <div class="alert alert-danger">Няма клипове, които да чакат одобрение</div>
        <?php } ?>
   </div>
</div>

<div class="card mb-3">
   <div class="card-header">Добавяне на категория</div>
   <div class="card-body">
      <form method="POST">
         <div class="mb-3">
            <label class="form-label">Име на категория:</label>
            <input type="text" name="catname" placeholder="Име на категорията" class="form-control">
         </div>
         <button type="submit" name="addcat" class="btn btn-primary">Добави</button>
      </form>
   </div>
</div>

<div class="card mb-3">
   <div class="card-header">Всички добавени категории</div>
   <div class="card-body">
   <form method="POST">
            <div class="input-group mb-3">
            <label class="input-group-text">Категория</label>
            <select class="form-select" name="cat">
            <?php $getCats = mysqli_query($conn, "SELECT * FROM video_categories");
                while ($row = mysqli_fetch_assoc($getCats)) { ?>
                     <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
               <?php } ?>
            </select>
            <button type="submit" name="delcat" class="btn btn-danger">Изтрий</button>
         </div>
         </form>
   </div>
</div>
<?php } else {
    header("index.php");
    exit();
}
 deleteSession('alert');