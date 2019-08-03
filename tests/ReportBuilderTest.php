<?php

namespace ScorpioTek\Reports\Tests;
use PHPUnit\Framework\TestCase;
use ScorpioTek\Reports\ReportBuilder;

class ReportBuilderTests extends TestCase  {
    public function testClassExists()
    {
        $this->assertTrue(class_exists('ScorpioTek\Reports\ReportBuilder'));
    }

    public function testConstructorDefaultParameter() {
        $rp = new ReportBuilder();
        \fwrite(STDERR, var_dump($rp, TRUE));
        $this->assertEquals( $rp->get_template_names_list(), array( 'default', 'tables' ) ) ;
    }

    public function testConstructorCustomParameter() {
        $rp = new ReportBuilder('default');
        // \fwrite(STDERR, var_dump($rp, TRUE));
        $this->assertEquals( $rp->get_template_names_list(), array( 'default', 'tables' ) ) ;
    }

    

    public function testThisShouldFail() {
        $this->assertEquals ( 1, 1 );
    }
}