<?php
function showMenu($link) {

    $sql = "SELECT page_title
            FROM page_list 
            WHERE show_in_menu = 1 AND status = 1
            ORDER BY menu_order ASC";

    $result = mysqli_query($link, $sql);

    echo '<div class="menu">';

    while ($row = mysqli_fetch_assoc($result)) {
		$title = $row['page_title'] ?? '';
        $name  = $row['page_name'] ?? '';
        echo '<a href="index.php?idp=' . $row['page_title'] . '">';
        echo htmlspecialchars($row['page_name']);
        echo '</a>';
    }

    echo '</div>';
}
?>
