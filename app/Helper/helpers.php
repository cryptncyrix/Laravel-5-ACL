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
