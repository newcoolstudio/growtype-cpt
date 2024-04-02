<?php

class Growtype_Cpt_Customizer
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action('customize_register', array ($this, 'customizer_init'));
    }

    function customizer_init($wp_customize)
    {
    }
}
