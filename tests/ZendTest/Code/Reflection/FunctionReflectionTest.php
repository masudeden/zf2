<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Code
 */

namespace ZendTest\Code\Reflection;

use Zend\Code\Reflection\FunctionReflection;

/**
 * @category   Zend
 * @package    Zend_Reflection
 * @subpackage UnitTests
 * @group      Zend_Reflection
 * @group      Zend_Reflection_Function
 */
class FunctionReflectionTest extends \PHPUnit_Framework_TestCase
{
    public function testParemeterReturn()
    {
        $function = new FunctionReflection('array_splice');
        $parameters = $function->getParameters();
        $this->assertEquals(count($parameters), 4);
        $this->assertInstanceOf('Zend\Code\Reflection\ParameterReflection', array_shift($parameters));
    }

    public function testFunctionDocBlockReturn()
    {
        require_once __DIR__ . '/TestAsset/functions.php';
        $function = new FunctionReflection('ZendTest\Code\Reflection\TestAsset\function3');
        $this->assertInstanceOf('Zend\Code\Reflection\DocBlockReflection', $function->getDocBlock());
    }

    public function testInternalFunctionBodyReturn()
    {
        $function = new FunctionReflection('array_splice');
        $this->setExpectedException('Zend\Code\Reflection\Exception\InvalidArgumentException');
        $body = $function->getBody();
    }

    public function testFunctionBodyReturn()
    {
        require_once __DIR__ . '/TestAsset/functions.php';

        $function = new FunctionReflection('ZendTest\Code\Reflection\TestAsset\function1');
        $body = $function->getBody();
        $this->assertEquals("return 'function1';", trim($body));

        $function = new FunctionReflection('ZendTest\Code\Reflection\TestAsset\function4');
        $body = $function->getBody();
        $this->assertEquals("return 'function4';", trim($body));

        $function = new FunctionReflection('ZendTest\Code\Reflection\TestAsset\function5');
        $body = $function->getBody();
        $this->assertEquals("return 'function5';", trim($body));

        $function = new FunctionReflection('ZendTest\Code\Reflection\TestAsset\function6');
        $body = $function->getBody();
        $this->assertEquals("\$closure = function() { return 'bar'; };\n    return 'function6';", trim($body));
    }

    public function testFunctionClosureBodyReturn()
    {
        require_once __DIR__ . '/TestAsset/closures.php';

        $function = new FunctionReflection($function1);
        $body = $function->getBody();
        $this->assertEquals("return 'function1';", trim($body));

        $function = new FunctionReflection($function2);
        $body = $function->getBody();
        $this->assertEquals("return 'function2';", trim($body));

        $function = new FunctionReflection($function3);
        $body = $function->getBody();
        $this->assertEquals("return 'function3';", trim($body));

        $function = new FunctionReflection($function4);
        $body = $function->getBody();
        $this->assertEquals("\$closure = function() { return 'bar'; };\n    return 'function4';", trim($body));
    }
}
