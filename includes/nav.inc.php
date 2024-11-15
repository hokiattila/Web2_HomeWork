<?php
class Menu {
    public static array $menu = array();

    public static function setMenu(): void {
        self::$menu = array();
        $connection = Database::getConnection();
        $stmt = $connection->query("USE ".DATABASE);
        $stmt = $connection->query("SELECT url, page, permission FROM pages WHERE permission LIKE '".$_SESSION['userlevel']."'ORDER BY sortingorder");
        while($menuitem = $stmt->fetch(PDO::FETCH_ASSOC)) {
            self::$menu[$menuitem['url']] = array($menuitem['page'], $menuitem['permission']);
        }
    }

    public static function getMenu($sItems) : string {
        $menu = "<div class=\"navbar\">" . "<div class=\"logo\"><a href=\"/ottakocsid/home\"><img src=\"" ."/ottakocsid/".IMG."logo.png\"" . " alt=\"Logó\"></a></div>";
        $menu .= "<div class =\"menu\">";
        foreach(self::$menu as $menuindex => $menuitem) {
                $menu.= "<a href='/ottakocsid/".$menuindex."' ".($menuindex==$sItems[0]? "class='activenav'":"").">".$menuitem[0]."</a>";
        }
        $menu .= "</div></div>";
        return $menu;
    }
}

Menu::setMenu();