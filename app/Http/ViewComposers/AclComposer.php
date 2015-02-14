<?php namespace App\Http\ViewComposers;

use App\Helper\AclHelper;
use Illuminate\Contracts\View\View;

/**
 * Description of MaterialComposer
 *
 * @author Christian
 */
class AclComposer {
    
    private $aclHelper;
    
    public function __construct(AclHelper $aclHelper)
    {
        $this->aclHelper = $aclHelper;
    }
    
    public function compose(View $view)
    {
        $view->with('acl', $this->aclHelper);
    }
    
}
