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
        
        // Load our language and form path
        $this->loadLanguage();
        JForm::addFormPath(dirname(__FILE__) . '/alternative');
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
        $form->loadFile('alternative', false);
        
        // Add our javascript to bring our hidden params fields' data into attribs fields
        JHtml::_('jquery.framework');
        JFactory::getDocument()->addScript(JUri::root().'media/plg_content_dzfoodmenu/dzfoodmenu.js');
        
        return true;
    }
    
    public function onContentBeforeSave($context, &$table, $isNew) {
        if ( !($context == 'com_categories.category' && JRequest::getCmd('extension') == 'com_dzfoodmenu.dishes.catid') )
            return true;
        
        // First get our form
        $form = new JForm('jform');
        $form->loadFile('alternative', false);
        
        // Then get our fields' data
        $data = JFactory::getApplication()->input->getArray( array('jform' => array('attribs' => 'array')) );
        $data = $form->filter($data['jform']);
        $result = $form->validate($data);
        if ($result === true) {
            $params = $table->params;
            $registry = new JRegistry($params);
            $params = $registry->toArray();
            
            $params = array_merge($params, $data['attribs']);
            $registry = new JRegistry($params);
            $table->params = $registry->toString();
        }
    }
}
