<?php
/**
 * Created by PhpStorm.
 * User: lrchang
 * Date: 27/07/2017
 * Time: 13:55
 */

namespace app\api\controller\v1;

use app\api\model\Theme as ThemeModel;
use app\api\validate\IDCollection;
use app\api\validate\IDPostiveInt;
use app\api\validate\ThemePager;
use app\lib\exception\ThemeMiss;
use think\Request;

class Theme
{
    /**
     * @URL /theme/:id?page=1&offset=20
     */
    public function theme($id = 0 ,$page = 1 , $offset = 20){
        (new ThemePager())->goCheck();

        $theme = ThemeModel::getCompleteTheme($id, $page, $offset);
        if(!$theme){
            throw new ThemeMiss();
        }

        return $theme;
    }

    /**
     * @URL /theme?ids=id1,id2,id3...
     */
    public function getSimpleList($ids = ''){
        (new IDCollection())->goCheck();

        $themes = ThemeModel::getThemesByIDs($ids);
        if(!$themes){
            throw new ThemeMiss();
        }

        return $themes;
    }
}