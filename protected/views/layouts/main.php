<!DOCTYPE html>
<?php
$home = Yii::app()->homeUrl;
$base = Yii::app()->request->baseUrl;
?>
<html lang="en">
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div id="content" style="padding: 19px; background-color: rgba(245, 245, 245, 0.5); border: 1px solid rgb(245, 245, 245); border-radius: 8px;">
                        <?php
                        foreach (Yii::app()->user->getFlashes() as $key => $message) {
                            echo '<div class="alert alert-' . $key . ' flash-effect" role="alert">'
                            . '<strong>' . $message . '</strong>'
                            . '</div>';
                        }
                        echo $content;
                        ?>
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
