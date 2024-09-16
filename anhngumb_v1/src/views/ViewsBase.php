<?php

namespace Views;

class ViewsBase
{
    protected $title = "Document";
    protected $arrCSS = [];
    protected $arrJS = [];

    function renderCSS(){
        foreach($this->arrCSS as $css){
            ?>
            <link rel="stylesheet" href="<?= $css ?>">
            <?php
        }
    }

    function renderJS(){
        foreach($this->arrJS as $js){
            ?>
            <script src="<?= $js ?>"></script>
            <?php
        }
    }

    function renderBody(){
        
    }

    function render()
    {
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <base href="<?= WEB_ROOT ?>">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
            <title><?= $this->title ?></title>
            <?= $this->renderCSS() ?>
        </head>
        <body>
            <?= $this->renderBody() ?>
            <?= $this->renderJS() ?>
        </body>
        </html>
<?php
    }
}

?>