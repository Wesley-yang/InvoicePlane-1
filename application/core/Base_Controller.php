<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author		InvoicePlane Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2017 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 */

/**
 * Class Base_Controller
 */
class Base_Controller extends MX_Controller
{
    public $ajax_controller = false;

    public function __construct()
    {
        parent::__construct();

        $this->config->load('invoice_plane');

        // Don't allow non-ajax requests to ajax controllers
        if ($this->ajax_controller and !$this->input->is_ajax_request()) {
            exit;
        }

        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('trans');
        $this->load->library('encryption');

        // Check if database has been configured
        if (!env_bool('SETUP_COMPLETED')) {

            $this->load->helper('redirect');
            redirect('/welcome');

        } else {

            $this->load->database();
            $this->load->library('form_validation');
            $this->load->helper('number');
            $this->load->helper('pager');
            $this->load->helper('invoice');
            $this->load->helper('date');
            $this->load->helper('redirect');

            // Load setting model and load settings
            $this->load->model('settings/mdl_settings');
            $this->mdl_settings->load_settings();

            $this->lang->load('ip', $this->mdl_settings->setting('default_language'));
            $this->lang->load('form_validation', $this->mdl_settings->setting('default_language'));
            $this->lang->load('custom', $this->mdl_settings->setting('default_language'));

            $this->load->helper('language');

            $this->load->module('layout');

        }
    }
}
