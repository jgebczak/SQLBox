<?php

class Html {

//----------------------------------------------------------------------------------------------------------------------

    static function option($name,$label,$value,$selected=0)
    {
        if (!$label) $label = $name;
        if ($selected) $s = "selected='selected'";
        return "<option $s id='$name' name='$name' value='$value'>$label</option>";
    }

//----------------------------------------------------------------------------------------------------------------------

    static function checkbox($name,$label,$selected=0)
    {
        if (!$label) $label = $name;
        if ($selected) $c = "checked";
        return "<input type='checkbox' name='$name' id='$name' value='1' $c> $label";
    }

//----------------------------------------------------------------------------------------------------------------------


}

