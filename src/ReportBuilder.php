<?php

namespace ScorpioTek\Reports;

class ReportBuilder {

    private $template_names_list;
    
    /**
     * __construct - creates an instance of the Email Report Creator
     *
     * @param  string $template_name - the template name of the function to load.
     *
     * @return void
     */
    public function __construct( $template_name = 'default' ) {
        $this->template_names_list = $this->load_template_names();
        if ( !\in_array( $template_name, $this->template_names_list )  ) {
            throw new \Exception("Error Processing Request", 1);
        }
    }

    private function load_template_names() {
        // Define the templates directory.
        $dir = \dirname(__DIR__, 1) .  '/templates';
        // Get all files inside the templates directory that have the html extension.
        $template_files = glob( $dir . '/*.html' );
        $allowed_template_names = array();
        // Create an array with just the name of the template file without the extension.
        foreach ($template_files as  $template_file) {
            $allowed_template_names[] = \basename( $template_file, '.html' );
        }
        return $allowed_template_names;
    }



/**
 * Setter for template_names_list
 *
 * @param string $template_names_list the new value of the template_names_list property.
 */
public function set_template_names_list( $template_names_list ) {
	$this->template_names_list = $template_names_list;
}
/**
 * Getter for the template_names_list property.
 */
public function get_template_names_list() {
	return $this->template_names_list;
}

}