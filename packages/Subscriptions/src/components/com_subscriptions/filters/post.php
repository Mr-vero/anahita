<?php

/**
 * Post filter.
 *
 * @category   Anahita
 *
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 *
 * @link       http://www.GetAnahita.com
 */
class ComSubscriptionsFilterHtml extends AnFilterHtml
{
    /**
     * Initializes the default configuration for the object.
     *
     * Called from {@link __construct()} as a first step of object instantiation.
     *
     * @param AnConfig $config An optional AnConfig object with configuration options.
     */
    protected function _initialize(AnConfig $config)
    {
        $config->append(array(
            'tag_list' => array('p', 'strike', 'u', 'pre', 'address', 'blockquote', 'b', 'i', 'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'h5'),
            'tag_method' => 0,
        ));

        parent::_initialize($config);

        if ($config->tag_list) {
            $config['tag_list'] = AnConfig::unbox($config->tag_list);
        }

        if ($config->tag_method) {
            $config['tag_method'] = AnConfig::unbox($config->tag_method);
        }
    }

//end class
}
