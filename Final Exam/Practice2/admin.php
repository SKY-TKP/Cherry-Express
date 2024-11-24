<!DOCTYPE html>
<html>
<head>
  <title>หน้าผู้บริหาร</title>
  <link rel="stylesheet" href="style.css"> 
</head>
<body>
  <h1>หน้าผู้บริหาร</h1>

  <h2>รายชื่อโฆษณา</h2>
  <div id="ad_list">
    <?php include 'get_ad_list.php'; ?> 
  </div>

  <h2>รายชื่อเอเจนซี่</h2>
  <div id="agency_list">
    <?php include 'get_agency_list.php'; ?>
  </div>

</body>
</html>
