<?php
/**
 * HttpAuthFilter class file.
 *
 * @license BSD
 */

/**
 * HttpAuthFilter performs authorization checks using http authentication
 *
 * By enabling this filter, controller actions can be limited to a couple of users.
 * It is very simple, supply a list of usernames and passwords and the controller actions 
 * will be restricted to only those. Nothing fancy, it just keeps out users.
 * 
 * To specify the authorized users specify the 'users' property of the filter
 * Example:
 * <pre>
 *
 *	public function filters()
 *	{
 *		return array(
 *           array(
 *			'HttpAuthFilter',
 *                'users'=>array('admin'=>'admin'), 
 *                'realm'=>'Admin section'
 *                  )  
 *            );
 *	}
 * The default section for the users property is 'admin'=>'admin' change it
 *
 */
class HttpAuthFilter extends CFilter
{
	/**
	 * @return array list of authorized users/passwords
	 */
	public $users=array('admin'=>'admin',);

	/**
	 * @return string authentication realm
	 */
    public $realm='Authentication needed'; 

	/**
	 * Performs the pre-action filtering.
	 * @param CFilterChain the filter chain that the filter is on.
	 * @return boolean whether the filtering process should continue and the action
	 * should be executed.
	 */
	protected function preFilter($filterChain)
	{
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) 
        {
            $username=$_SERVER['PHP_AUTH_USER'];
            $password=$_SERVER['PHP_AUTH_PW'];
            
            if($this->users[$username]==$password)
            {
                return true;
            }                

        }
        header("WWW-Authenticate: Basic realm=\"".$this->realm."\"");  
        throw new CHttpException(401,Yii::t('yii','You are not authorized to perform this action.'));
	}
}

