<?php

/**
 * People Permissions.
 *
 * @category   Anahita
 *
 * @author     Arash Sanieyan <ash@anahitapolis.com>
 * @author     Rastin Mehr <rastin@anahitapolis.com>
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 *
 * @link       http://www.GetAnahita.com
 */
class ComPeopleControllerPermissionPerson extends ComActorsControllerPermissionDefault
{
    /**
     * Flag to see whather registration is open or not.
     *
     * @var bool
     */
    protected $_can_register;

    /**
     * Viewer object.
     *
     * @var ComPeopleDomainEntityPerson
     */
    protected $_viewer;

    /**
     * Constructor.
     *
     * @param AnConfig $config An optional AnConfig object with configuration options.
     */
    public function __construct(AnConfig $config)
    {
        parent::__construct($config);

        $this->_can_register = $config->can_register;
        $this->_mixer->permission = $this;
    }

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
            'can_register' => (bool) get_config_value('people.allow_registration', true),
        ));

        $this->_viewer = get_viewer();

        parent::_initialize($config);
    }
    
    public function canSignup() 
    {
        if ($this->_viewer->guest() && $this->isRegistrationOpen()) {
            return true;
        }
        
        return false;
    }
    
    public function canRead() 
    {        
        if ($this->_viewer->guest() && $this->isRegistrationOpen() && !$this->getItem()) {
            return true;
        }
        
        return parent::canRead();
    }

    /**
     * return true if viewer is an admin or a guest.
     *
     * @return bool
     */
    public function canAdd()
    {
        if ($this->_viewer->admin()) {
            return true;
        }

        return false;
    }

    /**
     * return true if viewer has administration rights to the profile.
     *
     * @return bool
     */
    public function canEdit()
    {
        return $this->getItem()->authorize('administration');
    }

    /**
     * See if the controller allows to register.
     *
     * @param bool $can_register The value whether the user can register or not
     */
    public function setRegistrationOpen($can_register)
    {
        $this->_can_register = $can_register;
        return $this;
    }

    /**
     * Return whether the registration is open or not.
     *
     * @return bool
     */
    public function isRegistrationOpen()
    {
        return $this->_can_register;
    }

    /**
     * Return true if viewer is a guest.
     *
     * @return bool
     */
    public function canResetPassword()
    {
        return $this->_viewer->guest();
    }
}
