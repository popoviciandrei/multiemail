<?php

/**
 *
 * @category  Popovici
 * @package   Popovici_Multiemail
 * @author    Andrei Popovici <me@andreipopovici.co.uk>
 * @copyright Copyright (c) 2016 Andrei Popovici (http://www.andreipopovici.co.uk/)
 * @date      28/04/2016 09:52
 */
class Popovici_Multiemail_Model_Core_Translate extends Mage_Core_Model_Translate
{

    /**
     * Retrieve translated template from inside the current theme if available first
     * @param string $file
     * @param string $type
     * @param null $localeCode
     * @return string
     * @author   Andrei Popovici <me@andreipopovici.co.uk>
     */
    public function getTemplateFile($file, $type, $localeCode = null)
    {
        if (!Mage::helper('popovici_multiemail')->isFallbackEnabled()) {
            return parent::getTemplateFile($file, $type, $localeCode);
        }

        if (is_null($localeCode) || preg_match('/[^a-zA-Z_]/', $localeCode)) {
            $localeCode = $this->getLocale();
        }

        /** Checking if we are in a different area than the one on init, then load the frontend area & associated theme */
        if(Mage::getDesign()->getArea() != Mage_Core_Model_Design_Package::DEFAULT_AREA && Mage::app()->getStore()->getId() != 0) {
            $beforeArea = Mage::getDesign()->getArea();
            $beforePackageName = Mage::getDesign()->getPackageName();
            Mage::getDesign()->setArea(Mage_Core_Model_Design_Package::DEFAULT_AREA);
            Mage::getDesign()->setPackageName();
        }

        $params = array('_type' => 'locale', '_area' => Mage_Core_Model_Design_Package::DEFAULT_AREA);

        $filePath = Mage::getDesign()->getBaseDir($params)
            . DS . $localeCode
            . DS . 'template' . DS . $type . DS . $file;

        if (!file_exists($filePath)) {
            $filePath = Mage::getDesign()->getBaseDir($params)
                . DS . Mage::app()->getLocale()->getDefaultLocale()
                . DS . 'template' . DS . $type . DS . $file;
        }

        if (!file_exists($filePath)) {
            $filePath = Mage::getDesign()->getBaseDir($params)
                . DS . Mage_Core_Model_Locale::DEFAULT_LOCALE
                . DS . 'template' . DS . $type . DS . $file;
        }

        /** Restore design area & package */
        if($beforeArea) {
            Mage::getDesign()->setArea($beforeArea);
            Mage::getDesign()->setPackageName($beforePackageName);
        }

        if (!file_exists($filePath)) {
            return parent::getTemplateFile($file, $type, $localeCode);
        }

        $ioAdapter = new Varien_Io_File();
        $ioAdapter->open(array('path' => Mage::getBaseDir('locale')));

        return (string)$ioAdapter->read($filePath);
    }
}