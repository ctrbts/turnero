<?php

$findparam = strpos(current_url(), '?');

$url = "";
if ($findparam > -1) {
    $url = current_url() . "&page=";
}

if ($findparam = -1) {
    $url = current_url() . "?page=";
}


if (isset($totalofpages)) {
    if ($totalofpages > 0) {
?>
        <div class="p-2">
            <?php if ($actualpage > 1) { ?>
                <a href="<?php echo $url . ($actualpage - 1) ?>">
                    << /a>
                    <?php } ?>
                    <?php
                    for ($page = 1; $page <= $totalofpages; $page++) {
                        if ($actualpage == $page) {
                    ?>
                            <a class="pr-1"><?php echo $page ?> </a>
                        <?php } else { ?>
                            <a href="<?php echo $url . $page ?>"><?php echo $page ?></a> &nbsp;
                    <?php
                        }
                    }
                    ?>
                    <?php if ($actualpage < $totalofpages) { ?>
                        <a class="p-2" href="<?php echo $url . ($actualpage + 1) ?>">></a>
                    <?php } ?>
        </div>
<?php
    }
}
function current_url()
{

    $url      = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $findparameter = strpos($url, "?page=");
    $findparameteradded = strpos($url, "&page=");

    if ($findparameter > -1) {
        $url = substr($url, 0, $findparameter);
    }

    if ($findparameteradded > -1) {
        $url = substr($url, 0, $findparameteradded);
    }

    return $url;
}

?>