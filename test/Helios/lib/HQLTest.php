<?php

namespace Helios\Test;

use     Helios\Helios,
        Helios\HQL;

/**
 * Test class for Helios_HQL.
 * Generated by PHPUnit on 2010-02-15 at 21:58:49.
 */
class HQLTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Helios_HQL
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new HQL;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     *
     */
    public function testFrom()
    {
        $field = Helios::TYPE_FIELD_NAME;

        $this->object->from( 'Blazing, Arrow, NIA' );
        $this->assertEquals( "($field:Blazing OR $field:Arrow OR $field:NIA)", $this->object->build() );

        $this->object->from( "Blazing,Arrow,NIA" );
        $this->assertEquals( "($field:Blazing OR $field:Arrow OR $field:NIA)", $this->object->build() );

        $this->object->from( "Blazing, Arrow, " );
        $this->assertEquals( "($field:Blazing OR $field:Arrow)", $this->object->build( ) );

        $this->object->from( " Blazing,Arrow, " );
        $this->assertEquals( "($field:Blazing OR $field:Arrow)", $this->object->build( ) );
    }

    /**
     *
     */
    public function testAddFrom()
    {
        $field = Helios::TYPE_FIELD_NAME;

        $this->object->from( 'Blazing, Arrow' );

        $this->object->addFrom( 'NIA, Craft' );

        $this->assertEquals( "($field:Blazing OR $field:Arrow OR $field:NIA OR $field:Craft)", $this->object->build( ) );
    }

    /**
     *
     */
    public function testOrder()
    {
        $this->object->orderBy( 'foo desc' );
        $this->assertEquals( array( 'sort' => 'foo desc' ), $this->object->params( ) );

        $this->object->orderBy( 'foo desc, bar asc' );
        $this->assertEquals( array( 'sort' => 'foo desc,bar asc' ), $this->object->params( ) );
    }

    /**
     *
     */
    public function testAddOrder()
    {
        $this->object->orderBy( 'foo desc' );
        $this->assertEquals( array( 'sort' => 'foo desc' ), $this->object->params( ) );

        $this->object->addOrderBy( 'bar asc, foobar asc' );
        $this->assertEquals( array( 'sort' => 'foo desc,bar asc,foobar asc' ), $this->object->params( ) );
    }

    /**
     *
     */
    public function testWhere()
    {
        $this->object->where( 'foo = ?', 'value' );
        $this->assertEquals( '(foo:"value")', $this->object->build( ) );

        $this->object->where( 'foo = ? AND bar = ?', array( 1, 2 ) );
        $this->assertEquals( '(foo:"1" AND bar:"2")', $this->object->build( ) );

        $this->object->where( 'foo = ? OR bar = ?', array( 1, 2 ) );
        $this->assertEquals( '(foo:"1" OR bar:"2")', $this->object->build( ) );

        $this->object->where( 'bar != ?', array( 1 ) );
        $this->assertEquals( '((*:* -bar:"1"))', $this->object->build( ) );

        $this->object->where( 'foo = ?', 'value1' );
        $this->object->orWhere( 'bar = ?', 'value2' );
        $this->assertEquals( '(foo:"value1") OR (bar:"value2")', $this->object->build( ) );

        $this->object->where( 'foo = ?', 'value1' );
        $this->object->andWhere( 'bar = ?', 'value2' );
        $this->assertEquals( '(foo:"value1") AND (bar:"value2")', $this->object->build( ) );

        $this->object->where( 'foo BETWEEN ? AND ?', array( 10, 20 ) );
        $this->assertEquals( '(foo:[10 TO 20])', $this->object->build( ) );

        $this->object->where( 'foo NOT BETWEEN ? AND ?', array( 10, 20 ) );
        $this->assertEquals( '((*:* -foo:[10 TO 20]))', $this->object->build( ) );
    }

    /**
     *
     */
    public function testAndWhere()
    {
        $this->object->where( 'foo = ?', 'value1' );
        $this->object->andWhere( 'bar = ?', 'value2' );
        $this->assertEquals( '(foo:"value1") AND (bar:"value2")', $this->object->build( ) );
    }

    /**
     *
     */
    public function testOrWhere()
    {
        $this->object->where( 'foo = ?', 'value1' );
        $this->object->orWhere( 'bar = ?', 'value2' );
        $this->assertEquals( '(foo:"value1") OR (bar:"value2")', $this->object->build( ) );
    }

    /**
     * @todo Implement testParams().
     */
    public function testParams()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     *
     */
    public function testEscape()
    {
        // + - && || ! ( ) { } [ ] ^ " ~ * ? : \

        $this->assertEquals( '\+', HQL::escape( '+' ) );
        $this->assertEquals( '\-', HQL::escape( '-' ) );
        $this->assertEquals( '\&&', HQL::escape( '&&' ) );
        $this->assertEquals( '\||', HQL::escape( '||' ) );
        $this->assertEquals( '\!', HQL::escape( '!' ) );
        $this->assertEquals( '\(', HQL::escape( '(' ) );
        $this->assertEquals( '\)', HQL::escape( ')' ) );
        $this->assertEquals( '\{', HQL::escape( '{' ) );
        $this->assertEquals( '\}', HQL::escape( '}' ) );
        $this->assertEquals( '\[', HQL::escape( '[' ) );
        $this->assertEquals( '\]', HQL::escape( ']' ) );
        $this->assertEquals( '\^', HQL::escape( '^' ) );
        $this->assertEquals( '\"', HQL::escape( '"' ) );
        $this->assertEquals( '\~', HQL::escape( '~' ) );
        $this->assertEquals( '\*', HQL::escape( '*' ) );
        $this->assertEquals( '\?', HQL::escape( '?' ) );
        $this->assertEquals( '\:', HQL::escape( ':' ) );
        $this->assertEquals( '\\\\', HQL::escape( '\\' ) );
    }
}