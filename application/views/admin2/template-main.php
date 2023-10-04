<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $this->load->view('admin2/template-header'); ?>

<?php $this->load->view('admin2/template-menu'); ?>

    <main id="main-scrollbar">
        <section id="layout-dashboard">
            <div class="layout-right">
                <div class="main">
	                <?php $this->view("admin2/".$pageview); ?>
                </div>
            </div>
        </section>
    </main>

<?php $this->load->view('admin2/template-footer'); ?> 