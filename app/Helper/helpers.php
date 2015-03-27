<?php

/**
 * hasResource
 * 
 * Check the Rights for the Resource
 * 
 * @param string $name
 * @return bool
 */
function hasResource($name)
{
    return app('aclhelper')->hasResource($name);
}

/**
 * @param string $fallBack
 * @return mixed
 */
function getSessionBackLink($fallBack)
{
    if(array_key_exists('back', \Session::all())){
        return \Session::pull('back');
    }
    return $fallBack;
}

/**
 * @param string $param
 * @return mixed
 */
function setSessionBackLink($param) {
    return \Session::put('back', $param);
}
