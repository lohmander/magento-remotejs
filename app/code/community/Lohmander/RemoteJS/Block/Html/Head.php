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
    */
    public function addRemoteJs($name, $params = "")
    {
        $this->addItem('remote_js', $name, $params);
        return this;
    }

    /**
    * Add CSS stylsheet located on remote server
    *
    * @param string @name
    * @param string @params
    * @return Lohmander_RemoteJS_Block_Html_Head
    */
    public function addRemoteCss($name, $param = "")
    {
        $this->addItem('remote_css', $name, $params);
        return $this;
    }

    /**
     * Classify HTML head item and queue it into "lines" array
     *
     * @see self::getCssJsHtml()
     * @param array &$lines
     * @param string $itemIf
     * @param string $itemType
     * @param string $itemParams
     * @param string $itemName
     * @param array $itemThe
     */
    protected function _separateOtherHtmlHeadElements(&$lines, $itemIf, $itemType, $itemParams, $itemName, $itemThe)
    {
        $params = $itemParams ? ' ' . $itemParams : '';
        $href   = $itemName;
        switch ($itemType) {
            case 'rss':
                $lines[$itemIf]['other'][] = sprintf('<link href="%s"%s rel="alternate" type="application/rss+xml" />',
                    $href, $params
                );
                break;
            case 'link_rel':
                $lines[$itemIf]['other'][] = sprintf('<link%s href="%s" />', $params, $href);
                break;
            case 'remote_js':
                $lines[$itemIf]['other'][] = sprintf('<script type="text/javascript" src="%s" %s></script>', $href, $params);
                break;
            case 'remote_css':
                $lines[$itemIf]['other'][] = sprintf('<link rel="stylesheet" type="text/css" href="%s" %s>', $href, $params);
                break;
        }
    }
}
