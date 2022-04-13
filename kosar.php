<?php
    session_start();
    $database_name = "belepes";
    $con = mysqli_connect("localhost","root","asd",$database_name);

    if (isset($_POST["add"])){
        if (isset($_SESSION["kosar"])){
            $item_array_id = array_column($_SESSION["kosar"],"etlap_id");
            if (!in_array($_GET["id"],$item_array_id)){
                $count = count($_SESSION["kosar"]);
                $item_array = array(
                    'etlap_id' => $_GET["id"],
                    'item_nev' => $_POST["hidden_nev"],
                    'etlap_ar' => $_POST["hidden_ar"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["kosar"][$count] = $item_array;
                echo '<script>window.location="etlap.php"</script>';
            }else{
                echo '<script>alert("Az étel már hozzá van adva a kosarba!")</script>';
                echo '<script>window.location="etlap.php"</script>';
            }
        }else{
            $item_array = array(
                'termek_id' => $_GET["id"],
                'item_nev' => $_POST["hidden_nev"],
                'termek_ar' => $_POST["hidden_ar"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["kosar"][0] = $item_array;
        }
    }

    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["kosar"] as $keys => $value){
                if ($value["termek_id"] == $_GET["id"]){
                    unset($_SESSION["kosar"][$keys]);
                    echo '<script>alert("Az ételt eltávolították...!")</script>';
                    echo '<script>window.location="etlap.php"</script>';
                }
            }
        }
    }
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Titillium+Web');

        *{
            font-family: 'Titillium Web', sans-serif;
        }
        .product{
            border: 1px solid #eaeaec;
            margin: -1px 19px 3px -1px;
            padding: 10px;
            text-align: center;
            background-color: #efefef;
        }
        table, th, tr{
            text-align: center;
        }
        .title2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
        h2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
        table th{
            background-color: #efefef;
        }
    </style>
</head>
<body>

    <div class="container" style="width: 65%">
        <h2>Étlap Kosár</h2>
        <?php
            $query = "SELECT * FROM etlap ORDER BY id ASC ";
            $result = mysqli_query($con,$query);
            if(mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {

                    ?>
                    <div class="col-md-3">

                        <form method="post" action="etlap.php?action=add&id=<?php echo $row["id"]; ?>">

                            <div class="etlap">
                                <h5 class="text-info"><?php echo $row["kategoria"]; ?></h5>
                                <h5 class="text-info"><?php echo $row["nev"]; ?></h5>
                                <h5 class="text-danger"><?php echo $row["ar"]; ?></h5>
                                <input type="text" name="quantity" class="form-control" value="1">
                                <input type="hidden" name="hidden_name" value="<?php echo $row["kategoria"]; ?>">
                                <input type="hidden" name="hidden_price" value="<?php echo $row["ar"]; ?>">
                                <input type="submit" name="add" style="margin-top: 5px;" class="btn btn-success"
                                       value="Kosárba">
                            </div>
                        </form>
                    </div>
                    <?php
                }
            }
        ?>

        <div style="clear: both"></div>
        <h3 class="title2">A bevásárlókosár adatai</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
            <tr>
                <th width="30%">Étel Neve</th>
                <th width="10%">Mennyiség</th>
                <th width="13%">Részletezés</th>
                <th width="10%">Teljes Ár</th>
                <th width="17%">Elem eltávolítása</th>
            </tr>

            <?php
                if(!empty($_SESSION["kosar"])){
                    $total = 0;
                    foreach ($_SESSION["kosar"] as $key => $value) {
                        ?>
                        <tr>
                            <td><?php echo $value["termek_neve"]; ?></td>
                            <td><?php echo $value["item_quantity"]; ?></td>
                            <td>$ <?php echo $value["termek_ar"]; ?></td>
                            <td>
                                $ <?php echo number_format($value["item_quantity"] * $value["termek_ar"], 2); ?></td>
                            <td><a href="etlap.php?action=delete&id=<?php echo $value["termek_id"]; ?>"><span
                                        class="text-danger">Termék eltávolítása</span></a></td>

                        </tr>
                        <?php
                        $total = $total + ($value["item_quantity"] * $value["termek_ar"]);
                    }
                        ?>
                        <tr>
                            <td colspan="3" align="right">Total</td>
                            <th align="right">$ <?php echo number_format($total, 2); ?></th>
                            <td></td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
        </div>

    </div>


</body>
</html>