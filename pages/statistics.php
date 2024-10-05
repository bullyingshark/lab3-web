<?php
include "../inc/header.php";
?>


<div class="body-center">
<br>
                    <?php
                        echo "<h3>Server Variables</h3><br>";
                        foreach ($_SERVER as $key => $value) {
                            echo "{$key}: {$value}<br>";
                        }


                        echo "<h3>GET Variables</h3>";

                        foreach ($_GET as $key => $value) {
                            echo "{$key}: {$value}<br>";
                        }


                        echo "<h3>POST Variables</h3>";

                        foreach ($formData as $key => $value) {
                            echo "{$key}: {$value}<br>";
                        }

                        foreach ($_POST as $key => $value) {
                            echo "{$key}: {$value}<br>";
                        }
                    ?>

            </div>

<?php
include "../inc/footer.php";
?>
