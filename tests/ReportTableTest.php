<?php

namespace ScorpioTek\Reports\Tests;
use PHPUnit\Framework\TestCase;
use ScorpioTek\Reports\ReportTable;

class ReportTableTests extends TestCase  {
    public function testClassExists()
    {
        $this->assertTrue(class_exists('ScorpioTek\Reports\ReportTable'));
    }

    public function testTableHeaderCreation() {
        $rt = new ReportTable( 'Test Header Creation', '90' );
        $table_initial = $rt->get_table();
        $actual = $rt->set_table_headers( array('Test') );
        $expected = $table_initial . '<thead><tr><td></td><th scope="col">Test</th></tr></thead>';
        $this->assertEquals( $expected, $actual );
    }

    public function testTableBodyGeneration() {
        $rt = new ReportTable( 'Test Body Creation', '90' );
        $simulation_data = array(
            array( 'Jim', '24' ),
            array( 'Chris', '43' ),
        );
        $actual = $rt->generate_table_body( $simulation_data );
        $expected = '<tbody><tr><th scope="row">Jim</th><td>24</td></tr><tr><th scope="row">Chris</th><td>43</td></tr></tbody></table>';
        $this->assertEquals( $expected, $actual );
    }
}