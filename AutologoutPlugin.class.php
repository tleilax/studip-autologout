<?php
/**
 * AutologoutPlugin.class.php
 *
 * Automatically redirects the user to the logout after an
 * inactivity time (defined by config entry).
 *
 * @author  Jan-Hendrik Willms <tleilax+studip@gmail.com>
 * @version 1.0
 */

class AutologoutPlugin extends StudIPPlugin implements SystemPlugin
{
    public function __construct()
    {
        parent::__construct();

        $meta = sprintf('<meta http-equiv="refresh" content="%u; URL=%s">',
                        Config::get()->AUTOMATIC_LOGOUT_DELAY * 60,
                        URLHelper::getLink('logout.php'));
        $attributes = array(
            'id'         => 'autologout',
            'data-delay' => Config::get()->AUTOMATIC_LOGOUT_DELAY * 60,
        );
        PageLayout::addHeadElement('noscript', $attributes, $meta);
        PageLayout::addScript($this->getPluginURL() . '/assets/autologout.js');
    }
}
