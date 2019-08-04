<?php

namespace ScorpioTek\Reports;

class ReportTable {
    
    private $table;
    
    public function __construct( $table_caption, $table_width_percent ) {
        $this->create_table( $table_caption, $table_width_percent );
    }

    private function create_table( $table_caption, $table_width_percent ) {
        $this->set_table( 
            sprintf( '<table id="report" class="emp-sales" width="%1$s" style="margin-left: auto; margin-right: auto";><caption>%2$s</caption>', $table_width_percent, $table_caption )
        );
    }

    public function set_table_headers( $header_array_titles ) {
        $table_header = '<thead><tr><td></td>';
        foreach ( $header_array_titles as $header_array_title ) {
            $table_header .= sprintf( '<th scope="col">%1$s</th>', $header_array_title );
        }
        $table_header .= '</tr></thead>';
        return $this->append_table( $table_header );
    }

    public function generate_table_body( $row_collection ) {
        $body_buffer = '<tbody>';
        foreach ( $row_collection as $row ) {
            $first_column = true;
            $body_buffer .= '<tr>';
            foreach ( $row as $column ) {
                if ( $first_column ) {
                    $body_buffer .= sprintf( '<th scope="row">%1$s</th>', $column );
                    $first_column = false;
                }
                else {
                    $body_buffer .= sprintf( '<td>%1$s</td>', $column );
                }                
            }
            $body_buffer .= '</tr>';
        }
        $body_buffer .= '</tbody></table>';
        $this->append_table( $body_buffer );
        return $body_buffer;
    }


    /**
     * Setter for table
     *
     * @param string $table the new value of the table property.
     */
    public function set_table( $table ) {
        $this->table = $table;
    }
    /**
     * Getter for the table property.
     */
    public function get_table() {
        return $this->table;
    }
    /**
     * Append data to the table.
     */
    public function append_table( $data_to_append ) {
        $table_appended = $this->get_table() . $data_to_append;
        $this->set_table( $table_appended );
        return $table_appended;
    }




}