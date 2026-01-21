<?php
function PokazKategorieMenu($link)
{
    $sql = "SELECT * FROM categories WHERE matka = 0";
    $res = mysqli_query($link, $sql);

    echo "<ul class='categories'>";

    while ($cat = mysqli_fetch_assoc($res)) {
        echo "<li>
            <a href='index.php?idp=produkty&kat={$cat['id']}'>
                {$cat['nazwa']}
            </a>";

        // dzieci
        $sql2 = "SELECT * FROM categories WHERE matka={$cat['id']}";
        $res2 = mysqli_query($link, $sql2);

        if (mysqli_num_rows($res2)) {
            echo "<ul>";
            while ($sub = mysqli_fetch_assoc($res2)) {
                echo "<li>
                    <a href='index.php?idp=produkty&kat={$sub['id']}'>
                        {$sub['nazwa']}
                    </a>
                </li>";
            }
            echo "</ul>";
        }

        echo "</li>";
    }

    echo "</ul>";
}
?>