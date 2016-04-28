<?php
 /**
 *
 * @category  Default (Template) Project
 * @package   ${Module}
 * @author    Andrei Popovici <me@andreipopovici.co.uk>
 * @copyright Copyright (c) 2016 Andrei Popovici (http://www.andreipopovici.co.uk/)
 * @date      28/04/2016 09:18
 */ 
class Popovici_Multiemail_Helper_Data extends Mage_Core_Helper_Abstract {

    /**
     * @param null $store
     * @return bool
     * @todo add config return
     * @author   Andrei Popovici <me@andreipopovici.co.uk>
     */
    public function isFallbackEnabled($store = null){
        return true;
    }
}