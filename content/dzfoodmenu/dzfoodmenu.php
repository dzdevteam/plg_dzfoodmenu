<?php
/**
* @version     1.0.0
* @package     Joomla.Plugin
* @subpackage  Content.DZProduct
* @copyright   Copyright (C) 2013. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
* @author      DZ Team <dev@dezign.vn> - dezign.vn
*/

defined('_JEXEC') or die;

class PlgContentDZFoodMenu extends JPlugin
{
    protected $_type='content';
    protected $_name='dzfoodmenu';
    
    function __construct(&$subject, $config = array()) {
        parent::__construct(&$subject, $config = array());
        $this->loadLanguage();
    }
    
    public function onContentPrepareForm($form, $data)
    {
        if (!($form instanceof JForm))
        {
            $this->_subject->setError('JERROR_NOT_A_FORM');
            return false;
        }
        
        // Only inject our form when using categories with our extension
        if ($form->getName() != 'com_categories.categorycom_dzfoodmenu.dishes.catid')
            return true;
        
        // Add the extra fields to the form.
        JForm::addFormPath(dirname(__FILE__) . '/alternative');
        $form->loadFile('alternative', false);
        return true;
    }
}
