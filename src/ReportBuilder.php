<?php

namespace ScorpioTek\Reports;

class ReportBuilder {

    private $template_names_list;
    private $template_content;
    private $template_name;
    private $subject;
    private $recipients;
    private $email_body;
    private $report_data;
    private $salutation;
    private $email_closer;
    private $email_footer;
    private $sender;
    private $logo_url;
    
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
        $this->set_template_name( $template_name );
        $this->load_template_file(); 
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

    private function load_template_file() {
        $plugin_directory = dirname( __DIR__ );
        $this->set_template_content( file_get_contents(  $plugin_directory . '/templates/'  . $this->get_template_name() . '.html' ) );
    }
    public function prepare_template( $mobile_headers) {
        if ( ! empty ( $this->get_logo_url() ) ) $this->set_template_content( str_replace( '%logo_url%', $this->get_logo_url(), $this->get_template_content() ) );
        if ( ! empty ( $this->get_email_footer() ) ) $this->set_template_content( str_replace( '%email_footer%', $this->get_email_footer(), $this->get_template_content() ) );
        // Load salutation, insert generic if it was not set.
        if ( empty ( $this->get_salutation() ) ) $this->set_salutation( __( 'Hello,', 'report-builder' ) );
        $this->set_template_content( str_replace( '%salution%', $this->get_salutation(), $this->get_template_content() ) );
        // Load closer, insert generic if it was not set.
        if ( empty ( $this->get_email_closer() ) ) $this->set_email_closer( __( 'Regards,', 'report-builder' ) );
        $this->set_template_content( str_replace( '%email_closer%', $this->get_email_closer(), $this->get_template_content() ) );
        // Load report email body. insert generic if it was not set.
        if ( empty ( $this->get_email_body() ) ) $this->set_email_body( __( 'Report information is included below.', 'report-builder' ) );
        $this->set_template_content( str_replace( '%email_body%', $this->get_email_body(), $this->get_template_content() ) );
        // Load report data, include generic data if it is empty.
        if ( empty ( $this->get_report_data() ) ) $this->set_report_data( __( 'No report data this month.', 'report-builder' ) );
        $this->set_template_content( str_replace( '%report_data%', $this->get_report_data(), $this->get_template_content() ) );
        
        $mobile_header_css = "";
        for ( $headers_counter = 1; $headers_counter <= count( $mobile_headers ); $headers_counter++ ) {
            $mobile_header_css .= sprintf( '#report td:nth-of-type(%1$d):before { content: "%2$s"; }%3$s',
                $headers_counter,
                $mobile_headers[$headers_counter - 1],
                "\r\n"
            );
        }
        $this->set_template_content( str_replace( '%mobile_colums%', $mobile_header_css, $this->get_template_content() ) );
    }

    public function send_report() {
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $this->get_sender(),
        );
        wp_mail( $this->get_recipients(), $this->get_subject(), $this->get_template_content(), $headers );        
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

   /**
     * Setter for subject
     *
     * @param string $subject the new value of the subject property.
     */
    public function set_subject( $subject ) {
        $this->subject = $subject;
    }
    /**
     * Getter for the subject property.
     */
    public function get_subject() {
        return $this->subject;
    }

    /**
     * Setter for recipients
     *
     * @param string $recipients the new value of the recipients property.
     */
    public function set_recipients( $recipients ) {
        $this->recipients = $recipients;
    }
    /**
     * Getter for the recipients property.
     */
    public function get_recipients() {
        return $this->recipients;
    }

    /**
     * Setter for email_body
     *
     * @param string $email_body the new value of the email_body property.
     */
    public function set_email_body( $email_body ) {
        $this->email_body = $email_body;
    }
    /**
     * Getter for the email_body property.
     */
    public function get_email_body() {
        return $this->email_body;
    }
    /**
     * Appends text to the email body
     *
     * @param string $email_body the value to append to the email_body property.
     */
    public function append_email_body( $email_body ) {
        $this->email_body = $this->email_body . $email_body;
    }

    /**
     * Setter for sender
     *
     * @param string $sender the new value of the sender property.
     */
    public function set_sender( $sender ) {
        $this->sender = $sender;
    }
    /**
     * Getter for the sender property.
     */
    public function get_sender() {
        return $this->sender;
    }

    /**
     * Setter for logo_url
     *
     * @param string $logo_url the new value of the logo_url property.
     */
    public function set_logo_url( $logo_url ) {
        $this->logo_url = $logo_url;
        return $this;
    }
    /**
     * Getter for the logo_url property.
     */
    public function get_logo_url() {
        return $this->logo_url;
    }

    /**
     * Setter for template_content
     *
     * @param string $template_content the new value of the template_content property.
     */
    public function set_template_content( $template_content ) {
        $this->template_content = $template_content;
    }
    /**
     * Getter for the template_content property.
     */
    public function get_template_content() {
        return $this->template_content;
    }

    /**
     * Setter for template_name
     *
     * @param string $template_name the new value of the template_name property.
     */
    public function set_template_name( $template_name ) {
        $this->template_name = $template_name;
    }
    /**
     * Getter for the template_name property.
     */
    public function get_template_name() {
        return $this->template_name;
    }

    /**
     * Setter for salutation
     *
     * @param string $salutation the new value of the salutation property.
     */
    public function set_salutation( $salutation ) {
        $this->salutation = $salutation;
    }
    /**
     * Getter for the salutation property.
     */
    public function get_salutation() {
        return $this->salutation;
    }

    /**
     * Setter for email_closer
     *
     * @param string $email_closer the new value of the email_closer property.
     */
    public function set_email_closer( $email_closer ) {
        $this->email_closer = $email_closer;
    }
    /**
     * Getter for the email_closer property.
     */
    public function get_email_closer() {
        return $this->email_closer;
    }

    /**
     * Setter for email_footer
     *
     * @param string $email_footer the new value of the email_footer property.
     */
    public function set_email_footer( $email_footer ) {
        $this->email_footer = $email_footer;
    }
    /**
     * Getter for the email_footer property.
     */
    public function get_email_footer() {
        return $this->email_footer;
    }

    /**
     * Setter for report_data
     *
     * @param string $report_data the new value of the report_data property.
     */
    public function set_report_data( $report_data ) {
        $this->report_data = $report_data;
    }
    /**
     * Getter for the report_data property.
     */
    public function get_report_data() {
        return $this->report_data;
    }
}