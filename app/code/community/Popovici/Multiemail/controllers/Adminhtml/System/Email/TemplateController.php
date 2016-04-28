<?php

require_once Mage::getModuleDir('controllers', 'Mage_Adminhtml') . DS . 'System' . DS . 'Email' . DS . 'TemplateController.php';

/**
 * Class Popovici_Multiemail_Adminthml_Sytem_Email_TemplateController
 *
 * @author   Andrei Popovici <me@andreipopovici.co.uk>
 */
class Popovici_Multiemail_Adminhtml_System_Email_TemplateController
    extends Mage_Adminhtml_System_Email_TemplateController
{

    /**
     * Set template data to retrieve it in template info form
     */
    public function defaultTemplateAction()
    {
        $storeId            = $this->getRequest()->getParam('store_identifier');

        if($storeId) {
            $currentStore = Mage::app()->getStore();
            Mage::app()->setCurrentStore($storeId);
        }

        parent::defaultTemplateAction();

        if($currentStore) {
            Mage::app()->setCurrentStore($currentStore);
        }
    }
}