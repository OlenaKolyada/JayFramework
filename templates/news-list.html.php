<h1>News list</h1>
<?php
    foreach ($list as $news) {
        echo '<div>';
        echo '<h2>' . $news->getTitle() . '</h2>';
        echo '<p>' . $news->getContent() . '</p>';
        echo '</div>';
    }
?>
