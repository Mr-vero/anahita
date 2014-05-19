<?php

/** 
 * LICENSE: ##LICENSE##
 * 
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Controller_Behavior
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @copyright  2008 - 2014 rmdStudio Inc.
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.GetAnahita.com
 */

/**
 * Hashtagable Behavior
 *
 * @category   Anahita
 * @package    Com_Base
 * @subpackage Controller_Behavior
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @link       http://www.GetAnahita.com
 */
class ComBaseControllerBehaviorHashtagable extends KControllerBehaviorAbstract 
{	
	/** 
     * Constructor.
     *
     * @param KConfig $config An optional KConfig object with configuration options.
     * 
     * @return void
     */ 
    public function __construct(KConfig $config)
    {
        parent::__construct($config);
        
        $this->registerCallback('after.add', array($this, 'addHashtagsFromBody'));
        $this->registerCallback('after.edit', array($this, 'updateHashtagsFromBody'));
    }
	
	/**
	 * Extracts hashtag terms from the entity body and add them to the item. 
	 *
	 * @return void
	 */
	public function addHashtagsFromBody()
	{
		$entity = $this->getItem();
		$terms = $this->extractHashtagTerms($entity->body);

    	foreach($terms as $term)
        	$entity->addHashtag(trim($term));
	}
	
	/**
	 * Extracts hashtag terms from the entity body and updates the entity 
	 *
	 * @param  KCommandContext $context
	 * @return boolean
	 */
	public function updateHashtagsFromBody(KCommandContext $context)
	{
		$entity = $this->getItem();		
		$terms = $this->extractHashtagTerms($entity->body);

		foreach($entity->hashtags as $hashtag)
			if(!in_array($hashtag->name, $terms))
       			$entity->removeHashtag($hashtag->name);		
		
    	foreach($terms as $term)
        	$entity->addHashtag(trim($term));
	}
	
	/**
	 * extracts a list of hashtag terms from a given text
	 * 
	 * @return array
	 */
	public function extractHashtagTerms($text)
	{
        $matches = array();
        
        if(preg_match_all(ComHashtagsDomainEntityHashtag::PATTERN_HASHTAG, $text, $matches))
        {
        	return array_unique($matches[1]);
        }
        else
        	return array();
	}
}