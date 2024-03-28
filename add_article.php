<link rel="stylesheet" href="./Css/addform.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="css/addproductt.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script type="text/javascript" src="scripts/ckeditor/ckeditor.js"></script>



<?php
include_once("connection.php");
function bind_Contribution($conn)
{
  $sqlstring = "SELECT ContributionID, Title FROM contributions";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='contributions'>
            <option value ='0'>choose contributions</option>";
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<option value='" . $row['ContributionID'] . "'>" . $row['Title'] . "</option>";
  }
  echo "</select>";
}

function bind_Closure($conn)
{
  $sqlstring = "SELECT idC, Closuredate, FinalClosuredate  FROM closure";
  $result = mysqli_query($conn, $sqlstring);
  echo "<select name='closure'>
            <option value ='0'>choose closure</option>";
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<option value='" . $row['idC'] . "'>" . $row['Closuredate'] ." to ". $row['FinalClosuredate'] ."</option>";
  }
  echo "</select>";
}



if (isset($_POST["btnAdd"])) {

  $contri = $_POST["contributions"];
  $aca = $_POST["txtYear"];
  $content = $_POST["txtcontent"];
  $closure = $_POST["closure"];
  $err = "";

  if ($err != "") {
    echo "<ul>$err</ul>";
  } else {

      $sqlstring = "INSERT INTO magazine(ContributionID, AcaYear, PublicationDate, ContentM, idC ) 
      VALUES ('$contri', '$aca', current_timestamp(),'$content', '$closure')";
      mysqli_query($conn, $sqlstring);
      echo '<meta http-equiv="refresh" content="0;URL=?page=article"/>';
    } 
  }

// }
?>



<div class="container1">
  <h1>Please enter Article</h1>
  <form action="" method="post">

    <div class="row">
      <label for="" class="col-25">Contribution </label>
      <div class="col-75">
        <?php bind_Contribution($conn); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        <label for="aca">Acadamic Year</label>
      </div>
      <div class="col-75">
        <input type="text" id="txtYear" name="txtYear" placeholder="">
      </div>
    </div>
    <div class="mb-3">
      <label for="txtcontent" class="form-label">Enter Your Content</label>
      <textarea class="form-control" name="txtcontent" id="txtcontent" rows="3"></textarea>
    </div>
    <div class="row">
      <label for="" class="col-25">Closure date </label>
      <div class="col-sm-8">
        <?php bind_Closure($conn); ?>
      </div>
    </div>


    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-8">
        <input class="btnupdatePro" type="submit" class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new" style="font-size: 20px;margin-top: 5px;border-radius: 10px;margin-left: 50px;background: #F7E4E0;color: #C51162;font-family: fangsong; font-weight: bold;" />
        <input class="btnupdatePro" type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=article	'" style="font-size: 20px;margin-top: 5px;border-radius: 10px;margin-left: 50px;background: #F7E4E0;color: #C51162;font-family: fangsong; font-weight: bold;" />

      </div>
    </div>
  </form>
</div>