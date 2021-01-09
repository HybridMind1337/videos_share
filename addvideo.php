<?php
include ("./includes/config.php");
include ("./includes/phpBB.php");
include ("./includes/funcs.php");

if(isset($_POST['addvideo'])) {
    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $link = mysqli_real_escape_string($conn,$_POST['link']);
    $time = time();
    $cat = mysqli_real_escape_string($conn,$_POST['cat']);

    mysqli_query($conn, "INSERT INTO videos (`title`, `url`, `date`, `cat`, `approved`, `user_id`) VALUES ('$title','$link','$time','$cat','0','$bb_user_id')")or die(mysqli_error($conn));
    msg("index.php", "success", "Успешно качен клип! След преглед от администратора, той ще се покаже в сайта!");
}

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<div class="container mt-5">
<?php

if(!$bb_is_anonymous) { ?>
<div class="card">
   <div class="card-header">Качване на видео клип</div>
   <div class="card-body">
   <?php echo showMessage(); ?>
      <form method="POST">
               <div class="mb-3">
            <label class="form-label">Име:</label>
            <input type="text" name="title" placeholder="Име.." class="form-control">
         </div>
         <div class="mb-3">
            <label class="form-label">Линк към клипа:</label>
            <input type="text" name="link" placeholder="Постави пълен линк към клипа" class="form-control">
         </div>
         <div class="input-group mb-3">
            <label class="input-group-text">Категория</label>
            <select class="form-select" name="cat">
                <?php $getCats = mysqli_query($conn, "SELECT * FROM video_categories");
                while ($row = mysqli_fetch_assoc($getCats)) { ?>
                     <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
               <?php } ?>
            </select>
         </div>
         <button type="submit" name="addvideo" class="btn btn-primary">Качи</button>
      </form>
   </div>
</div>
<?php } else { ?>
    <div class="alert alert-danger">Трябва да си регистриран, за да качваш клипове</div>
<?php }
// Изтриване на съобщенията
deleteSession("alert");
