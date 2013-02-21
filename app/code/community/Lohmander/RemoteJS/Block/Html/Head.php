<?php
/**
 * RemoteJS
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     Lohmander_RemoteJS
 * @license     http://www.gnu.org/licenses/gpl-3.0.txt
 */
class Lohmander_RemoteJS_Block_Html_Head
    extends Mage_Page_Block_Html_Head
{
    /**
     * Initialize template
     *
     */
    protected function _construct()
    {
        $this->setTemplate('page/html/head.phtml');
    }

    /**
    * Add Javascript located on remote server
    *
    * @param string $name
    * @param string $params
    * @return Lohmander_RemoteJS_Block_Html_Head
    * @deprecated 0.2.0
    */
    public function addRemoteJs($name, $params = "")
    {
        $this->addItem('js', $name, $params);
        return this;
    }

    /**
    * Add CSS stylsheet located on remote server
    *
    * @param string @name
    * @param string @params
    * @return Lohmander_RemoteJS_Block_Html_Head
    * @deprecated 0.2.0
    */
    public function addRemoteCss($name, $param = "")
    {
        $this->addItem('css', $name, $params);
        return $this;
    }

    protected function &_prepareStaticAndSkinElements($format, array $staticItems, array $skinItems, $mergeCallback = null)
    {
        $designPackage = Mage::getDesign();
        $baseJsUrl = Mage::getBaseUrl('js');
        $items = array();
        if ($mergeCallback && !is_callable($mergeCallback)) {
            $mergeCallback = null;
        }


        // get static files from the js folder, no need in lookups
        foreach ($staticItems as $params => $rows) {
            foreach ($rows as $name) {
                if (substr($name, 0, 2) == '//'
                    || substr($name, 0, 7) == 'http://'
                    || substr($name, 0, 7) == 'https://') {
                    $items[$params][] = $name;
                } else {
                    $items[$params][] = $mergeCallback ? Mage::getBaseDir() . DS . 'js' . DS . $name : $baseJsUrl . $name;
                }
            }
        }

        // lookup each file basing on current theme configuration
        foreach ($skinItems as $params => $rows) {
            foreach ($rows as $name) {
                $items[$params][] = $mergeCallback ? $designPackage->getFilename($name, array('_type' => 'skin'))
                    : $designPackage->getSkinUrl($name, array());
            }
        }

        $html = '';
        foreach ($items as $params => $rows) {
            // attempt to merge
            $mergedUrl = false;
            if ($mergeCallback) {
                $mergedUrl = call_user_func($mergeCallback, $rows);
            }
            // render elements
            $params = trim($params);
            $params = $params ? ' ' . $params : '';
            if ($mergedUrl) {
                $html .= sprintf($format, $mergedUrl, $params);
            } else {
                foreach ($rows as $src) {
                    $html .= sprintf($format, $src, $params);
                }
            }
        }
        return $html;
    }
}
