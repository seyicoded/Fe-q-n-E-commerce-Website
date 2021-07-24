<!doctype html>
<html>
<body>
<link rel="stylesheet" href="template/lib/w3.css">

<table class="w3-table w3-bordered w3-striped w3-border w3-hoverable" style="width:100%;">
    <thead>
        <tr>
            <th>PRODUCT</th>
            <th>PRICE</th>
        </tr>
    </thead>
    <tbody>
    <?php
        include("include/connectdb.php");
        $p = new db();
        $con = $p->con();

        $sql = mysqli_query($con,"SELECT * FROM product");
        while($r = mysqli_fetch_assoc($sql)){
            ?>
                <tr>                
                    <td><?php echo $r['p_name'];?></td>
                    <td>₦<?php echo $r['p_price'];?></td>
                </tr>
            <?php
        }
    ?>
    </tbody>
</table>



</body>
</html>
