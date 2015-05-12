<!DOCTYPE html>
<?php
$home = Yii::app()->homeUrl;
$base = Yii::app()->request->baseUrl;
$user = Yii::app()->user->id;
?>
<?php // Yii::app()->bootstrap->register(); ?>
<html lang="en">
    <?php include 'head.php'; ?>
    <body>
        <?php include 'banner.php'; ?>
        <div>
            <div class="container">
                <div class="row">
                    <div id="mainSection" class="well col-sm-12">
                        <div id="content">
                            <?php
                            foreach (Yii::app()->user->getFlashes() as $key => $message) {
                                echo '<div class="flash-' . $key . ' flash-effect">' . $message . '</div>';
                            }
                            echo $content;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ajax-loader"></div>
        </div>
        <?php include 'footer.php'; ?>
        <script>
            $(document).ready(function() {
                $(".flash-effect").animate({opacity: 1.0}, 3000).fadeOut("slow");
                $("body").on({
                    ajaxStart: function() {
                        $(this).addClass("loading");
                    },
                    ajaxStop: function() {
                        $(this).removeClass("loading");
                    }
                });
            });
        </script>
    </body>
</html>
