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
        $this->assertEquals( $rp->get_template_names_list(), array( 'default', 'tables' ) ) ;
    }

    public function testConstructorCustomParameter() {
        $rp = new ReportBuilder('default');
        $this->assertEquals( $rp->get_template_names_list(), array( 'default', 'tables' ) ) ;
    }
}