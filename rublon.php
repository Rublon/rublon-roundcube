<?php
use Rublon\Rublon as RublonSdk;
use Rublon\RublonCallback;
use Rublon\Core\Exceptions\Api\UserBypassedException;

class rublon extends rcube_plugin {

    private $rcmail;

    private $rcubeUrl;

    function init()
    {
        $this->rcmail = rcmail::get_instance();
        $this->load_config();

        $this->add_hook('send_page', array($this, 'rublon_check'));
        $this->add_hook('login_after', array($this, 'login_after'));
        $this->register_action('plugin.rublon-callback', array($this, 'rublon_callback'));
        $this->rcubeUrl = $this->rcmail->config->get('rcubeUrl',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']).'/?_action=plugin.rublon-callback';
    }

    function login_after($args) {
        $_SESSION['_Rublon_2FA'] = false;

        $rublon = new RublonSdk(
            $this->rcmail->config->get('client'),
            $this->rcmail->config->get('secret'),
            $this->rcmail->config->get('rublonApi')
        );

        try {
            $url = $rublon->auth(
                $this->rcubeUrl,
                $this->rcmail->user->data['username'], // App User ID
                $this->rcmail->user->data['username']// User email
            );

            if (!empty($url)) { // User protection is active
                // Redirect the user's web browser to Rublon servers to verify the protection:
                header('Location: ' . $url);
                exit;

            }
        } catch (UserBypassedException $e) {
            $_SESSION['_Rublon_2FA'] = true;
            $this->rcmail->output->redirect(array('_task' => 'mail', 'action' => null));
        }
    }
    function rublon_callback() {

        $rublon = new RublonSdk(
            $this->rcmail->config->get('client'),
            $this->rcmail->config->get('secret'),
            $this->rcmail->config->get('rublonApi')
        );

        try {
            $callback = new RublonCallback($rublon);

            $callback->call(
                $successHandler = function($appUserId,  RublonCallback $callback) {
                    $_SESSION['_Rublon_2FA'] = true;
                },
                $cancelHandler = function(RublonCallback $callback) {

                    $_SESSION['_Rublon_2FA'] = false;
                    $this->rcmail->output->redirect(array('_task' => 'login', 'action' => null));
                }
            );

            $this->rcmail->output->redirect(array('_task' => 'mail', 'action' => null));
        } catch (UserBypassedException $e) {
            $this->rcmail->output->redirect(array('_task' => 'mail', 'action' => null));
        } catch (RublonException $e) {
            die($e->getMessage());
        }
        $this->rcmail->output->redirect(array('_task' => 'mail', 'action' => null));

    }
    function rublon_check($args) {

        if ($_SESSION['_Rublon_2FA']) {
            return $args;
        } else if ($this->rcmail->action == 'plugin.rublon-callback' || $this->rcmail->task == 'login') {
            return $args;
        }

        $this->rcmail->output->redirect(array('_task' => 'login', 'action' => null));

        return $args;
    }
}
